    <!-- ADD VENDOR MODAL -->
    <div wire:ignore.self class="modal fade" id="addVendorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Service</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeVendor()">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Vendor</label>
                            <input type="text" class="form-control" placeholder = "Vendor Name" wire:model.defer="name" required>
                            @error('name')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" placeholder = "Phone Number" wire:model.defer="phone" required>
                            @error('phone')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder = "Email Address" wire:model.defer="email">
                            @error('email')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" placeholder = "Vendor's Location" wire:model.defer="location" required>
                            @error('location')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Services:</label>

                            @foreach ($services as $index => $service)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" wire:model.defer="services.{{ $index }}" placeholder="Service name">
                                    <button type="button" class="btn btn-danger" wire:click="removeService({{ $index }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach

                            <button type="button" class="btn btn-success mb-2" wire:click="addService">
                                <i class="fas fa-plus"></i> Add service
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END ADD MODAL -->


    <!-- EDIT VENDOR MODAL -->
    <div wire:ignore.self class="modal fade" id="editVendorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit Vendor</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="updateVendor()">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Vendor</label>
                                <input type="text" class="form-control" placeholder="Vendor Name" wire:model.defer="name" required>
                                @error('name')
                                <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" placeholder="Phone Number" wire:model.defer="phone" required>
                                @error('phone')
                                <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Email Address" wire:model.defer="email">
                                @error('email')
                                <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" placeholder="Vendor's Location" wire:model.defer="location" required>
                                @error('location')
                                <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Services:</label>

                                @foreach ($services as $index => $service)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" wire:model.defer="services.{{ $index }}" placeholder="Service name">
                                        <button type="button" class="btn btn-danger" wire:click="removeService({{ $index }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach

                                <button type="button" class="btn btn-success mb-2" wire:click="addService">
                                    <i class="fas fa-plus"></i> Add service
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END EDIT MODAL -->


    <!-- DELETE VENDOR MODAL -->
    <div wire:ignore.self class="modal fade" id="deleteVendorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Vendor</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div wire:loading class="py-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div wire:loading.remove>
                    <form wire:submit.prevent="destroyVendor()">
                        <div class="modal-body">
                            <h4>Are you sure you want to delete this vendor?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END DELETE MODAL -->
