<div>
    @include('livewire.admin.user-role.modal-form')

    @section('pagename')
        <i class="fas fa-tasks"></i> User Roles
    @endsection

    @section('breadcrumbs')
        {{-- <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('projects')}}">User Roles</a></li>
        </ol> --}}
    @endsection

    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="col-md-12 d-flex mb-2">
                        <div>
                            {{-- <h5 class="card-title fw-semibold mb-4">Project Listing</h5> --}}
                        </div>
                        <div class="ms-auto">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="btn btn-sm btn-primary text-white"><i class="fas fa-plus-square pr-4"></i>&nbsp;&nbsp; Add User Role</a>
                        </div>
                    </div>
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
                    <div class="table-responsive">
                        <table id="category_table" class="table table-striped align-items-center mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr class="">
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-10">User Role</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user_roles as $index => $user_role)
                                <tr>
                                    <td>{{$user_role->role}}</td>
                                    <td class="">
                                        <div class="btn-group" role="group" aria-label="">
                                            <a href="#" wire:click="editRole({{$user_role->id}})" data-bs-toggle="modal" data-bs-target="#editRoleModal" class="btn btn-sm btn-warning text-white"><i class="far fa-edit"></i></a>
                                            <a href="#" wire:click="deleteRole({{$user_role->id}})" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">No User Role Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            {{ $user_roles->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addRoleModal').modal('hide');
            $('#editRoleModal').modal('hide');
            $('#deleteRoleModal').modal('hide');
        })
    </script>
@endsection
