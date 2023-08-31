<div>
    @include('livewire.admin.project.details-modal-form')
    {{-- @livewire('admin.project.details', ['debug' => false]) --}}

    @section('pagename')
        <i class="fas fa-project-diagram"></i> {{ $project->name }}
    @endsection

    @section('breadcrumbs')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('t/projects') }}">All Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $project->name }}</li>
        </ol>
    @endsection

    <!-- ROW #1 -->
    <div class="row">
        <!-- ROW 1, COL 1 -->
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header text-light bg-success">
                    <div>
                        Project Info
                    </div>
                    <div class="ms-auto">

                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Project Title</h6>
                        <span class="fw-normal">{{ $project->name }}</span>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Description</h6>
                        <span class="fw-normal">{{ $project->description }}</span>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-1">Client</h6>
                        @if (!$editClient)
                            <span class="fw-normal">{{ $project->client }}</span>
                            <button class="btn btn-sm btn-warning ms-2" wire:click="toggleClient"><i
                                    class="fas fa-pencil-alt"></i></button>
                        @else
                            <input type="text" class="form-control form-control-sm d-inline-block w-auto"
                                wire:model.defer="client" wire:keydown.enter.prevent="updateClient"
                                wire:keydown.escape="toggleClient">
                            <button class="btn btn-sm btn-primary ms-2" wire:click="updateClient"><i
                                    class="fas fa-save"></i></button>
                            <button class="btn btn-sm btn-danger" wire:click="toggleClient"><i
                                    class="fas fa-times"></i></button>
                        @endif
                    </div>
                    <div class="mb-3 d-flex">
                        <div>
                            <h6 class="fw-semibold mb-1">Start</h6>
                            <span class="fw-normal">{{ date('d M, Y', strtotime($project->start_date)) }}</span>
                        </div>
                        <div class="ms-auto">
                            <h6 class="fw-semibold mb-1">Expected Delivery</h6>
                            <span
                                class="fw-normal">{{ date('d M, Y', strtotime($project->expected_delivery_date)) }}</span>
                        </div>
                        <div class="mb-3">

                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input text-success" type="checkbox" id="status" value="1"
                                wire:model.defer="status">
                            <label class="form-check-label fw-bold text-success" for="status">
                                Activate Project
                            </label>
                            <span class="labels" data-on="ON" data-off="OFF"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 1, COL 2 -->
        <div class="col-md-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-warning mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Project Team</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#assignTeamModal"
                                class="btn btn-sm btn-primary text-white"><i class="fas fa-users-cog"></i> Project
                                Team</a>
                        </div>
                    </div>
                    {{-- @if ($project && $project->status == 1) --}}
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <!-- LEFT COL -->
                        @foreach ($projectUsers->sortBy('role.id') as $projectUser)
                            @if ($projectUser->project_id == $project->id)
                                <div class="col-6 pb-4">
                                    <strong>{{ $projectUser->role->role }}</strong><br />
                                    <small>{{ $projectUser->user->name }}</small>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ROW #2 - BUDGET -->
    <div class="row">
        <div class="col-md-12">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-danger mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Project Budget</h5>
                        </div>
                        <div class="ms-auto">
                            @if ($budgetItems->where('isApproved', 0)->count() > 0 && $budgetItems->where('quantity', '<', 1)->count() == 0)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#approveBudgetModal"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="fas fa-check-double"></i> Approve Budget
                                </a>
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
                                        @if ($budgetItems->count() > 0)
                                            @if ($budgetItems->where('isApproved', 0)->count() == 0)
                                                <div class="mt-3 text-center">
                                                    <p >
                                                        <i class="fas fa-check-circle fa-lg pr-3" style="color: #198754;"></i>
                                                        <h3>This budget is approved</h3>
                                                    </p>
                                                    @if ($supplementaryBudgetStatus && $supplementaryBudgetStatus->status == 1)
                                                        <p>
                                                            <div class="alert alert-success" >
                                                                Supplementary Budget is Activated
                                                            </div>

                                                        </p>
                                                    @else
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#activateSupplementaryBudgetModal"
                                                            class="btn btn-sm btn-success text-white">
                                                            <i class="fas fa-plus"></i> Add Supplementary Budget
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="card w-100">
                                                    <div class="card-header text-light bg-warning">
                                                        Add Budget Items
                                                    </div>
                                                    <div class="card-body p-4">
                                                        @if (session('budgeterror'))
                                                            <div class="alert alert-danger" role="alert">
                                                                {{ session('budgeterror') }}
                                                            </div>
                                                        @endif
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
                                                    </div>
                                                </div>
                                            @endif
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
                                        </div>
                                        <div class="table-responsive">
                                            <table id="budget_table" class="table table-striped align-items-center mb-0"
                                                style="width:100%">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                                            Material</th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">
                                                            Category</th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Unit
                                                        </th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                                            Quantity</th>
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
                                                                    @if (!$budgetItem->isApproved)
                                                                        <button class="btn btn-sm btn-warning ms-2"
                                                                            wire:click="toggleQty({{ $budgetItem->id }})"><i
                                                                                class="fas fa-pencil-alt"></i></button>
                                                                    @endif
                                                                    <span class="fw-normal">{{ $budgetItem->quantity }}</span>
                                                                @else
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
                                                                    <a href="#"
                                                                        wire:click="deleteBudget({{ $budgetItem->id }})"
                                                                        data-bs-toggle="modal" data-bs-target="#deleteBudgetModal"
                                                                        class="btn btn-sm btn-danger text-white"><i
                                                                            class="fas fa-trash-alt"></i></a>
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
        </div>
    </div>
    <!-- END BUDGET -->

    <!-- ROW #2B - SUPPLEMENTARY BUDGET -->
    @if ($supplementaryBudgetStatus && $supplementaryBudgetStatus->status == 1)
    <div class="row">
        <div class="col-md-12">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-danger mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Supplementary Budget</h5>
                        </div>
                        <div class="ms-auto">
                            @if ($extraBudgetItems->where('isApproved', 0)->count() > 0 && $extraBudgetItems->where('quantity', '<', 1)->count() == 0)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#approveExtraBudgetModal"
                                    class="btn btn-sm btn-success text-white">
                                    <i class="fas fa-check-double"></i> Approve Budget
                                </a>
                            @endif
                            <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#extraBudget" aria-controls="extraBudget" aria-expanded="true">
                                <i class="fas fa-window-minimize"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row collapse" id="extraBudget">
                        <!-- ROW 2, COL 1 -->
                        <div class="col-md-4 mb-3">
                            @if ($project && $project->status == 1)
                                    @if ($extraBudgetItems->count() > 0 && $extraBudgetItems->where('isApproved', 0)->count() == 0)
                                        <div class="mt-3 text-center">
                                            <p>
                                                <i class="fas fa-check-circle fa-lg pr-3" style="color: #198754;"></i>
                                                <h3>This budget is approved</h3>
                                            </p>
                                        </div>
                                    @else
                                        <div class="card w-100">
                                            <div class="card-header text-light bg-warning">
                                                Add Budget Items
                                            </div>
                                            <div class="card-body p-4">
                                                @if (session('extrabudgeterror'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ session('extrabudgeterror') }}
                                                    </div>
                                                @endif
                                                <form wire:submit.prevent="saveExtraBudget()">
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
                                            </div>
                                        </div>
                                    @endif
                            @else
                                <strong class="text-center text-danger">Project is Inactive</strong>
                            @endif
                        </div>

                        <!-- ROW 2, COL 2 -->
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
                                        </div>
                                        <div class="table-responsive">
                                            <table id="budget_table" class="table table-striped align-items-center mb-0"
                                                style="width:100%">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                                            Material</th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">
                                                            Category</th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Unit
                                                        </th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">
                                                            Quantity</th>
                                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($extraBudgetItems->sortBy('material.name') as $budgetItem)
                                                        <tr>
                                                            <td>{{ $budgetItem->material->name }}</td>
                                                            <td>{{ $budgetItem->material->category->category }}</td>
                                                            <td>{{ $budgetItem->material->unit->name }}</td>
                                                            <td>
                                                                @if ($editQtyId !== $budgetItem->id)
                                                                    @if (!$budgetItem->isApproved)
                                                                        <button class="btn btn-sm btn-warning ms-2"
                                                                            wire:click="toggleQty({{ $budgetItem->id }})"><i
                                                                                class="fas fa-pencil-alt"></i></button>
                                                                    @endif
                                                                    <span class="fw-normal">{{ $budgetItem->quantity }}</span>
                                                                @else
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
                                                                    <a href="#"
                                                                        wire:click="deleteBudget({{ $budgetItem->id }})"
                                                                        data-bs-toggle="modal" data-bs-target="#deleteBudgetModal"
                                                                        class="btn btn-sm btn-danger text-white"><i
                                                                            class="fas fa-trash-alt"></i></a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="row mt-2">
                                                {{ $extraBudgetItems->links() }}
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- END SUPPLEMENTARY BUDGET -->

    <!-- CUMMULATIVE BUDGET -->
    <div class="row">
        <div class="col-md-12">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-danger mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Cummulative Project Budget</h5>
                        </div>
                        <div class="ms-auto">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                    @if ($project && $project->status == 1)
                                        <div class="mb-3">
                                            <input type="text" class="form-control mb-2" wire:model="search" placeholder="Search...">
                                        </div>
                                        <div class="table-responsive">
                                            <table id="budget_table" class="table table-striped align-items-center mb-0"
                                                style="width:100%">
                                                <thead class="table-dark">
                                                    <tr class="text-secondary text-xs font-weight-semibold opacity-7">
                                                        <th class=" col-2">
                                                            Material</th>
                                                        <th class="col-2">
                                                            Category</th>
                                                        <th class="col-1">Unit
                                                        </th>
                                                        <th class="col-2 text-center">
                                                            Budget Quantity</th>
                                                        <th class="col-2 text-center">
                                                                Requisitions</th>
                                                        <th class="col-2 text-center">
                                                                Budget Balance</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($allBudgetItems->sortBy('material.name') as $budgetItem)
                                                        <tr>
                                                            <td>{{ $budgetItem->material->name }}</td>
                                                            <td>{{ $budgetItem->material->category->category }}</td>
                                                            <td>{{ $budgetItem->material->unit->name }}</td>
                                                            <td class="text-center">{{ $budgetItem->quantity }}</td>
                                                            <td class="text-center">{{ $budgetItem->requisitionSum }}</td>
                                                            <td class="text-center">{{ $budgetItem->budgetBalance  }}</td>
                                                            <td>
                                                                @if ($budgetItem->budgetBalance == 0)
                                                                    <span class="badge bg-danger">Complete</span>
                                                                @else
                                                                    <a href="#"
                                                                        wire:click="makeRequisition({{ $budgetItem->id }})"
                                                                        data-bs-toggle="modal" data-bs-target="#requisitionModal"
                                                                        class="btn btn-sm btn-success text-white"> Request</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="row mt-2">
                                                {{ $allBudgetItems->links() }}
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END ALL BUDGETS -->

    <!-- ROW #3 - REQUISITION -->
    <div class="row">
        <!-- ROW 3, COL 1 -->
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-warning mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Project Requisitions</h5>
                        </div>
                        <div class="ms-auto">
                            @if ($project && $project->status == 1)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#approveRequisitionModal"
                                    class="btn btn-sm btn-success text-white"><i class="fas fa-check-double"></i>
                                    Approve All</a>
                            @endif
                        </div>
                    </div>
                    @if ($project && $project->status == 1)
                        <div class="mb-3">
                            <input type="text" class="form-control" wire:model="requisitionSearch"
                                placeholder="Search...">
                        </div>
                        <div class="table-responsive">
                            <table id="budget_table" class="table table-striped align-items-center mb-0"
                                style="width:100%">
                                <thead class="table-dark">
                                    <tr class="text-secondary text-xs font-weight-semibold opacity-7">
                                        <th class="col-2">Date</th>
                                        <th class="col-2">Material</th>
                                        <th class="col-1">Category</th>
                                        <th class="col-2">Vendor</th>
                                        <th class="col-2">Activity</th>
                                        <th class="col-1">Quantity</th>
                                        <th class="col-1 text-center">Approval</th>
                                        <th class="col-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allRequisitions->sortByDesc('created_at') as $requisition)
                                        <tr>
                                            <td>{{ Carbon\Carbon::parse($requisition->created_at)->format('d M, Y') }}
                                            </td>
                                            <td>{{ $requisition->budget->material->name }}
                                                ({{ $requisition->budget->material->unit->name }})
                                            </td>
                                            <td>{{ $requisition->budget->material->category->category }}</td>
                                            <td>{{ $requisition->vendor_name }}</td>
                                            <td>{{ $requisition->activity }}</td>
                                            <td>{{ $requisition->quantity }}</td>
                                            <td class="text-center">
                                                @if ($requisition->status == '1')
                                                    <i class="far fa-check-circle text-success"></i>
                                                @else
                                                    <i class="fas fa-pause-circle fa-lg" style="color: #ffa500;"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!$requisition->status == '1')
                                                    <div class="btn-group" role="group" aria-label="">
                                                        <a href="#"
                                                            wire:click="deleteRequisition({{ $requisition->id }})"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteRequisitionModal"
                                                            class="btn btn-sm btn-danger text-white"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>



                            <div class="row mt-2">
                                {{ $allRequisitions->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- END REQUISITION -->

    <!-- ROW #4 - INVENTORY -->
    <div class="row">
        <!-- ROW 4, COL 1 -->
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-danger mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Site Inventory (In and Out)</h5>
                        </div>
                        <div class="ms-auto">
                            <div class="btn-group" role="group" aria-label="">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#supplyModal"
                                        class="btn btn-sm btn-success text-white"><i
                                        class="far fa-arrow-alt-circle-right fa-rotate-90"></i> In</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#distributionModal"
                                        class="btn btn-sm btn-danger text-white"><i
                                        class="far fa-arrow-alt-circle-right fa-rotate-270"></i> Out</a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- ROW 2, COL 1 -->
                        <div class="col-md-12">
                            <div>

                                <div class="mb-3">
                                    <input type="text" class="form-control mb-2" wire:model="inventorySearch" placeholder="Search...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped align-items-center mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Date</th>
                                                <th>Material</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Purpose</th>
                                                <th>In/Out</th>
                                                <th>Receiver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventoryItems as $inventoryItem)
                                                <tr>
                                                    <td>{{ $inventoryItem->created_at->format('d-M-Y') }}</td>
                                                    <td>{{ $inventoryItem->material->name }} ({{ $inventoryItem->material->unit->name }})</td>
                                                    <td>{{ $inventoryItem->material->category->category }}</td>
                                                    <td>{{ $inventoryItem->quantity }}</td>
                                                    <td>{{ $inventoryItem->purpose }}</td>
                                                    <td class="text-center">
                                                        @if ($inventoryItem->flow == 1)
                                                            <span class="badge bg-success">Inflow</span>
                                                        @else
                                                            <span class="badge bg-danger">Out</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $inventoryItem->receiver }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $inventoryItems->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END INVENTORY -->

    <!-- ROW #5 - STORE -->
    <div class="row">
        <!-- ROW 4, COL 1 -->
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="border-bottom border-danger mb-3 d-flex">
                        <div>
                            <h5 class="card-title fw-semibold pb-2">Project Store Report</h5>
                        </div>
                        <div class="ms-auto">

                        </div>
                    </div>

                    <div class="row">
                        <!-- ROW 2, COL 1 -->
                        <div class="col-md-12">
                            <div>

                                <div class="mb-3">
                                    <input type="text" class="form-control mb-2" wire:model="storeSearch" placeholder="Search...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped align-items-center mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Material</th>
                                                <th>Category</th>
                                                <th>Inflow</th>
                                                <th>Out</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($storeItems as $storeItem)
                                                <tr>
                                                    <td>{{ $storeItem->material->name }} ({{ $inventoryItem->material->unit->name }})</td>
                                                    <td>{{ $storeItem->material->category->category }}</td>
                                                    <td>{{ $storeItem->inflowSum  }}</td>
                                                    <td>{{ $storeItem->outgoingSum }}</td>
                                                    <td>{{ $storeItem->inflowSum - $storeItem->outgoingSum }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $storeItems->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END STORE -->
</div>


@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#assignTeamModal').modal('hide');
            $('#deleteBudgetModal').modal('hide');
            $('#requisitionModal').modal('hide');
            $('#approveBudgetModal').modal('hide');
            $('#approveExtraBudgetModal').modal('hide');
            $('#approveRequisitionModal').modal('hide');
            $('#deleteRequisitionModal').modal('hide');
            $('#activateSupplementaryBudgetModal').modal('hide');
            $('#supplyModal').modal('hide');
            $('#distributionModal').modal('hide');
        });
    </script>
@endsection