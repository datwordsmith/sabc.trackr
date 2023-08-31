<div>
    @include('livewire.admin.measure.modal-form')

    @section('pagename')
        <i class="fas fa-ruler-combined"></i> Units/Measures
    @endsection

    @section('breadcrumbs')
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Units/Measures</li>
            </ol>
    @endsection

    <div class="row">
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-header text-light bg-dark">
                    Add New
                  </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="storeUnit()">
                        <div class="mb-3">

                            <input type="text" class="form-control" placeholder = "New Unit" wire:model.defer="name">
                            @error('name')
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

        <!-- CATEGORY LISTING -->
        <div class="col-md-8 d-flex align-items-stretch">
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
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-10">Measure/Unit</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($units as $index => $unit)
                                    <tr>
                                        <td>{{$unit->name}}</td>
                                        <td class="">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a href="#" wire:click="editUnit({{$unit->id}})" data-bs-toggle="modal" data-bs-target="#editUnitModal" class="btn btn-sm btn-warning text-white"><i class="fas fa-pen"></i></a>
                                                <a href="#" wire:click="deleteUnit({{$unit->id}})" data-bs-toggle="modal" data-bs-target="#deleteUnitModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">No Unit/Measure Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            {{ $units->links() }}
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
                $('#addUnitModal').modal('hide');
                $('#editUnitModal').modal('hide');
                $('#deleteUnitModal').modal('hide');
            });
        });
    </script>
@endsection
