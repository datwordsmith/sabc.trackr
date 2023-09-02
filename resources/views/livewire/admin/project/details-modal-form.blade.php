    <!-- ASSIGN TEAM MODAL -->
    <div wire:ignore.self class="modal fade" id="assignTeamModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom border-warning">
                    <h1 class="modal-title fs-5">Assign Project Team</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeProjectTeam()">
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($userRoles as $userRole)

                                <div class="col-6">
                                    <div class="mt-2">
                                        <label for="{{ $userRole->role }}"><small class="text-primary">{{ $userRole->role }}:</small></label>
                                        <select class="form-select" wire:model.defer="selectedUsers.{{ $userRole->id }}" required>
                                            <option value="">Select</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD MODAL -->

    <!-- DELETE BUDGET MODAL -->
    <div wire:ignore.self class="modal fade" id="deleteBudgetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Budget Item</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="destroyBudget()">
                        <div class="modal-body">
                            <h4>Are you sure you want to delete this Item?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DELETE MODAL -->

    <!-- REQUISITION MODAL -->
    <div wire:ignore.self class="modal fade" id="requisitionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom border-warning">
                    <h1 class="modal-title fs-5">Make Requisition</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveRequisition()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">

                                <table class="table align-items-center mb-0" style="width:100%">
                                    <tbody>
                                        <tr><td class="w-50"><label class="form-label">Material:</label></td> <td>{{ $budgetItemName }}</td></tr>
                                        <tr><td><label class="form-label">Category:</label></td> <td>{{ $budgetItemCategory }}</td></tr>
                                        <tr><td><label class="form-label">Unit:</label></td> <td>{{ $budgetItemUnit }}</td></tr>
                                        <tr><td><label class="form-label">Approved Budget Quantity:</label></td> <td>{{ $budgetItemQuantity }}</td></tr>
                                        <tr><td><label class="form-label">Previous Requisitions:</label></td> <td>{{ $requisitionSum }}</td></tr>
                                        @if ($budgetBalance > 0)
                                            <tr>
                                                <td><label class="form-label">Vendor:</label></td>
                                                <td>
                                                    <select class="form-select" wire:model="selectedVendor">
                                                        <option value="">Select a vendor</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label class="form-label">Requisition Quantity:</label></td>
                                                <td>
                                                    <input type="number" class="form-control" id="quantityInput" placeholder="Enter quantity"
                                                        wire:model.defer="requisitionQuantity" max="{{ $budgetBalance }}" min="1" pattern="[0-9]+" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label class="form-label">Activity:</label>
                                                    <input type="text" class="form-control" id="activityInput" placeholder="Enter activity" wire:model.defer="budgetActivity" required>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-danger text-center">Item requisitions complete</td>
                                            </tr>
                                        @endif
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @if ($budgetBalance > 0)
                            <button type="submit" class="btn btn-primary">Save</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END REQUISITION MODAL -->

    <!-- DELETE REQUISITION MODAL -->
    <div wire:ignore.self class="modal fade" id="deleteRequisitionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Requisition</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="destroyRequisition()">
                        <div class="modal-body">
                            <h4>Are you sure you want to delete this Item?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DELETE MODAL -->

    <!-- APPROVE REQUISITION MODAL -->
    <div wire:ignore.self class="modal fade" id="approveRequisitionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Approve Requisitions</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="approveRequisition()">
                        <div class="modal-body">
                            <h6>Do you want to approve all pending requisitions for this project?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check-double"></i> Yes, Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

    <!-- APPROVE BUDGET MODAL -->
    <div wire:ignore.self class="modal fade" id="approveBudgetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Budget Approval</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="approveBudget()">
                        <div class="modal-body">
                            <h6>Do you want to approve this budget?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check-double"></i> Yes, Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END APPROVE BUDGET MODAL -->

    <!-- APPROVE EXTRA BUDGET MODAL -->
    <div wire:ignore.self class="modal fade" id="approveExtraBudgetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Budget Approval</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="approveExtraBudget()">
                        <div class="modal-body">
                            <h6>Do you want to approve this budget?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check-double"></i> Yes, Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END APPROVE EXTRA BUDGET MODAL -->

    <!-- ACTIVATE SUPPLEMENTARY BUDGET MODAL -->
    <div wire:ignore.self class="modal fade" id="activateSupplementaryBudgetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Supplementary Budget</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="activateSupplementaryBudget()">
                        <div class="modal-body">
                            <h6>Do you want to activate a supplementary budget for this project?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Yes, Activate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END ACTIVATE SUPPLEMENTARY BUDGET MODAL -->

    <!-- STORE INFLOW MODAL -->
    <div wire:ignore.self class="modal fade" id="supplyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom border-warning">
                    <h1 class="modal-title fs-5">Store Inflow</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div wire:loading class="py-5 mt-5">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-grow text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div wire:loading.remove class="">
                        <form wire:submit.prevent="addInventory()">
                            <div class="mb-3">
                                <select wire:model="selectedInventoryCategory" class="form-select" required wire:change="resetMaterialFields">
                                    <option value="">Select a category</option>
                                    @foreach ($inventoryCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <select wire:model="selectedInventoryMaterial" class="form-control"
                                    @if (empty($selectedInventoryCategory)) disabled @endif required wire:change="updateTotalMaterialQuantity">
                                    <option value="">Select a material</option>
                                    @foreach ($inventoryMaterials as $material)
                                        @if ($material->category_id == $selectedInventoryCategory)
                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            @if (!empty($selectedInventoryMaterial))
                                @if($totalMaterialQuantity == 0 )
                                    <div class="alert alert-danger" role="alert">
                                        Available Quantity: {{ $totalMaterialQuantity }}
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Available Quantity: {{ $totalMaterialQuantity }}</label>
                                        <input type="number" id="quantity" class="form-control" wire:model.defer="inventoryQuantity" min="0" max="{{ $totalMaterialQuantity }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="receiver" class="form-label">Receiver</label>
                                        <input type="text" id="receiver" class="form-control" wire:model.defer="inventoryReceiver" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="purpose" class="form-label">Purpose</label>
                                        <textarea id="purpose" class="form-control" wire:model.defer="inventoryPurpose" required></textarea>
                                    </div>
                                @endif
                            @endif

                            @if($totalMaterialQuantity > 0 )
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Save</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END INFLOW MODAL -->

    <!-- STORE OUTFLOW MODAL -->
    <div wire:ignore.self class="modal fade" id="distributionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom border-warning">
                    <h1 class="modal-title fs-5">Store Outgoings</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div wire:loading class="py-5 mt-5">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-grow text-danger" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div wire:loading.remove class="">
                        <form wire:submit.prevent="removeInventory()">
                            <div class="mb-3">
                                <select wire:model="selectedStoreCategory" class="form-select" required wire:change="resetMaterialOutFields">
                                    <option value="">Select a category</option>
                                    @foreach ($storeCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <select wire:model="selectedStoreMaterial" class="form-control"
                                    @if (empty($selectedStoreCategory)) disabled @endif required wire:change="updateStoreMaterialQuantity">
                                    <option value="">Select a material</option>
                                    @foreach ($storeMaterials as $material)
                                        @if ($material->category_id == $selectedStoreCategory)
                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            @if (!empty($selectedStoreMaterial))
                                @if($pendingAllocations)
                                    <div class="alert alert-danger" role="alert">
                                        There is a Pending Allocation for this material.
                                    </div>
                                @else
                                    @if($totalStoreMaterialQuantity == 0 )
                                        <div class="alert alert-danger" role="alert">
                                            Available Quantity: {{ $totalStoreMaterialQuantity }}
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity in Stock: {{ $totalStoreMaterialQuantity }}</label>
                                            <input type="number" id="quantity" class="form-control" wire:model.defer="storeQuantity" min="0" max="{{ $totalStoreMaterialQuantity }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="receiver" class="form-label">Receiver</label>
                                            <input type="text" id="receiver" class="form-control" wire:model.defer="storeReceiver" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="purpose" class="form-label">Purpose</label>
                                            <textarea id="purpose" class="form-control" wire:model.defer="storePurpose" required></textarea>
                                        </div>
                                    @endif
                                @endif
                            @endif



                            @if($pendingAllocations)

                            @else
                                @if($totalStoreMaterialQuantity > 0 )
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">Save</button>
                                    </div>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OUTFLOW MODAL -->

    <!-- DELETE ALLOCATION MODAL -->
    <div wire:ignore.self class="modal fade" id="deleteAllocationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Material Allocation</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="destroyAllocation()">
                        <div class="modal-body">
                            <h4>Are you sure you want to delete this Item?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DELETE MODAL -->

    <!-- APPROVE AALOCATION MODAL -->
    <div wire:ignore.self class="modal fade" id="approveAllocationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Approve Allocation</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="approveAllocation()">
                        <div class="modal-body">
                            <h6>Do you want to approve all pending material allocations for this project?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-check-double"></i> Yes, Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->
