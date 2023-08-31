<div>
    @include('livewire.admin.vendor.modal-form')

    @section('pagename')
        <i class="fas fa-project-diagram"></i> Vendors
    @endsection

    @section('breadcrumbs')
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Vendors</li>
        </ol>
    @endsection

    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="col-md-12 d-flex mb-2">
                        <div>
                            <h5 class="card-title fw-semibold mb-4">Vendor Listing</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addVendorModal" class="btn btn-sm btn-primary text-white"><i class="fas fa-plus-square pr-4"></i>&nbsp;&nbsp; Add vendor</a>
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
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Phone</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Email</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Location</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-2">Services</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vendors as $index => $vendor)
                                <tr>
                                    <td>{{$vendor->name}}</td>
                                    <td>{{$vendor->phone}}</td>
                                    <td>{{$vendor->email}}</td>
                                    <td>{{$vendor->location}}</td>
                                    <td>
                                        @foreach($vendor->services as $service)
                                            {{$service->service}}
                                            @if(!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="">
                                        <div class="btn-group" role="group">
                                            <a href="#" wire:click="editVendor({{$vendor->id}})" data-bs-toggle="modal" data-bs-target="#editVendorModal" class="btn btn-sm btn-warning text-white"><i class="far fa-edit"></i></a>
                                            <a href="#" wire:click="deleteVendor({{$vendor->id}})" data-bs-toggle="modal" data-bs-target="#deleteVendorModal" class="btn btn-sm btn-danger text-white"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger">No Vendor Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            {{ $vendors->links() }}
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
            $('#addVendorModal').modal('hide');
            $('#editVendorModal').modal('hide');
            $('#deleteVendorModal').modal('hide');
        })
    </script>
@endsection
