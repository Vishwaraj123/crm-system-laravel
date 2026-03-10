<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Payment Receipt') }} - {{ $payment->number }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: #333;
            margin: 40px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-primary {
            color: #0d6efd;
        }

        .text-muted {
            color: #6c757d;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-4 {
            margin-bottom: 24px;
        }

        .mt-5 {
            margin-top: 40px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table td {
            vertical-align: top;
            width: 50%;
        }

        .company-logo {
            max-height: 70px;
            max-width: 180px;
        }

        .receipt-box {
            border: 1px solid #dee2e6;
            padding: 30px;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .payment-amount {
            font-size: 24px;
            font-weight: bold;
            color: #198754;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    @php
        $dateFormat = $appSettings['date_format'] ?? 'd/m/Y';
        $currencyCode = $appSettings['default_currency'] ?? 'USD';
        $companyName = $appSettings['company_name'] ?? '';
        $companyAddress = $appSettings['company_address'] ?? '';
        $companyEmail = $appSettings['company_email'] ?? '';
        $companyPhone = $appSettings['company_phone'] ?? '';
        $companyLogo = $appSettings['company_logo'] ?? '';
    @endphp

    <table class="info-table">
        <tr>
            <td>
                @if ($companyLogo)
                    <img src="{{ public_path('storage/' . $companyLogo) }}" class="company-logo mb-2"
                        alt="{{ $companyName }}">
                @endif
                <h3 class="fw-bold mb-1">{{ $companyName }}</h3>
                <div class="small">
                    {{ $companyAddress }}<br>
                    {{ $companyEmail }} | {{ $companyPhone }}
                </div>
            </td>
            <td class="text-end">
                <h1 class="fw-bold text-primary mb-1">{{ __('RECEIPT') }}</h1>
                <p class="text-muted">{{ __('Payment #') }}{{ $payment->number }}</p>
                <div class="mt-2 small">
                    <span class="text-muted">{{ __('Date') }}:</span>
                    <span class="fw-bold">{{ $payment->date->format($dateFormat) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="receipt-box mb-4">
        <div class="row">
            <div style="margin-bottom: 20px;">
                <p class="text-muted small fw-bold mb-1">{{ __('Received From') }}</p>
                <h4 class="fw-bold mb-0">{{ $payment->client->name }}</h4>
                <p class="text-muted small">{{ $payment->client->email }}</p>
            </div>

            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <p class="text-muted small fw-bold mb-1">{{ __('Payment Method') }}</p>
                        <p class="fw-bold">{{ $payment->payment_mode ?? __('N/A') }}</p>
                    </td>
                    <td style="width: 50%;" class="text-end">
                        <p class="text-muted small fw-bold mb-1">{{ __('Amount Paid') }}</p>
                        <div class="payment-amount">{{ $currencyCode }} {{ number_format($payment->amount, 2) }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if ($payment->invoice)
        <table class="table" style="width: 100%; border-top: 1px solid #dee2e6; padding-top: 20px;">
            <tr>
                <td>
                    <p class="text-muted small fw-bold mb-1">{{ __('Applied To Invoice') }}</p>
                    <p class="mb-0 fw-bold">{{ $payment->invoice->number }}
                        ({{ $payment->invoice->date->format($dateFormat) }})</p>
                </td>
                <td class="text-end">
                    <p class="text-muted small fw-bold mb-1">{{ __('Invoice Total') }}</p>
                    <p class="mb-0 fw-bold">{{ $currencyCode }} {{ number_format($payment->invoice->total, 2) }}</p>
                </td>
            </tr>
        </table>
    @endif

    @if ($payment->notes)
        <div class="mt-5 pt-3" style="border-top: 1px solid #eee;">
            <p class="text-muted small fw-bold mb-1">{{ __('Notes') }}</p>
            <p class="small text-muted">{{ $payment->notes }}</p>
        </div>
    @endif

    <div class="mt-5 text-center text-muted small">
        <p>{{ __('Thank you for your business!') }}</p>
    </div>
</body>

</html>
