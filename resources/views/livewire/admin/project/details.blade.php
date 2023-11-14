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

    <div>
        <p>Welcome, {{ $admin->name }} </p>
        @if($staffRole)
            <p><strong>Role: </strong>{{$this->staffRole}} @if($superAdmin) <span>+ Super Admin</span>@endif</p>
        @endif

    </div>

    <!-- PROJECT INFO -->
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
                            @if($superAdmin)
                                <button class="btn btn-sm btn-warning ms-2" wire:click="toggleClient"><i
                                    class="fas fa-pencil-alt"></i></button>
                            @endif
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
                            @if($superAdmin)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#assignTeamModal"
                                    class="btn btn-sm btn-primary text-white"><i class="fas fa-users-cog"></i> Project
                                    Team</a>
                            @endif
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


    @if ($project && $project->status == 1)
        <!-- BUDGET -->
        <div class="row">
            <div class="col-md-12">
                @include('livewire.admin.project.partials.primary-budget')
            </div>
        </div>
        <!-- END BUDGET -->

        <!-- SUPPLEMENTARY BUDGET -->
        @if (!empty($activeSupplementaryBudget))
        <div class="row">
            <div class="col-md-12">
                @include('livewire.admin.project.partials.supplementary-budget')
            </div>
        </div>
        @endif
        <!-- END SUPPLEMENTARY BUDGET -->

        <!-- CUMMULATIVE BUDGET -->
        <div class="row">
            <div class="col-md-12">
                @include('livewire.admin.project.partials.cummulative-budget')
            </div>
        </div>
        <!-- END ALL BUDGETS -->

        <!-- REQUISITION -->
        <div class="row">
            <!-- ROW 3, COL 1 -->
            <div class="col-md-12 d-flex align-items-stretch">
                @include('livewire.admin.project.partials.requisition')
            </div>
        </div>
        <!-- END REQUISITION -->

        <!-- INFLOW -->
        <div class="row">
            <!-- ROW 4, COL 1 -->
            <div class="col-md-12 d-flex align-items-stretch">
                @include('livewire.admin.project.partials.inflow')
            </div>
        </div>
        <!-- END INFLOW -->

        <!-- ALLOCATION -->
        <div class="row">
            <!-- ROW 4, COL 1 -->
            <div class="col-md-12 d-flex align-items-stretch">
                @include('livewire.admin.project.partials.allocation')
            </div>
        </div>
        <!-- END ALLOCATION -->

        <!-- INVENTORY -->
        <div class="row">
            <!-- ROW 4, COL 1 -->
            <div class="col-md-12 d-flex align-items-stretch">
                @include('livewire.admin.project.partials.inventory')
            </div>
        </div>
        <!-- END INVENTORY -->
    @else
        <div class="row">

            <div class="alert alert-danger text-center h6">
                <i class="fas fa-lock me-2"></i> This project is inactive, please contact the Administrator or the Project Manager.
            </div>

        </div>
    @endif
</div>


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

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
            $('#deleteAllocationModal').modal('hide');
            $('#approveAllocationModal').modal('hide');
            $('#approvalRequestModal').modal('hide');
            $('#extraApprovalRequestModal').modal('hide');
            $('#vendorModal').modal('hide');
            $('#requisionApprovalRequestModal').modal('hide');
            $('#allocationApprovalRequestModal').modal('hide');
        });


        function exportToCSV(tableId) {
            const table = document.querySelector(`#${tableId}`);
            const csv = toCSV(table);
            downloadFile(csv, 'csv', `${tableId}_report.csv`);
        }

        function toCSV(table) {
            const t_rows = table.querySelectorAll('tr');
            return [...t_rows].map(row=>{
                const cells = row.querySelectorAll('th, td');
                return [...cells].map(cell => cell.textContent.trim()).join(',');
            }).join('\n')
        }

        function downloadFile(data, fileType, fileName = '') {
            const a = document.createElement('a');
            a.download = fileName;
            const mime_types = {
                'json':'application/json',
                'csv':'text/csv',
                'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            }
            a.href = `
                data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
            `;
            document.body.appendChild(a);
            a.click();
            a.remove();
        }

        document.getElementById('openAlert').addEventListener('click', function () {
            Swal.fire({
                title: 'Alert Title',
                text: 'This is your SweetAlert message.',
                icon: 'success', // You can use 'success', 'error', 'warning', 'info', etc.
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endsection
