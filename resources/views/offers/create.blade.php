<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold text-dark mb-0">
            {{ __('Create New Quote') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <form method="POST" action="{{ route('offers.store') }}" id="offer-form">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-4">{{ __('General Information') }}</h5>
                                
                                <div class="mb-3">
                                    <label for="client_id" class="form-label">{{ __('Client') }} <span class="text-danger">*</span></label>
                                    <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                        <option value="">{{ __('Select Client') }}</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="number" class="form-label">{{ __('Quote Number') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number', 'QT-' . date('YmdHis')) }}" required>
                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="expired_date" class="form-label">{{ __('Expiry Date') }} <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('expired_date') is-invalid @enderror" id="expired_date" name="expired_date" value="{{ old('expired_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                    @error('expired_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tax_rate" class="form-label">{{ __('Tax Rate (%)') }}</label>
                                    <input type="number" step="0.01" class="form-control @error('tax_rate') is-invalid @enderror" id="tax_rate" name="tax_rate" value="{{ old('tax_rate', 0) }}">
                                    @error('tax_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-4 d-flex justify-content-between">
                                    {{ __('Items') }}
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-item">
                                        <i class="las la-plus"></i> {{ __('Add Item') }}
                                    </button>
                                </h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="items-table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th style="width: 40%;">{{ __('Item Name') }}</th>
                                                <th style="width: 15%;">{{ __('Quantity') }}</th>
                                                <th style="width: 20%;">{{ __('Price') }}</th>
                                                <th style="width: 20%;">{{ __('Total') }}</th>
                                                <th style="width: 5%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="items-container">
                                            {{-- Rows will be added here via JS --}}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">{{ __('Sub Total') }}</th>
                                                <th id="sub-total-display">0.00</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="text-end">{{ __('Tax Amount') }}</th>
                                                <th id="tax-amount-display">0.00</th>
                                                <th></th>
                                            </tr>
                                            <tr class="table-primary">
                                                <th colspan="3" class="text-end fw-bold">{{ __('Grand Total') }}</th>
                                                <th class="fw-bold" id="grand-total-display">0.00</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('offers.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Save Quote') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('items-container');
            const addButton = document.getElementById('add-item');
            const taxInput = document.getElementById('tax_rate');
            
            let itemCount = 0;

            function addItem() {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <input type="text" name="items[${itemCount}][itemName]" class="form-control form-control-sm" required placeholder="Item description">
                    </td>
                    <td>
                        <input type="number" name="items[${itemCount}][quantity]" class="form-control form-control-sm item-qty" required value="1" min="1">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="items[${itemCount}][price]" class="form-control form-control-sm item-price" required value="0.00">
                    </td>
                    <td class="item-total text-end fw-bold">0.00</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                            <i class="las la-times"></i>
                        </button>
                    </td>
                `;
                container.appendChild(row);
                
                // Add event listeners for calculations
                row.querySelector('.item-qty').addEventListener('input', calculate);
                row.querySelector('.item-price').addEventListener('input', calculate);
                row.querySelector('.remove-item').addEventListener('click', function() {
                    row.remove();
                    calculate();
                });

                itemCount++;
                calculate();
            }

            function calculate() {
                let subTotal = 0;
                container.querySelectorAll('tr').forEach(row => {
                    const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
                    const price = parseFloat(row.querySelector('.item-price').value) || 0;
                    const total = qty * price;
                    row.querySelector('.item-total').textContent = total.toFixed(2);
                    subTotal += total;
                });

                const taxRate = parseFloat(taxInput.value) || 0;
                const taxAmount = subTotal * (taxRate / 100);
                const grandTotal = subTotal + taxAmount;

                document.getElementById('sub-total-display').textContent = subTotal.toFixed(2);
                document.getElementById('tax-amount-display').textContent = taxAmount.toFixed(2);
                document.getElementById('grand-total-display').textContent = grandTotal.toFixed(2);
            }

            addButton.addEventListener('click', addItem);
            taxInput.addEventListener('input', calculate);

            // Initial row
            addItem();
        });
    </script>
    @endpush
</x-app-layout>
