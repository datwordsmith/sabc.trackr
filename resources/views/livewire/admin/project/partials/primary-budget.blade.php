<div class="card w-100">
    <div class="card-body p-4">
        <div class="border-bottom border-danger mb-3 d-flex">
            <div>
                <h5 class="card-title fw-semibold pb-2">Project Budget</h5>
            </div>
            <div class="ms-auto">
                @if ($budgetItems->where('isApproved', 0)->count() > 0 && $budgetItems->where('quantity', '<', 1)->count() == 0 && $budgetItems->where('alert', '=', 0)->count() == 0)
                    @if(($quantitySurveyor) || ($superAdmin))
                        <a href="#" data-bs-toggle="modal" data-bs-target="#approvalRequestModal"
                            class="btn btn-sm btn-secondary text-white me-2">
                            <i class="far fa-paper-plane"></i> <span class="d-none d-md-inline">Request Approval</span> </a>
                    @endif

                    @if (($budgetOfficer) || ($superAdmin))
                        <a href="#" data-bs-toggle="modal" data-bs-target="#approveBudgetModal"
                            class="btn btn-sm btn-success text-white me-2">
                            <i class="fas fa-check-double"></i> Approve Budget
                        </a>
                    @endif
                @endif
                @if ($budgetItems->count() > 0)
                    <button type="button" class="btn btn-sm btn-info " onclick="exportToCSV('primary_budget')"><i class="fas fa-file-csv fa-lg"></i> <span class="d-none d-md-inline">Export</span></button>
                @endif
            </div>
        </div>
        <div class="row">
            <!-- BUDGET, COL 1 -->
            <div class="col-md-4 mb-3">
                @if (session()->has('supplementarybudget'))
                    <div class="alert {{ session('supplementarybudget')['class'] }}">
                        {{ session('supplementarybudget')['message'] }}
                    </div>
                @endif
                @if ($project && $project->status == 1)
                    @if($BudgetApprovalEmailSent)
                        <div class="alert alert-info" >
                            Approval Request Sent
                        </div>
                    @endif
                    @if ($budgetItems->count() > 0 && $budgetItems->where('isApproved', 0)->count() == 0)
                        <div class="">
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle fa-lg me-2" style="color: #198754;"></i> Primary budget approved
                            </div>

                            <div class="table-responsive">
                                <table id="sup" class="table table-striped table-sm mb-2">
                                    <thead class="table-dark">
                                        <tr>
                                            <th colspan="12" class="text-secondary text-xs p-2 font-weight-semibold opacity-7 col-12">
                                                Supplementary Budgets</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supplementaryBudgets as $supplementaryBudget)
                                            <tr>
                                                <td class="p-2">
                                                    {{ $supplementaryBudget->title }}
                                                </td>
                                                <td class="text-center col-4">
                                                    @if($supplementaryBudget->status == 1)
                                                        <button class="btn btn-sm btn-secondary disabled">
                                                            <i class="fas fa-folder-open"></i>
                                                        </button>
                                                    @else
                                                        <a href="#" wire:click.prevent="openSupplementaryBudget({{ $supplementaryBudget->id }})" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-folder"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            @if(($quantitySurveyor) || ($superAdmin))
                                <div class="d-grid gap-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#activateSupplementaryBudgetModal"
                                        class="btn btn-outline-success">
                                        <i class="fas fa-plus"></i> Add Supplementary Budget
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="card w-100">
                            <div class="card-header text-light bg-warning">
                                Add Budget Items
                            </div>
                            <div class="card-body p-4">
                                @if($projectUsers->isNotEmpty())
                                    @if (session('budgeterror'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('budgeterror') }}
                                        </div>
                                    @endif
                                    @if(($quantitySurveyor) || ($superAdmin))
                                        <form wire:submit.prevent="saveBudget()">
                                            <div class="mb-3">
                                                <select wire:model="selectedCategory" class="form-select" required>
                                                    <option value="">Select a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <select wire:model="selectedMaterial" class="form-control"
                                                    @if (empty($selectedCategory)) disabled @endif required>
                                                    <option value="">Select a material</option>
                                                    @if (!empty($materials))
                                                        @foreach ($materials as $material)
                                                            @if ($material->category_id == $selectedCategory)
                                                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-warning">
                                            Role reserved for the Quantity Surveyor
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-warning">
                                        No Staff assigned to project.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <strong class="text-center text-danger">Project is Inactive</strong>
                @endif
            </div>

            <!-- BUDGET, COL 2 -->
            <div class="col-md-8">
                <div>
                    @if ($project && $project->status == 1)
                        <div class="mb-3">
                            <input type="text" class="form-control mb-2" wire:model="search" placeholder="Search...">
                            @if (session('budgetapprovalerror'))
                                <div class="alert alert-danger" role="alert">
                                    Error
                                </div>
                            @endif
                            @if (session('budgetapproved'))
                                <div class="alert alert-success" role="alert">
                                    Approved
                                </div>
                            @endif
                            @if(!empty($alertQtyError))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{$alertQtyError}}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="primary_budget" class="table table-striped align-items-center mb-0"
                                style="width:100%">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                            Material</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">
                                            Category</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Unit
                                        </th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                            Quantity</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                                Alert Qty</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($budgetItems->sortBy('material.name') as $budgetItem)
                                        <tr>
                                            <td>{{ $budgetItem->material->name }}</td>
                                            <td>{{ $budgetItem->material->category->category }}</td>
                                            <td>{{ $budgetItem->material->unit->name }}</td>
                                            <td>
                                                @if ($editQtyId !== $budgetItem->id)
                                                    @if ((!$budgetItem->isApproved) && (($quantitySurveyor) || ($superAdmin)))
                                                        <button class="btn btn-sm btn-warning ms-2"
                                                            wire:click="toggleQty({{ $budgetItem->id }})"><i
                                                                class="fas fa-pencil-alt"></i></button>
                                                    @endif
                                                    <span class="fw-normal">{{ $budgetItem->quantity }}</span>
                                                @else
                                                    @if(($quantitySurveyor) || ($superAdmin))
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control form-control-sm d-inline-block w-auto-fit"
                                                                wire:model.defer="budgetqty"
                                                                wire:keydown.enter.prevent="updateQty({{ $budgetItem->id }})"
                                                                wire:keydown.escape="toggleQty" min=0>
                                                            <button class="btn btn-sm btn-primary ms-2"
                                                                wire:click="updateQty({{ $budgetItem->id }})"><i
                                                                    class="fas fa-save"></i></button>
                                                            <button class="btn btn-sm btn-danger"
                                                                wire:click="toggleQty(null)"><i
                                                                    class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($editAlertQtyId !== $budgetItem->id)
                                                    @if ((!$budgetItem->isApproved) && (($quantitySurveyor)  || ($superAdmin)))
                                                        <button class="btn btn-sm btn-warning ms-2"
                                                            wire:click="toggleAlertQty({{ $budgetItem->id }})"><i
                                                                class="fas fa-pencil-alt"></i></button>
                                                    @endif
                                                    <span class="fw-normal">{{ $budgetItem->alert }}</span>
                                                @else
                                                    @if(($quantitySurveyor) || ($superAdmin))
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control form-control-sm d-inline-block w-auto-fit"
                                                                wire:model.defer="budgetalertqty"
                                                                wire:keydown.enter.prevent="updateAlertQty({{ $budgetItem->id }})"
                                                                wire:keydown.escape="toggleAlertQty" min=0>
                                                            <button class="btn btn-sm btn-primary ms-2"
                                                                wire:click="updateAlertQty({{ $budgetItem->id }})"><i
                                                                    class="fas fa-save"></i></button>
                                                            <button class="btn btn-sm btn-danger"
                                                                wire:click="toggleAlertQty(null)"><i
                                                                    class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Action buttons for the budget item -->
                                                <div class="btn-group" role="group" aria-label="">
                                                    @if ($budgetItem->isApproved)
                                                            {{-- <a href="#"
                                                                wire:click="makeRequisition({{ $budgetItem->id }})"
                                                                data-bs-toggle="modal" data-bs-target="#requisitionModal"
                                                                class="btn btn-sm btn-success text-white"> Request</a> --}}
                                                    @else
                                                        @if(($quantitySurveyor) || ($superAdmin))
                                                            <a href="#"
                                                                wire:click="deleteBudget({{ $budgetItem->id }})"
                                                                data-bs-toggle="modal" data-bs-target="#deleteBudgetModal"
                                                                class="btn btn-sm btn-danger text-white"><i
                                                                    class="fas fa-trash-alt"></i></a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row mt-2">
                                {{ $budgetItems->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
