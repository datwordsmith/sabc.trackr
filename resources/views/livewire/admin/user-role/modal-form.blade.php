    <!-- ADD ROLE MODAL -->
    <div wire:ignore.self class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add User Role</h1>
                    <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeRole()">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" placeholder = "User Role" wire:model.defer="role">
                            @error('role')
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


    <!-- EDIT ROLE MODAL -->
    <div wire:ignore.self class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit User Role</h1>
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
                    <form wire:submit.prevent="updateRole()">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">User Role</label>
                                <input type="text" class="form-control" placeholder = "User Role" wire:model.defer="role">
                                @error('role')
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
    <div wire:ignore.self class="modal fade" id="deleteRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Delete User Role</h1>
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
                    <form wire:submit.prevent="destroyRole()">
                        <div class="modal-body">
                            <h4>Are you sure you want to delete this role?</h4>
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
