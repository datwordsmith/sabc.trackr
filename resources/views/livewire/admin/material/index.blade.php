<div>
    @include('livewire.admin.material.modal-form')

    @section('pagename')
        <i class="fas fa-tools"></i> Materials
    @endsection

    @section('breadcrumbs')
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Materials</li>
            </ol>
    @endsection

    <div class="row">
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-header text-light bg-dark">
                    Add New
                  </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="storeMaterial()">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder = "Site Material" wire:model.defer="name">
                            @error('name')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-select" wire:model.defer="category_id" required>
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select class="form-select" wire:model.defer="unit_id" required>
                                <option value="">Select a Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- LISTING -->
        <div class="col-md-8">
            <div class="card w-100">
                <div class="card-body p-4">
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
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-4">Material</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">Category</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-3">Unit</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($materials as $index => $material)
                                    <tr>
                                        <td>{{$material->name}}</td>
                                        <td>{{$material->category}}</td>
                                        <td>{{$material->unit}}</td>
                                        <td class="">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a href="#" wire:click="editMaterial({{$material->id}})" data-bs-toggle="modal" data-bs-target="#editMaterialModal" class="btn btn-sm btn-warning text-white"><i class="fas fa-pen"></i></a>
                                                <a href="#" wire:click="deleteMaterial({{$material->id}})" data-bs-toggle="modal" data-bs-target="#deleteMaterialModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">No Site Materials Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            {{ $materials->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            window.addEventListener('close-modal', event => {
                $('#editMaterialModal').modal('hide');
                $('#deleteMaterialModal').modal('hide');
            });
        });
    </script>
@endsection
