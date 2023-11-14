<div class="card w-100">
    <div class="card-body p-4">
        <div class="border-bottom border-warning mb-3 d-flex">
            <div>
                <h5 class="card-title fw-semibold pb-2">Project Requisitions</h5>
            </div>
            <div class="ms-auto">
                @if ($project && $project->status == 1 && $allRequisitions->count() > 0)
                        @if($hasNullVendor)
                            @if(($projectManager) || ($superAdmin))
                                <a data-bs-toggle="modal" data-bs-target="#requisionApprovalRequestModal"
                                    class="btn btn-sm btn-success text-white me-2">
                                    <i class="fas fa-check-double"></i> Request Approval
                                </a>
                            @endif
                        @else
                            @if(($procurementOfficer) || ($superAdmin))
                                <a href="#" data-bs-toggle="modal" data-bs-target="#approveRequisitionModal"
                                    class="btn btn-sm btn-success text-white {{ (!$requisitionPending) ? 'disabled' : '' }}"><i class="fas fa-check-double"></i>
                                    <span class="d-none d-md-inline">Approve All</span></a>
                            @endif
                        @endif

                    <button type="button" class="btn btn-sm btn-info " onclick="exportToCSV('requisitions')"><i class="fas fa-file-csv fa-lg"></i> <span class="d-none d-md-inline">Export</span></button>
                @endif
            </div>

        </div>
        @if ($project && $project->status == 1)
            <div class="mb-3">
                <input type="text" class="form-control" wire:model="requisitionSearch"
                    placeholder="Search...">
            </div>
            @if (session('requisitionRequestSent'))
                <div class="mb-2">
                    <div class="alert alert-success" role="alert">
                        {{ session('requisitionRequestSent') }}
                    </div>
                </div>
            @endif
            @if (session('requisitionRequestError'))
                <div class="mb-2">
                    <div class="alert alert-danger mb-2" role="alert">
                        {{ session('requisitionRequestError') }}
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table id="requisitions" class="table table-striped align-items-center mb-0"
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
                                <td>{{ Carbon\Carbon::parse($requisition->created_at)->format('d-M-Y') }}
                                </td>
                                <td>{{ $requisition->budget->material->name }} ({{ $requisition->budget->material->unit->name }})
                                </td>
                                <td>{{ $requisition->budget->material->category->category }}</td>
                                <td>
                                    @if(($procurementOfficer) || ($superAdmin))
                                        @if ($requisition->status == '0')
                                            <a href="#"
                                                wire:click="updateVendor({{ $requisition->id }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#vendorModal"
                                                class="btn btn-sm btn-warning text-white"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                        @endif
                                    @endif
                                    @if (empty($requisition->vendor_name) || is_null($requisition->vendor_name))
                                        <span class="badge bg-danger py-2">No Vendor</span>
                                    @else
                                        {{ $requisition->vendor_name }}
                                    @endif
                                </td>
                                <td>{{ $requisition->activity }}</td>
                                <td>{{ $requisition->quantity }}</td>
                                <td class="text-center">
                                    @if ($requisition->status == '1')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$requisition->status == '1')
                                        <div class="btn-group" role="group" aria-label="">
                                            @if(($projectManager) || ($superAdmin))
                                                <a href="#"
                                                    wire:click="deleteRequisition({{ $requisition->id }})"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteRequisitionModal"
                                                    class="btn btn-sm btn-danger text-white"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            @endif
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
