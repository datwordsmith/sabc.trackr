<div>
    @include('livewire.admin.project.modal-form')

    @section('pagename')
        <i class="fas fa-project-diagram"></i> Projects
    @endsection

    @section('breadcrumbs')
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('t/projects')}}">Projects</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Projects</li>
        </ol>
    @endsection

    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="col-md-12 d-flex mb-2">
                        <div>
                            <h5 class="card-title fw-semibold mb-4">Project Listing</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addProjectModal" class="btn btn-sm btn-primary text-white"><i class="fas fa-plus-square pr-4"></i>&nbsp;&nbsp; Add Project</a>
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
                    <div class="mb-3">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                    </div>
                    <div class="table-responsive">
                        <table id="category_table" class="table table-striped align-items-center mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr class="">
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">Name</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Client</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Start Date</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Expected Delivery</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1 text-center">Status</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $index => $project)
                                <tr>
                                    <td><a href="{{ url('t/project/'.$project->slug) }}" class="">{{$project->name}}</a></td>
                                    <td>{{$project->client}}</td>
                                    <td>{{$project->start_date}}</td>
                                    <td>{{$project->expected_delivery_date}}</td>
                                    <td class="text-center">
                                        @if($project->status == '1')
                                            <i class="far fa-check-circle text-success"></i>
                                        @else
                                            <i class="fas fa-ban text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="">
                                        <div class="btn-group" role="group">
                                            <a href="{{ url('t/project/'.$project->slug) }}" class="btn btn-sm btn-primary text-white"><i class="far fa-eye"></i></a>
                                            <a href="#" wire:click="editProject({{$project->id}})" data-bs-toggle="modal" data-bs-target="#editProjectModal" class="btn btn-sm btn-warning text-white"><i class="far fa-edit"></i></a>
                                            <a href="#" wire:click="deleteProject({{$project->id}})" data-bs-toggle="modal" data-bs-target="#deleteProjectModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">No Project Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            {{ $projects->links() }}
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
            $('#addProjectModal').modal('hide');
            $('#editProjectModal').modal('hide');
            $('#deleteProjectModal').modal('hide');
        })
    </script>
@endsection
