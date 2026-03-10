<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Record Payment') }}
            </h2>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                <i class="las la-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('payments.store') }}">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="number" class="form-label">{{ __('Payment Number') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('number') is-invalid @enderror"
                                                id="number" name="number"
                                                value="{{ old('number', 'PAY-' . strtoupper(Str::random(6))) }}"
                                                required>
                                            @error('number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="date" class="form-label">{{ __('Date') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="date"
                                                class="form-control @error('date') is-invalid @enderror" id="date"
                                                name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="client_id" class="form-label">{{ __('Client') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('client_id') is-invalid @enderror"
                                                id="client_id" name="client_id" required>
                                                <option value="">{{ __('Select Client') }}</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="invoice_id" class="form-label">{{ __('Invoice') }} <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('invoice_id') is-invalid @enderror"
                                                id="invoice_id" name="invoice_id" required>
                                                <option value="">{{ __('Select Invoice') }}</option>
                                                @foreach ($invoices as $invoice)
                                                    <option value="{{ $invoice->id }}"
                                                        data-client-id="{{ $invoice->client_id }}"
                                                        data-remaining="{{ $invoice->total - $invoice->paid }}"
                                                        {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                                                        {{ $invoice->number }} - {{ __('Remaining') }}:
                                                        {{ number_format($invoice->total - $invoice->paid, 2) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('invoice_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">{{ __('Amount') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span
                                                    class="input-group-text">{{ $appSettings['default_currency'] ?? 'USD' }}</span>
                                                <input type="number" step="0.01"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    id="amount" name="amount" value="{{ old('amount') }}" required>
                                            </div>
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="payment_mode"
                                                class="form-label">{{ __('Payment Mode') }}</label>
                                            <select class="form-select @error('payment_mode') is-invalid @enderror"
                                                id="payment_mode" name="payment_mode">
                                                @foreach ($paymentModes as $mode)
                                                    <option value="{{ $mode->name }}"
                                                        {{ old('payment_mode') == $mode->name ? 'selected' : '' }}>
                                                        {{ $mode->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_mode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('payments.index') }}"
                                        class="btn btn-secondary px-4">{{ __('Cancel') }}</a>
                                    <button type="submit"
                                        class="btn btn-primary px-4">{{ __('Record Payment') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const clientSelect = document.getElementById('client_id');
                const invoiceSelect = document.getElementById('invoice_id');
                const amountInput = document.getElementById('amount');
                const invoiceOptions = Array.from(invoiceSelect.options);

                // Function to filter invoices by client
                function filterInvoices(clientId) {
                    const currentInvoiceId = invoiceSelect.value;
                    invoiceSelect.innerHTML = '';

                    invoiceOptions.forEach(option => {
                        if (!option.value || !clientId || option.getAttribute('data-client-id') === clientId) {
                            invoiceSelect.appendChild(option.cloneNode(true));
                        }
                    });

                    // Restore selection if still valid
                    if (currentInvoiceId) {
                        invoiceSelect.value = currentInvoiceId;
                    }
                }

                // Client change event
                clientSelect.addEventListener('change', function() {
                    filterInvoices(this.value);

                    // If client changed and current invoice doesn't belong to it, clear invoice
                    const selectedInvoice = invoiceSelect.options[invoiceSelect.selectedIndex];
                    if (selectedInvoice && selectedInvoice.value && selectedInvoice.getAttribute(
                            'data-client-id') !== this.value) {
                        invoiceSelect.value = '';
                        amountInput.value = '';
                    }
                });

                // Invoice change event
                invoiceSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];

                    if (selectedOption && selectedOption.value) {
                        const clientId = selectedOption.getAttribute('data-client-id');
                        const remaining = selectedOption.getAttribute('data-remaining');

                        // Auto-select client if not already selected
                        if (clientSelect.value !== clientId) {
                            clientSelect.value = clientId;
                            // Re-filter invoices but keep current selection
                            filterInvoices(clientId);
                            invoiceSelect.value = selectedOption.value;
                        }

                        // Pre-fill amount
                        amountInput.value = parseFloat(remaining).toFixed(2);
                    } else {
                        amountInput.value = '';
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
