<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Proposal') }} - {{ $proposal->number }}</title>
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

        .mb-5 {
            margin-bottom: 40px;
        }

        .mt-5 {
            margin-top: 40px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 12px 8px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .table thead th {
            background-color: #f8f9fa;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }

        .company-logo {
            max-height: 70px;
            max-width: 180px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table td {
            vertical-align: top;
            width: 50%;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            display: inline-block;
        }

        .draft {
            background: #6c757d;
            color: #fff;
        }

        .pending {
            background: #ffc107;
            color: #000;
        }

        .sent {
            background: #0dcaf0;
            color: #fff;
        }

        .accepted {
            background: #198754;
            color: #fff;
        }

        .declined {
            background: #dc3545;
            color: #fff;
        }

        .cancelled {
            background: #212529;
            color: #fff;
        }
    </style>
</head>

<body>
    @php
        $dateFormat = $appSettings['date_format'] ?? 'd/m/Y';
        $currencyCode = $appSettings['default_currency'] ?? 'USD';
        $companyName = $appSettings['company_name'] ?? '';
        $companyAddress = $appSettings['company_address'] ?? '';
        $companyState = $appSettings['company_state'] ?? '';
        $companyCountry = $appSettings['company_country'] ?? '';
        $companyEmail = $appSettings['company_email'] ?? '';
        $companyPhone = $appSettings['company_phone'] ?? '';
        $companyWebsite = $appSettings['company_website'] ?? '';
        $companyTax = $appSettings['company_tax_number'] ?? '';
        $companyLogo = $appSettings['company_logo'] ?? '';
    @endphp

    <table class="info-table">
        <tr>
            <td>
                <h1 class="fw-bold text-primary mb-1">{{ __('PROPOSAL') }}</h1>
                <p class="text-muted">{{ $proposal->number }}</p>
            </td>
            <td class="text-end">
                <div class="mb-2">
                    <span class="text-muted small">{{ __('Date') }}:</span>
                    <span class="fw-bold">{{ $proposal->date->format($dateFormat) }}</span>
                </div>
                <div>
                    <span class="text-muted small">{{ __('Expiry Date') }}:</span>
                    <span class="fw-bold">{{ $proposal->expired_date->format($dateFormat) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="info-table" style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 20px 0;">
        <tr>
            <td>
                <p class="text-muted small fw-bold mb-2">{{ __('From') }}</p>
                @if ($companyLogo)
                    <img src="{{ public_path('storage/' . $companyLogo) }}" class="company-logo mb-2"
                        alt="{{ $companyName }}">
                @endif
                <h3 class="fw-bold mb-1">{{ $companyName }}</h3>
                <div class="small">
                    @if ($companyAddress)
                        {{ $companyAddress }}<br>
                    @endif
                    @if ($companyState || $companyCountry)
                        {{ implode(', ', array_filter([$companyState, $companyCountry])) }}<br>
                    @endif
                    @if ($companyEmail)
                        {{ $companyEmail }}<br>
                    @endif
                    @if ($companyPhone)
                        {{ $companyPhone }}<br>
                    @endif
                    @if ($companyTax)
                        <span class="text-muted">{{ __('Tax/VAT') }}: {{ $companyTax }}</span>
                    @endif
                </div>
            </td>
            <td class="text-end">
                <p class="text-muted small fw-bold mb-2">{{ __('Proposed To') }}</p>
                <h3 class="fw-bold mb-1">{{ $proposal->client->name }}</h3>
                <div class="small">
                    {{ $proposal->client->email }}<br>
                    {{ $proposal->client->phone }}
                </div>
                <div class="mt-5">
                    <p class="text-muted small fw-bold mb-1">{{ __('Status') }}</p>
                    <span class="status-badge {{ $proposal->status }}">{{ strtoupper($proposal->status) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Item Description') }}</th>
                <th class="text-center" style="width:80px;">{{ __('Qty') }}</th>
                <th class="text-end" style="width:120px;">{{ __('Price') }}</th>
                <th class="text-end" style="width:120px;">{{ __('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposal->items as $item)
                <tr>
                    <td>{{ $item->itemName }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">{{ number_format($item->price, 2) }}</td>
                    <td class="text-end fw-bold">{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;">
                <table style="width: 100%;">
                    <tr>
                        <td class="text-muted">{{ __('Sub Total') }}:</td>
                        <td class="text-end fw-bold">{{ $currencyCode }} {{ number_format($proposal->sub_total, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">{{ __('Tax') }} ({{ $proposal->tax_rate }}%):</td>
                        <td class="text-end fw-bold">{{ $currencyCode }} {{ number_format($proposal->tax_total, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr style="border: none; border-top: 1px solid #dee2e6;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3 class="fw-bold">{{ __('Total') }}:</h3>
                        </td>
                        <td class="text-end">
                            <h3 class="fw-bold text-primary">{{ $currencyCode }}
                                {{ number_format($proposal->total, 2) }}</h3>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @if ($proposal->notes)
        <div class="mt-5" style="border-top: 1px solid #eee; padding-top: 20px;">
            <p class="text-muted small fw-bold mb-2">{{ __('Notes') }}</p>
            <p class="small text-muted">{{ $proposal->notes }}</p>
        </div>
    @endif
</body>

</html>
