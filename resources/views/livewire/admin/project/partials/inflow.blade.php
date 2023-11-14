<div class="card w-100">
    <div class="card-body p-4">
        <div class="border-bottom border-danger mb-3 d-flex">
            <div>
                <h5 class="card-title fw-semibold pb-2">Material Infow (Store)</h5>
            </div>
            <div class="ms-auto">
                <div class="btn-group" role="group" aria-label="">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#supplyModal"
                            class="btn btn-sm btn-success text-white"><i
                            class="far fa-arrow-alt-circle-right fa-rotate-90"></i> <span class="d-none d-md-inline">In</span></a>
                </div>
                @if ($inventoryItems->count() > 0)
                    <button type="button" class="btn btn-sm btn-info " onclick="exportToCSV('materialInflow')"><i class="fas fa-file-csv fa-lg"></i> <span class="d-none d-md-inline">Export</span></button>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- ROW 2, COL 1 -->
            <div class="col-md-12">
                <div>

                    <div class="mb-3">
                        <input type="text" class="form-control mb-2" wire:model="inventorySearch" placeholder="Search...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center mb-0" id="materialInflow">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Material</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Purpose</th>
                                    <th class="text-center">Status</th>
                                    <th>Received By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventoryItems as $inventoryItem)
                                    <tr>
                                        <td>{{ $inventoryItem->created_at->format('d-M-Y') }}</td>
                                        <td>{{ $inventoryItem->material->name }} ({{ $inventoryItem->material->unit->name }})</td>
                                        <td>{{ $inventoryItem->material->category->category }}</td>
                                        <td class="text-center">{{ $inventoryItem->quantity }}</td>
                                        <td>{{ $inventoryItem->purpose }}</td>
                                        <td class="text-center">
                                            @if ($inventoryItem->flow == 1)
                                                <span class="badge bg-success">Inflow</span>
                                            @else
                                                <span class="badge bg-danger">Out</span>
                                            @endif
                                        </td>
                                        <td>{{ $inventoryItem->receiver }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $inventoryItems->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
