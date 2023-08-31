<div>
    @include('livewire.admin.material-category.modal-form')

    @section('pagename')
        <i class="fas fa-puzzle-piece"></i> Material Categories
    @endsection

    @section('breadcrumbs')
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Material Categories</li>
            </ol>
    @endsection

    <div class="row">
        <div class="col-md-4">
            <div class="card w-100">
                <div class="card-header text-light bg-dark">
                    Add New
                  </div>
                <div class="card-body p-4">
                    <form wire:submit.prevent="storeCategory()">
                        <div class="mb-3">

                            <input type="text" class="form-control" placeholder = "Material Category" wire:model.defer="category">
                            @error('category')
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
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-10">Category</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td>{{$category->category}}</td>
                                        <td class="">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a href="#" wire:click="editCategory({{$category->id}})" data-bs-toggle="modal" data-bs-target="#editCategoryModal" class="btn btn-sm btn-warning text-white"><i class="fas fa-pen"></i></a>
                                                <a href="#" wire:click="deleteCategory({{$category->id}})" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">No Material Category Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            {{ $categories->links() }}
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
                $('#addCategoryModal').modal('hide');
                $('#editCategoryModal').modal('hide');
                $('#deleteCategoryModal').modal('hide');
            });
        });
    </script>
@endsection
