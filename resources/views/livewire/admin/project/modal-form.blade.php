    <!-- ADD PROJECT MODAL -->
    <div wire:ignore.self class="modal fade" id="addProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add Project</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeProject()">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" placeholder = "Project Name" wire:model.defer="name">
                            @error('name')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" placeholder = "Project Description" rows="3" wire:model.defer="description"></textarea>
                            @error('description')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Client</label>
                            <input type="text" class="form-control" placeholder = "Client" wire:model.defer="client">
                            @error('client')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" wire:model.defer="start_date">
                            @error('start_date')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Expected Delivery Date</label>
                            <input type="date" class="form-control" wire:model.defer="expected_delivery_date">
                            @error('expected_delivery_date')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
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


    <!-- EDIT PROJECT MODAL -->
    <div wire:ignore.self class="modal fade" id="editProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit Project</h1>
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
                    <form wire:submit.prevent="updateProject()">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Project Name</label>
                                <input type="text" class="form-control" placeholder = "Project Name" wire:model.defer="name">
                                @error('name')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" placeholder = "Project Description" rows="3" wire:model.defer="description"></textarea>
                                @error('description')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Client</label>
                                <input type="text" class="form-control" placeholder = "Client" wire:model.defer="client">
                                @error('client')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" wire:model.defer="start_date">
                                @error('start_date')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Expected Delivery Date</label>
                                <input type="date" class="form-control" wire:model.defer="expected_delivery_date">
                                @error('expected_delivery_date')
                                    <small class="error text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END EDIT MODAL -->


    <!-- DELETE PROJECT MODAL -->
    <div wire:ignore.self class="modal fade" id="deleteProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete Project</h1>
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
                    <form wire:submit.prevent="destroyProject()">
                        <div class="modal-body">
                            <h4>Are you sure you want to delete this project?</h4>
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
