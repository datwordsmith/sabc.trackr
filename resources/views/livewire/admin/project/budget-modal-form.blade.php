<!-- ADD BUDGET MODAL -->
<div wire:ignore.self class="modal fade" id="setBudgetModal" tabindex="-1" aria-hidden="true" wire:dirty.class="dummy">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom border-warning">
                <h1 class="modal-title fs-5">Assign Project Budget</h1>
                <button type="button" class="btn-close" wire:click="closeModalAndRefresh" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="saveBudget">
                <div class="modal-body">
                    <div class="row">
                        <div>
                            <h5>Unassigned Materials</h5>
                            @foreach ($unassignedMaterials as $material)
                                <div>
                                    <input type="checkbox" value="{{ $material->id }}" wire:model="selectedMaterials.{{ $material->id }}.isSelected">
                                    <label>{{ $material->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            <h5>Assigned Materials</h5>
                            @foreach ($assignedMaterials as $material)
                                <div>
                                    <label>{{ $material->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModalAndRefresh">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END ADD MODAL -->
