<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Project;
use Livewire\Component;
use App\Models\Material;
use App\Models\UserRole;
use App\Models\Inventory;
use App\Models\ProjectUser;
use App\Models\Requisition;
use App\Models\TotalBudget;
use Livewire\WithPagination;
use App\Models\ProjectBudget;
use App\Models\MaterialCategory;
use App\Models\ProjectBudgetExtra;
use Illuminate\Support\Facades\DB;
use App\Models\SupplementaryBudget;

class Details extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $budgetItemsPagination, $allRequisitionsPagination;

    public $projectId, $project, $client, $editClient = false, $userRoles, $projectUsers, $selectedUsers = [], $budgetId, $budgetqty;
    public $editQtyId = null, $editQty = false;
    //public $selectedCategory, $selectedMaterial, $unassignedMaterials, $assignedMaterials;
    public $search, $categories = [], $selectedMaterial, $materials = [], $selectedCategory, $materialsByCategory;
    public $selectedBudgetItem, $budgetItemName, $budgetItemCategory, $budgetItemQuantity, $budgetItemUnit;
    public $budgetItemId, $budgetBalance, $requisitionSum, $requisitionQuantity, $budgetActivity, $requisitionId;
    public $requisitionSearch, $inventorySearch, $vendors, $selectedVendor, $vendor_id;
    public $inventoryReceiver, $inventoryQuantity, $inventoryPurpose;
    public $totalMaterialQuantity, $selectedInventoryCategory, $selectedInventoryMaterial, $storeSearch;
    protected $budgetItems, $allRequisitions, $extraBudgetItems, $allBudgetItems, $storeItems;


    protected $rules = [

    ];

    public function mount($slug)
    {
        $this->project = Project::where('slug', $slug)->firstOrFail();
        $this->projectId = $this->project->id;
        $this->client = $this->project->client;
        $this->users = User::where('status', 1)->get(); //Fetch only active users

        $this->projectUsers = ProjectUser::all();

        $this->userRoles = UserRole::all();

        $this->vendors = Vendor::all();

        $this->categories = MaterialCategory::all(); // Fetch all material categories
        $this->materials = Material::with('unit')->get(); // Fetch all materials with their associated units
        $this->fetchRequisitions();
        $this->totalMaterialQuantity = $this->calculateTotalMaterialQuantity();
        //$this->fetchInventoryItems();
        $this->projectStore();
    }

    //-- CLIENT OPS --//
    public function toggleClient()
    {
        $this->editClient = !$this->editClient;
    }

    public function updateClient()
    {
        $validatedData = $this->validate([
            'client' => 'required|string',
        ]);
        $this->project->update([
            'client' => $validatedData['client'],
        ]);

        $this->editClient = false;
    }
    //-- END CLIENT OPS --//

    public function resetInput()
    {
        $this->selectedUsers = []; // Reset selected users for each user role
        $this->budgetItemId = null; // Reset budgetItemId
        $this->requisitionQuantity = null; // Reset requisitionQuantity
        $this->budgetActivity = null; // Reset budgetActivity

    }

    public function resetForm($fields = [])
    {
        foreach ($fields as $field) {
            $this->$field = '';
        }

    }

    //-- MODAL --//
    public function resetModal()
    {
        $this->reset([
            'selectedUsers',
            'selectedMaterials',
        ]);

        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->resetInput();
        $this->resetForm();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function closeModalAndRefresh()
    {
        $this->resetInput();
        $this->fetchAssignedAndUnassignedMaterials(); // Refresh assigned and unassigned materials
        $this->dispatchBrowserEvent('close-modal');
    }

    public function openModal()
    {
        $this->resetInput();
    }
    //-- END MODAL --//

    public function storeProjectTeam()
    {
        try {
            $projectId = $this->project->id;

            foreach ($this->selectedUsers as $userRoleId => $userId) {
                // Check if the project_user record already exists
                $existingRecord = DB::table('project_user')
                    ->where('project_id', $projectId)
                    ->where('role_id', $userRoleId)
                    ->first();

                if ($existingRecord) {
                    // Update the existing record
                    DB::table('project_user')
                        ->where('project_id', $projectId)
                        ->where('role_id', $userRoleId)
                        ->update(['user_id' => $userId]);
                } else {
                    // Create a new record
                    DB::table('project_user')->insert([
                        'project_id' => $projectId,
                        'user_id' => $userId,
                        'role_id' => $userRoleId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Redirect to the project details page
                $this->project->where('id', $projectId)->update(['status' => 1]);
            }

            session()->flash('message', 'Project Team updated.');
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
            $this->refreshProjectUsers();

            return redirect()->route('project.details', ['slug' => $this->project->slug]);

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database query exceptions
            // Log the error, show an error message, or perform any other necessary actions
        } catch (\Exception $e) {
            // Handle other exceptions
            // Log the error, show an error message, or perform any other necessary actions
        }
    }

    public function refreshProjectUsers()
    {
        $this->projectUsers = ProjectUser::where('project_id', $this->project->id)->get();
    }

    //-- BUDGETING --//
    public function fetchBudgetItems()
    {
        $this->budgetItems = ProjectBudget::with(['material', 'material.category', 'material.unit'])
            ->where('project_id', $this->projectId)
            ->where('isExtra', 0)
            ->paginate(10);
    }

    public function getRequisitions()
    {
        $requisitions = Requisition::whereHas('budget', function ($query) {
            $query->where('project_id', $this->projectId);
        })
            ->with('budget.material', 'budget.material.category', 'budget.material.unit')
            ->get();

        return $requisitions;
    }

    public function saveBudget()
    {
        // Check if a record with the same material_id and project_id already exists
        $existingRecord = ProjectBudget::where('material_id', $this->selectedMaterial)
            ->where('project_id', $this->projectId)
            ->where('isExtra', 0)
            ->exists();

        if ($existingRecord) {
            // Show an error message or perform any other necessary action
            session()->flash('budgeterror', 'Item already exists.');
        } else {
            // Create a new instance of ProjectBudget
            $projectBudget = new ProjectBudget();
            $projectBudget->material_id = $this->selectedMaterial;
            $projectBudget->project_id = $this->projectId;
            $projectBudget->quantity = 0; // Set the initial quantity value if needed
            $projectBudget->save();

            $totalBudget = new TotalBudget();
            $totalBudget->material_id = $this->selectedMaterial;
            $totalBudget->project_id = $this->projectId;
            $totalBudget->quantity = 0; // Set the initial quantity value if needed
            $totalBudget->save();

            // Reset the form inputs
            $this->selectedCategory = null;
            $this->selectedMaterial = null;

            // Fetch the budget items again to update the table
            $this->fetchBudgetItems();
            $this->allBudgetItems();

            // Emit an event to trigger JavaScript function
            $this->emit('budgetSaved');
        }
    }

    public function approveBudget()
    {
        try {
            $updated = ProjectBudget::where('project_id', $this->projectId)
                ->where('isExtra', 0)
                ->where('isApproved', 0)
                ->update(['isApproved' => 1]);

            if ($updated) {
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInput();
            }
        } catch (\Exception $e) {
            // Handle the exception if needed
        }
    }

    public function approveExtraBudget()
    {
        try {
            $updated = ProjectBudget::where('project_id', $this->projectId)
                ->where('isExtra', 1)
                ->where('isApproved', 0)
                ->update(['isApproved' => 1]);

            if ($updated) {
                $this->dispatchBrowserEvent('close-modal');
                $this->resetInput();
            }
        } catch (\Exception $e) {
            // Handle the exception if needed
        }
    }

    public function deleteBudget($budgetId)
    {
        $this->budgetId = $budgetId;
    }

    public function destroyBudget()
    {
        // Find the budget item by its ID
        $budgetItem = ProjectBudget::findOrFail($this->budgetId);

        // Delete the TotalBudget record
        TotalBudget::where('project_id', $budgetItem->project_id)
            ->where('material_id', $budgetItem->material_id)
            ->delete();

        // Delete the budget item
        $budgetItem->delete();

        // Fetch the budget items again to update the table
        $this->fetchBudgetItems();

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();

    }
    //-- END BUDGETING -- //

    //-- BUDGET QTY --//
    public function toggleQty($budgetItemId)
    {
        $this->editQtyId = $budgetItemId;

        if ($budgetItemId) {
            $budgetItem = ProjectBudget::findOrFail($budgetItemId);
            $this->budgetqty = $budgetItem->quantity;
        } else {
            $this->budgetqty = '';
        }
    }

    public function updateQty($budgetItemId)
    {
        $validatedData = $this->validate([
            'budgetqty' => 'required|integer',
        ]);

        $budgetItem = ProjectBudget::findOrFail($budgetItemId);
        $budgetItem->quantity = $validatedData['budgetqty'];
        $budgetItem->save();

        $totalQuantity = ProjectBudget::where('material_id', $budgetItem->material_id)
            ->where('project_id', $budgetItem->project_id)
            ->sum('quantity');

        // Update the total budget
        TotalBudget::where('project_id', $budgetItem->project_id)
            ->where('material_id', $budgetItem->material_id)
            ->update(['quantity' => $totalQuantity]);

        $this->editQtyId = null; // Reset the edited budget item ID
    }
    //-- END BUDGET QTY --//

    //-- SUPPLEMENTARY BUDGET --//
    public function activateSupplementaryBudget()
    {
        try {
            // Check if the supplementary budget record already exists for the current project
            $supplementaryBudget = SupplementaryBudget::where('project_id', $this->projectId)->first();

            if ($supplementaryBudget) {
                // Update the existing record and set the status to 1 (show)
                $supplementaryBudget->update(['status' => 1]);
            } else {
                // Create a new record for the current project and set the status to 1 (show)
                SupplementaryBudget::create([
                    'project_id' => $this->projectId,
                    'status' => 1,
                ]);
            }
            //session()->flash('supplementarybudget', ['message' => 'Supplementary budget activated successfully.', 'class' => 'alert-success']);

        } catch (\Exception $e) {
            // Handle the exception if any
            session()->flash('supplementarybudget', ['message' => 'Failed to activate Supplementary Budget.', 'class' => 'alert-danger']);
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function fetchExtraBudgetItems()
    {
        $this->extraBudgetItems = ProjectBudget::with(['material', 'material.category', 'material.unit'])
            ->where('project_id', $this->projectId)
            ->where('isExtra', 1)
            ->paginate(10);
    }

    public function saveExtraBudget()
    {
        // Check if a record with the same material_id and project_id already exists
        $existingRecord = ProjectBudget::where('material_id', $this->selectedMaterial)
            ->where('project_id', $this->projectId)
            ->where('isExtra', 1)
            ->exists();

        if ($existingRecord) {
            // Show an error message or perform any other necessary action
            session()->flash('extrabudgeterror', 'Item already exists.');
        } else {
            // Create a new instance of ProjectBudget
            $projectBudget = new ProjectBudget();
            $projectBudget->material_id = $this->selectedMaterial;
            $projectBudget->project_id = $this->projectId;
            $projectBudget->quantity = 0; // Set the initial quantity value if needed
            $projectBudget->isExtra = 1;
            $projectBudget->save();

            $totalBudget = new TotalBudget();
            $totalBudget->material_id = $this->selectedMaterial;
            $totalBudget->project_id = $this->projectId;
            $totalBudget->quantity = 0; // Set the initial quantity value if needed
            $totalBudget->save();

            // Reset the form inputs
            $this->selectedCategory = null;
            $this->selectedMaterial = null;

            // Fetch the budget items again to update the table
            $this->fetchExtraBudgetItems();
            $this->allBudgetItems();

            // Emit an event to trigger JavaScript function
            $this->emit('budgetSaved');
        }
    }
    //-- END SUPPLEMENTARY BUDGET --//

    //-- REQUISITION --//
    public function makeRequisition($budgetItemId)
    {
        $this->selectedBudgetItem = TotalBudget::with('material', 'material.category', 'material.unit')->findOrFail($budgetItemId);
        $this->budgetItemId = $budgetItemId;
        $selectedBudgetItem = $this->selectedBudgetItem;
        $this->budgetItemName = $selectedBudgetItem->material->name;
        $this->budgetItemCategory = $selectedBudgetItem->material->category->category;
        $this->budgetItemUnit = $selectedBudgetItem->material->unit->name;
        $this->budgetItemQuantity = $selectedBudgetItem->quantity;

        $this->requisitionSum = Requisition::where('budget_id', $budgetItemId)->sum('quantity');

        $this->budgetBalance = $this->budgetItemQuantity - $this->requisitionSum;
    }

    public function saveRequisition()
    {
        // Validate the form data
        $this->validate([
            'requisitionQuantity' => 'required|numeric|min:1',
            'budgetActivity' => 'required|string|max:255',
        ]);

        // Create a new Requisitions instance
        $requisition = new Requisition();
        $requisition->budget_id = $this->budgetItemId;
        $requisition->quantity = $this->requisitionQuantity;
        $requisition->activity = $this->budgetActivity;
        $requisition->vendor_id = $this->selectedVendor;
        $requisition->save();

        session()->flash('requisitionmessage', 'Requisition Successful');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();

        // Reset the form fields
        $this->requisitionQuantity = null;
        $this->budgetActivity = null;
        $this->selectedVendor = null;
    }

    public function deleteRequisition($requisitionId)
    {
        $this->requisitionId = $requisitionId;
    }

    public function destroyRequisition()
    {
        // Find the budget item by its ID
        $requisitionItem = Requisition::findOrFail($this->requisitionId);

        // Delete the budget item
        $requisitionItem->delete();

        // Fetch the budget items again to update the table
        $this->fetchRequisitions();

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();

    }

    public function approveRequisition()
    {
        Requisition::whereHas('budget', function ($query) {
            $query->where('project_id', $this->projectId);
        })
            ->where('status', 0)
            ->update(['status' => 1]);

        // Refresh the allRequisitions data
        $this->fetchRequisitions();

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function fetchRequisitions()
    {
        $this->allRequisitions = Requisition::with(['budget.material', 'budget.material.category', 'budget.material.unit'])
            ->join('total_budgets', 'requisitions.budget_id', '=', 'total_budgets.id')
            ->where('total_budgets.project_id', $this->projectId)
            ->select('requisitions.*')
            ->paginate(10);
    }
    //-- END REQUISITION --//

    //-- INVENTORY ITEMS --//


    public function calculateTotalMaterialQuantity()
    {
        $selectedMaterialId = $this->selectedInventoryMaterial;

        // Query the requisitions table to calculate the total quantity from requisitions
        $totalQuantityRequisitions = Requisition::whereHas('budget', function ($query) use ($selectedMaterialId) {
            $query->where('material_id', $selectedMaterialId);
        })->where('status', 1)->sum('quantity');

        // Query the inventory table to calculate the total quantity from inventory
        $totalQuantityInventory = Inventory::where('material_id', $selectedMaterialId)->sum('quantity');

        // Calculate the difference between the two quantities
        $totalQuantity = $totalQuantityRequisitions - $totalQuantityInventory;

        return $totalQuantity;
    }

    //-- END INVENTORY ITEMS --//

    public function updateTotalMaterialQuantity()
    {
        $this->totalMaterialQuantity = $this->calculateTotalMaterialQuantity();
    }


    public function calculateInflowSum()
    {
        $selectedMaterialId = $this->selectedInventoryMaterial;

        // Query the inventory table to calculate the summation of inflow (In) for the material
        $inflowSum = Inventory::where('material_id', $selectedMaterialId)
            ->where('flow', 1) // Inflow (In)
            ->sum('quantity');

        return $inflowSum;
    }

    public function calculateOutgoingsSum()
    {
        $selectedMaterialId = $this->selectedInventoryMaterial;

        // Query the inventory table to calculate the summation of outgoings (Out) for the material
        $outgoingsSum = Inventory::where('material_id', $selectedMaterialId)
            ->where('flow', 0) // Outgoings (Out)
            ->sum('quantity');

        return $outgoingsSum;
    }


    //INFLOW
    public function addInventory()
    {
        // Validate the form data
        $this->validate([
            'selectedInventoryCategory' => 'required',
            'selectedInventoryMaterial' => 'required',
            'inventoryQuantity' => 'required|numeric|min:0|max:' . $this->calculateTotalMaterialQuantity(),
            'inventoryReceiver' => 'required',
            'inventoryPurpose' => 'required',
        ]);

        // Create a new Inventory record
        Inventory::create([
            'material_id' => $this->selectedInventoryMaterial,
            'project_id' => $this->projectId,
            'quantity' => $this->inventoryQuantity,
            'receiver' => $this->inventoryReceiver,
            'purpose' => $this->inventoryPurpose,
            // Set any other fields you have in your Inventory model
        ]);

        $this->projectStore();

        // Reset form fields
        $this->selectedInventoryCategory = '';
        $this->selectedInventoryMaterial = '';
        $this->inventoryQuantity = '';
        $this->inventoryReceiver = '';
        $this->inventoryPurpose = '';

        // Optionally, you could also show a success message
        session()->flash('success', 'Inventory added successfully.');

        $this->resetForm([
            'selectedInventoryCategory',
            'selectedInventoryMaterial',
            'inventoryQuantity',
            'inventoryReceiver',
            'inventoryPurpose',
        ]);
        $this->closeModal();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetMaterialFields()
    {
        // Reset the selectedInventoryMaterial and other related fields here
        $this->selectedInventoryMaterial = null;
        $this->inventoryQuantity = null;
        $this->inventoryReceiver = null;
        $this->inventoryPurpose = null;
    }

    //-- END INFLOW --//


    //OUTGOINGS
    public function removeInventory()
    {
        // Validate the form data
        $this->validate([
            'selectedInventoryCategory' => 'required',
            'selectedInventoryMaterial' => 'required',
            'inventoryQuantity' => 'required|numeric|min:0|max:' . $this->calculateTotalMaterialQuantity(),
            'inventoryReceiver' => 'required',
            'inventoryPurpose' => 'required',
        ]);

        // Create a new Inventory record
        Inventory::create([
            'material_id' => $this->selectedInventoryMaterial,
            'project_id' => $this->projectId,
            'quantity' => $this->inventoryQuantity,
            'receiver' => $this->inventoryReceiver,
            'purpose' => $this->inventoryPurpose,
            'flow' => 0,
            // Set any other fields you have in your Inventory model
        ]);

        $this->projectStore();

        // Reset form fields
        $this->selectedInventoryCategory = '';
        $this->selectedInventoryMaterial = '';
        $this->inventoryQuantity = '';
        $this->inventoryReceiver = '';
        $this->inventoryPurpose = '';


        $this->resetForm([
            'selectedInventoryCategory',
            'selectedInventoryMaterial',
            'inventoryQuantity',
            'inventoryReceiver',
            'inventoryPurpose',
        ]);
        $this->closeModal();
        $this->dispatchBrowserEvent('close-modal');
    }
    //-- END OUTGOINGS --//


    public function allBudgetItems()
    {
        $totalBudgetItems = TotalBudget::with(['material', 'material.category', 'material.unit'])
        ->whereHas('material', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhereHas('category', function ($q) {
                    $q->where('category', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('unit', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        })
        ->where('project_id', $this->projectId)
        ->paginate(5, ['*'], 'budgetItemsPage');

        $totalBudgetItems->each(function ($totalBudgetItem) {
            $totalBudgetItem->requisitionSum = $totalBudgetItem->requisitions->sum('quantity');
            $totalBudgetItem->budgetBalance = $totalBudgetItem->quantity - $totalBudgetItem->requisitionSum;
        });
        return $totalBudgetItems;
    }


    public function projectStore()
    {
        $query = Inventory::with(['material.category', 'material.unit'])
            ->selectRaw('material_id, SUM(CASE WHEN flow = 1 THEN quantity ELSE 0 END) AS inflowSum, SUM(CASE WHEN flow = 0 THEN quantity ELSE 0 END) AS outgoingSum')
            ->where('project_id', $this->projectId)
            ->groupBy('material_id');

        if ($this->storeSearch) {
            $query->whereHas('material.category', function ($q) {
                $q->where('category', 'like', '%' . $this->storeSearch . '%');
            })
            ->orWhereHas('material', function ($q) {
                $q->where('name', 'like', '%' . $this->storeSearch . '%');
            });
        }

        $this->storeItems = $query->paginate(10, ['*'], 'allStorePage');
    }

    public function render()
    {
        $users = $this->users;

        $allBudgetItems = $this->allBudgetItems();

        $budgetItems = ProjectBudget::with(['material', 'material.category', 'material.unit'])
            ->whereHas('material', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('category', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->where('project_id', $this->projectId)
            ->where('isExtra', 0)
            ->paginate(5, ['*'], 'budgetItemsPage');



        // Get supplementary budget status for the current project
        $supplementaryBudgetStatus = SupplementaryBudget::where('project_id', $this->projectId)->first();

        $extraBudgetItems = ProjectBudget::with(['material', 'material.category', 'material.unit'])
            ->whereHas('material', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('category', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->where('project_id', $this->projectId)
            ->where('isExtra', 1)
            ->paginate(5, ['*'], 'extraBudgetItemsPage');


        $allRequisitions = Requisition::with(['budget.material', 'budget.material.category', 'budget.material.unit'])
            ->join('total_budgets', 'requisitions.budget_id', '=', 'total_budgets.id')
            ->leftJoin('vendors', 'requisitions.vendor_id', '=', 'vendors.id')
            ->where('total_budgets.project_id', $this->projectId)
            ->where(function ($query) {
                $query->whereHas('budget.material', function ($q) {
                    $q->where('name', 'like', '%' . $this->requisitionSearch . '%')
                        ->orWhereHas('category', function ($q) {
                            $q->where('category', 'like', '%' . $this->requisitionSearch . '%');
                        })
                        ->orWhereHas('unit', function ($q) {
                            $q->where('name', 'like', '%' . $this->requisitionSearch . '%');
                        });
                })
                    ->orWhere('activity', 'like', '%' . $this->requisitionSearch . '%')
                    ->orWhere('vendors.name', 'like', '%' . $this->requisitionSearch . '%');
            })
            ->select('requisitions.*', 'vendors.name as vendor_name')
            ->orderBy('created_at', 'desc') // Order by date (newest first)
            ->paginate(10, ['*'], 'allRequisitionsPage');


        $inventoryItems = Inventory::with(['material.category', 'material.unit'])
                ->where('project_id', $this->projectId)
                ->where(function ($query) {
                    $query->whereHas('material.category', function ($q) {
                        $q->where('category', 'like', '%' . $this->inventorySearch . '%');
                    })
                    ->orWhereHas('material.unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->inventorySearch . '%');
                    })
                    ->orWhere('quantity', 'like', '%' . $this->inventorySearch . '%')
                    ->orWhere('receiver', 'like', '%' . $this->inventorySearch . '%')
                    ->orWhere('purpose', 'like', '%' . $this->inventorySearch . '%')
                    ->orWhereRaw('(CASE WHEN flow = 1 THEN "In" ELSE "Out" END) LIKE ?', ['%' . $this->inventorySearch . '%'])
                    ->orWhere('created_at', 'like', '%' . $this->inventorySearch . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'allInventoryPage');

        $inventoryCategories = MaterialCategory::whereIn('id', function ($query) {
            $query->select('material_category.id')
                ->from('requisitions')
                ->join('total_budgets', 'requisitions.budget_id', '=', 'total_budgets.id')
                ->join('materials', 'total_budgets.material_id', '=', 'materials.id')
                ->join('material_category', 'materials.category_id', '=', 'material_category.id')
                ->where('total_budgets.project_id', $this->projectId);
        })->get();


        $inventoryMaterials = Material::whereIn('id', function ($query) {
            $query->select('materials.id')
                ->from('requisitions')
                ->join('total_budgets', 'requisitions.budget_id', '=', 'total_budgets.id')
                ->join('materials', 'total_budgets.material_id', '=', 'materials.id')
                ->join('material_category', 'materials.category_id', '=', 'material_category.id')
                ->where('total_budgets.project_id', $this->projectId);
        })->get();

        $this->projectStore();
        $totalMaterialQuantity = $this->calculateTotalMaterialQuantity();

        $categories = $this->categories;
        $materials = $this->materials->where('category_id', $this->selectedCategory); // Filter materials by selected category
        $inflowSum = $this->calculateInflowSum();
        $outgoingsSum = $this->calculateOutgoingsSum();
        $storeBalance = $inflowSum - $outgoingsSum;

        return view('livewire.admin.project.details', [
            'users' => $users,
            'budgetItems' => $budgetItems,
            'allBudgetItems' => $allBudgetItems,
            'extraBudgetItems' => $extraBudgetItems,
            'categories' => $categories,
            'materials' => $materials,
            'allRequisitions' => $allRequisitions,
            'supplementaryBudgetStatus' => $supplementaryBudgetStatus,
            'inventoryItems' => $inventoryItems,
            'inventoryCategories' => $inventoryCategories,
            'inventoryMaterials' => $inventoryMaterials,
            'totalMaterialQuantity' => $this->totalMaterialQuantity,
            'inflowSum' => $inflowSum,
            'outgoingsSum' => $outgoingsSum,
            'storeBalance' => $storeBalance,
            'storeItems' => $this->storeItems,
        ])->extends('layouts.admin')->section('content');
    }

}