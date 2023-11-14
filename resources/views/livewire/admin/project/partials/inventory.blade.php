<div class="card w-100">
    <div class="card-body p-4">
        <div class="border-bottom border-danger mb-3 d-flex">
            <div>
                <h5 class="card-title fw-semibold pb-2">Project Inventory Report</h5>
            </div>
            <div class="ms-auto">
                @if ($storeItems->count() > 0)
                    <button type="button" class="btn btn-sm btn-info " onclick="exportToCSV('inventory')"><i class="fas fa-file-csv fa-lg"></i> <span class="d-none d-md-inline">Export</span></button>
                @endif
            </div>
        </div>

        <div class="row">
            <!-- ROW 2, COL 1 -->
            <div class="col-md-12">
                <div>

                    <div class="mb-3">
                        <input type="text" class="form-control mb-2" wire:model="storeSearch" placeholder="Search...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center mb-0" id="inventory">
                            <thead class="table-dark">
                                <tr>
                                    <th>Material</th>
                                    <th>Category</th>
                                    <th>Budgeted</th>
                                    <th>Inflow</th>
                                    <th>Out</th>
                                    <th>Stock Balance</th>
                                    <th>Approved Requisition</th>
                                    <th>Supply Balance</th>
                                    <th>Budget Balance</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($storeItems as $storeItem)
                                    <tr>
                                        <td>{{ $storeItem->material->name }} ({{ $storeItem->material->unit->name }})</td>
                                        <td>{{ $storeItem->material->category->category }}</td>
                                        <td class="text-center">{{ $storeItem->totalBudgetQuantity  }}</td>
                                        <td class="text-center">{{ $storeItem->inflowSum  }}</td>
                                        <td class="text-center">{{ $storeItem->outgoingSum }}</td>
                                        <td class="text-center">{{ $storeItem->inflowSum - $storeItem->outgoingSum }}</td>
                                        <td class="text-center">{{ $storeItem->requisitionSum }}</td>
                                        <td class="text-center">{{ $storeItem->supplyBalance }}</td>
                                        <td class="text-center">{{ $storeItem->budgetBalance }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $storeItems->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
