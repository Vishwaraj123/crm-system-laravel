<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Payment Details') }}: {{ $payment->number }}
            </h2>
            <div>
                <a href="{{ route('payments.print', $payment) }}" target="_blank" class="btn btn-primary me-2">
                    <i class="las la-download"></i> {{ __('Download PDF') }}
                </a>
                <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h5 class="fw-bold mb-1 text-primary">{{ __('Payment Receipt') }}</h5>
                                    <p class="text-muted small">{{ $payment->number }}</p>
                                </div>
                                <div class="bg-light rounded-pill px-3 py-1 fw-bold text-success">
                                    {{ __('PAID') }}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase x-small fw-bold mb-2">{{ __('Received From') }}
                                    </h6>
                                    <h5 class="fw-bold mb-1">{{ $payment->client->name }}</h5>
                                    <p class="text-muted small mb-0">{{ $payment->client->email }}</p>
                                    <p class="text-muted small">{{ $payment->client->phone }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <h6 class="text-muted text-uppercase x-small fw-bold mb-2">{{ __('Payment Date') }}
                                    </h6>
                                    <p class="fw-bold mb-0">
                                        {{ $payment->date->format($appSettings['date_format'] ?? 'd/m/Y') }}</p>
                                    <h6 class="text-muted text-uppercase x-small fw-bold mt-3 mb-2">
                                        {{ __('Payment Mode') }}</h6>
                                    <p class="fw-bold mb-0">{{ $payment->payment_mode ?? __('N/A') }}</p>
                                </div>
                            </div>

                            <div class="table-responsive mb-4">
                                <table class="table table-borderless align-middle bg-light rounded-4">
                                    <thead>
                                        <tr>
                                            <th class="py-3 px-4">{{ __('Invoice Reference') }}</th>
                                            <th class="py-3 text-end px-4">{{ __('Amount Paid') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="py-3 px-4">
                                                <div class="fw-bold">{{ $payment->invoice->number }}</div>
                                                <div class="text-muted x-small">{{ __('Date') }}:
                                                    {{ $payment->invoice->date->format($appSettings['date_format'] ?? 'd/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="py-3 text-end px-4 fw-bold text-primary fs-5">
                                                {{ $appSettings['default_currency'] ?? 'USD' }}
                                                {{ number_format($payment->amount, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if ($payment->notes)
                                <div class="pt-3 border-top mt-4">
                                    <h6 class="text-muted text-uppercase x-small fw-bold mb-2">{{ __('Notes') }}</h6>
                                    <p class="text-muted small">{{ $payment->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-4 d-inline-block mb-3">
                                <i class="las la-file-invoice-dollar fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-1">{{ __('Invoice Status') }}</h5>
                            <p class="text-muted small mb-3">{{ __('Related to') }} {{ $payment->invoice->number }}
                            </p>

                            <div class="progress mb-2" style="height: 10px;">
                                @php
                                    $percentage = ($payment->invoice->paid / $payment->invoice->total) * 100;
                                @endphp
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between x-small fw-bold mb-4">
                                <span class="text-success">{{ __('Paid') }}:
                                    {{ $appSettings['default_currency'] ?? 'USD' }}
                                    {{ number_format($payment->invoice->paid, 2) }}</span>
                                <span class="text-muted">{{ __('Total') }}:
                                    {{ $appSettings['default_currency'] ?? 'USD' }}
                                    {{ number_format($payment->invoice->total, 2) }}</span>
                            </div>

                            <a href="{{ route('invoices.show', $payment->invoice) }}"
                                class="btn btn-outline-primary w-100 rounded-pill">
                                {{ __('View Invoice') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
