<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Invoice') }}: {{ $invoice->number }}
            </h2>
            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-outline-primary btn-sm px-3">
                    <i class="las la-edit"></i> {{ __('Edit') }}
                </a>
                <button class="btn btn-primary btn-sm px-3">
                    <i class="las la-download"></i> {{ __('Download PDF') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card shadow-sm border-0 mb-4 rounded-4 overflow-hidden">
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-between mb-5">
                                <div>
                                    <h3 class="fw-bold text-primary mb-1">{{ __('INVOICE') }}</h3>
                                    <p class="text-muted">{{ $invoice->number }}</p>
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-bold">{{ config('app.name') }}</h5>
                                    <p class="text-muted small mb-0">{{ __('Date') }}: {{ $invoice->date->format('d/m/Y') }}</p>
                                    <p class="text-muted small">{{ __('Due Date') }}: {{ $invoice->expired_date->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <hr class="my-5 opacity-10">

                            <div class="row mb-5">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase small fw-bold mb-3">{{ __('Bill To') }}</h6>
                                    <h5 class="fw-bold mb-1">{{ $invoice->client->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $invoice->client->email }}</p>
                                    <p class="text-muted small">{{ $invoice->client->phone }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <h6 class="text-muted text-uppercase small fw-bold mb-3">{{ __('Status') }}</h6>
                                    @php
                                        $statusClass = [
                                            'draft' => 'bg-secondary',
                                            'pending' => 'bg-warning',
                                            'sent' => 'bg-info',
                                            'paid' => 'bg-success',
                                            'expired' => 'bg-danger',
                                        ][$invoice->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $statusClass }} rounded-pill px-3">{{ strtoupper($invoice->status) }}</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="py-3 px-4">{{ __('Item description') }}</th>
                                            <th class="py-3 text-center" style="width: 100px;">{{ __('Qty') }}</th>
                                            <th class="py-3 text-end" style="width: 150px;">{{ __('Price') }}</th>
                                            <th class="py-3 text-end" style="width: 150px;">{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoice->items as $item)
                                        <tr class="border-bottom">
                                            <td class="py-4 px-4">
                                                <div class="fw-bold text-dark">{{ $item->itemName }}</div>
                                            </td>
                                            <td class="py-4 text-center">{{ $item->quantity }}</td>
                                            <td class="py-4 text-end">{{ number_format($item->price, 2) }}</td>
                                            <td class="py-4 text-end fw-bold text-dark">{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-end mt-5">
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">{{ __('Sub Total') }}:</span>
                                        <span class="fw-bold">{{ number_format($invoice->sub_total, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">{{ __('Tax') }} ({{ $invoice->tax_rate }}%):</span>
                                        <span class="fw-bold">{{ number_format($invoice->tax_total, 2) }}</span>
                                    </div>
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold">{{ __('Total') }}:</h5>
                                        <h4 class="fw-bold text-primary">{{ number_format($invoice->total, 2) }}</h4>
                                    </div>
                                </div>
                            </div>

                            @if($invoice->notes)
                            <div class="mt-5 pt-5 border-top">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">{{ __('Notes') }}</h6>
                                <p class="text-muted small">{{ $invoice->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0 mb-4 rounded-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-4">{{ __('Payment History') }}</h6>
                            @forelse($invoice->payments as $payment)
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light rounded p-2 me-3">
                                    <i class="las la-money-bill text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">{{ number_format($payment->amount, 2) }}</div>
                                    <div class="text-muted x-small">{{ $payment->date->format('d M, Y') }}</div>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted small text-center my-4">{{ __('No payments recorded.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
