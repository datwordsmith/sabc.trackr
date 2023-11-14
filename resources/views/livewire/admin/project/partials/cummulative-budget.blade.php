<div class="card w-100">
    <div class="card-body p-4">
        <div class="border-bottom border-danger mb-3 d-flex">
            <div>
                <h5 class="card-title fw-semibold pb-2">Cummulative Project Budget</h5>
            </div>
            <div class="ms-auto">
                @if ($allBudgetItems->count() > 0)
                    <button type="button" class="btn btn-sm btn-info " onclick="exportToCSV('cummulative_budget')"><i class="fas fa-file-csv fa-lg"></i> <span class="d-none d-md-inline">Export</span></button>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                        @if ($project && $project->status == 1)
                            <div class="mb-3">
                                <input type="text" class="form-control mb-2" wire:model="search" placeholder="Search...">
                            </div>
                            @if (session('alertmessage'))
                                <div class="mb-3 alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle pe-1" style="color: #ff0000;"></i> {{ session('alertmessage') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table id="cummulative_budget" class="table table-striped align-items-center mb-0"
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
                                                Budget Qty</th>
                                            <th class="col-2 text-center">
                                                    Requisitions</th>
                                            <th class="col-2 text-center">
                                                    Budget Balance</th>
                                            <th class="col-2 text-center">
                                                    Alert</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allBudgetItems->sortBy('material.name') as $budgetItem)
                                            @php
                                                $isSendAlert = $budgetItem->budgetBalance <= $budgetItem->alert;

                                            @endphp
                                            <tr class="{{ $isSendAlert ? 'table-danger' : '' }}">
                                                <td>{{ $budgetItem->material->name }}</td>
                                                <td>{{ $budgetItem->material->category->category }}</td>
                                                <td>{{ $budgetItem->material->unit->name }}</td>
                                                <td class="text-center">{{ $budgetItem->quantity }}</td>
                                                <td class="text-center">{{ $budgetItem->requisitionSum }}</td>
                                                <td class="text-center">
                                                    @if ($isSendAlert)
                                                        <i class="fas fa-exclamation-triangle pe-1" style="color: #ff0000;"></i>
                                                    @endif
                                                    {{ $budgetItem->budgetBalance }}
                                                </td>
                                                <td class="text-center">{{ $budgetItem->alert  }}</td>
                                                <td>
                                                    @if (($budgetItem->quantity == 0) && ($budgetItem->budgetBalance == 0))
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif (($budgetItem->quantity > 0) && ($budgetItem->budgetBalance == 0))
                                                        <span class="badge bg-warning">Pending</span>
                                                    @else
                                                        @if(($projectManager) || ($superAdmin))
                                                            <a href="#"
                                                                wire:click="makeRequisition({{ $budgetItem->id }})"
                                                                data-bs-toggle="modal" data-bs-target="#requisitionModal"
                                                                class="btn btn-sm btn-success text-white"> Request</a>
                                                        @endif
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
