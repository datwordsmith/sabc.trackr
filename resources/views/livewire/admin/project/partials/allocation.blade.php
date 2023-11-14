<div class="card w-100">
    <div class="card-body p-4">
        <div class="border-bottom border-danger mb-3 d-flex">
            <div>
                <h5 class="card-title fw-semibold pb-2">Material Allocation (From Store)</h5>
            </div>
            <div class="ms-auto">
                <div class="btn-group" role="group" aria-label="">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#distributionModal"
                            class="btn btn-sm btn-danger text-white"><i
                            class="far fa-arrow-alt-circle-right fa-rotate-270"></i> <span class="d-none d-md-inline">Out</span></a>
                    @if (($allocatedItems->count() > 0) && ($allocationsPending))
                        @if(($materialManager) || ($superAdmin))
                            <a href="#" data-bs-toggle="modal" data-bs-target="#approveAllocationModal"
                                class="btn btn-sm btn-success text-white"><i class="fas fa-check-double"></i>
                                <span class="d-none d-md-inline">Approve All</span>
                            </a>
                        @endif
                        @if($projectManager)
                            <a data-bs-toggle="modal" data-bs-target="#allocationApprovalRequestModal"
                                class="btn btn-sm btn-success text-white me-2">
                                <i class="fas fa-check-double"></i> Request Approval
                            </a>
                        @endif
                    @endif
                </div>
                @if ($allocatedItems->count() > 0)
                    <button type="button" class="btn btn-sm btn-info " onclick="exportToCSV('materialDistribution')"><i class="fas fa-file-csv fa-lg"></i> <span class="d-none d-md-inline">Export</span></button>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- ROW 2, COL 1 -->
            <div class="col-md-12">
                <div>

                    <div class="mb-3">
                        <input type="text" class="form-control mb-2" wire:model="allocationSearch" placeholder="Search...">
                    </div>

                    @if (session('allocationRequestSent'))
                        <div class="mb-2">
                            <div class="alert alert-success" role="alert">
                                {{ session('allocationRequestSent') }}
                            </div>
                        </div>
                    @endif
                    @if (session('allocationRequestError'))
                        <div class="mb-2">
                            <div class="alert alert-danger mb-2" role="alert">
                                {{ session('allocationRequestError') }}
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped align-items-center mb-0" id="materialDistribution">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Material</th>
                                    <th>Category</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Purpose</th>
                                    <th class="text-center">Status</th>
                                    <th>Receiver</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allocatedItems as $allocatedItem)
                                    <tr>
                                        <td>{{ $allocatedItem->created_at->format('d-M-Y') }}</td>
                                        <td>{{ $allocatedItem->material->name }} ({{ $allocatedItem->material->unit->name }})</td>
                                        <td>{{ $allocatedItem->material->category->category }}</td>
                                        <td class="text-center">{{ $allocatedItem->quantity }}</td>
                                        <td>{{ $allocatedItem->purpose }}</td>
                                        <td class="text-center">
                                            @if ($allocatedItem->flow == '1')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $allocatedItem->receiver }}</td>
                                        <td>
                                            @if (($allocatedItem->flow == 0) && (($projectManager) || ($superAdmin)))
                                                <a href="#"
                                                    wire:click="deleteAllocation({{ $allocatedItem->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteAllocationModal"
                                                    class="btn btn-sm btn-danger text-white"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $allocatedItems->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
