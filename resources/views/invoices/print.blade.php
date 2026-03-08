<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice') }} - {{ $invoice->number }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: white; color: black; font-size: 14px; }
        .invoice-box { padding: 40px; margin: auto; }
        .company-logo { max-height: 70px; max-width: 180px; object-fit: contain; }
        .table thead th { background-color: #f8f9fa !important; color: black !important; border-bottom: 2px solid #dee2e6; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
            .invoice-box { padding: 20px; width: 100%; border: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container my-5 no-print">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="las la-print"></i> {{ __('Print Again') }}
            </button>
            <a href="{{ route('invoices.index') }}" class="btn btn-light ms-2">{{ __('Back to List') }}</a>
        </div>
    </div>

    @php
        $dateFormat     = $appSettings['date_format']     ?? 'd/m/Y';
        $currencySymbol = $appSettings['currency_symbol'] ?? '';
        $companyName    = $appSettings['company_name']    ?? '';
        $companyAddress = $appSettings['company_address'] ?? '';
        $companyState   = $appSettings['company_state']   ?? '';
        $companyCountry = $appSettings['company_country'] ?? '';
        $companyEmail   = $appSettings['company_email']   ?? '';
        $companyPhone   = $appSettings['company_phone']   ?? '';
        $companyWebsite = $appSettings['company_website'] ?? '';
        $companyTax     = $appSettings['company_tax_number'] ?? '';
        $companyLogo    = $appSettings['company_logo']    ?? '';
    @endphp

    <div class="invoice-box shadow-sm rounded border mx-auto" style="max-width: 900px;">

        {{-- ── HEADER ── --}}
        <div class="row mb-5 align-items-start">
            <div class="col-6">
                <h1 class="fw-bold text-primary mb-1">{{ __('INVOICE') }}</h1>
                <p class="text-muted mb-0">{{ $invoice->number }}</p>
            </div>
            <div class="col-6 text-end">
                <div class="mb-2">
                    <p class="mb-0 text-muted small">{{ __('Date') }}</p>
                    <p class="fw-bold mb-0">{{ $invoice->date->format($dateFormat) }}</p>
                </div>
                <div>
                    <p class="mb-0 text-muted small">{{ __('Due Date') }}</p>
                    <p class="fw-bold mb-0">{{ $invoice->expired_date->format($dateFormat) }}</p>
                </div>
            </div>
        </div>

        {{-- ── FROM / TO ── --}}
        <div class="row mb-5 py-4 border-top border-bottom">

            {{-- FROM: Company --}}
            <div class="col-6">
                <p class="text-muted small text-uppercase fw-bold mb-2">{{ __('From') }}</p>
                @if($companyLogo)
                    <img src="{{ Storage::url($companyLogo) }}" class="company-logo mb-2" alt="{{ $companyName }}">
                @endif
                <h5 class="fw-bold mb-1">{{ $companyName }}</h5>
                @if($companyAddress)   <p class="mb-0 small">{{ $companyAddress }}</p> @endif
                @if($companyState || $companyCountry)
                    <p class="mb-0 small">{{ implode(', ', array_filter([$companyState, $companyCountry])) }}</p>
                @endif
                @if($companyEmail)    <p class="mb-0 small">{{ $companyEmail }}</p> @endif
                @if($companyPhone)    <p class="mb-0 small">{{ $companyPhone }}</p> @endif
                @if($companyWebsite)  <p class="mb-0 small">{{ $companyWebsite }}</p> @endif
                @if($companyTax)      <p class="mb-0 small text-muted">{{ __('Tax/VAT') }}: {{ $companyTax }}</p> @endif
            </div>

            {{-- TO: Client + Status --}}
            <div class="col-6 text-end">
                <p class="text-muted small text-uppercase fw-bold mb-2">{{ __('Bill To') }}</p>
                <h5 class="fw-bold mb-1">{{ $invoice->client->name }}</h5>
                <p class="mb-0 small">{{ $invoice->client->email }}</p>
                <p class="mb-0 small">{{ $invoice->client->phone }}</p>
                <div class="mt-3">
                    <p class="text-muted small text-uppercase fw-bold mb-1">{{ __('Status') }}</p>
                    <p class="fw-bold text-uppercase mb-0">{{ $invoice->status }}</p>
                </div>
            </div>
        </div>

        {{-- ── ITEMS TABLE ── --}}
        <table class="table table-borderless align-middle mb-5">
            <thead>
                <tr class="border-bottom">
                    <th class="py-3 px-0">{{ __('Item Description') }}</th>
                    <th class="py-3 text-center" style="width:100px;">{{ __('Qty') }}</th>
                    <th class="py-3 text-end" style="width:160px;">{{ __('Price') }}</th>
                    <th class="py-3 text-end" style="width:160px;">{{ __('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr class="border-bottom">
                    <td class="py-3 px-0">{{ $item->itemName }}</td>
                    <td class="py-3 text-center">{{ $item->quantity }}</td>
                    <td class="py-3 text-end">{{ $currencySymbol }}{{ number_format($item->price, 2) }}</td>
                    <td class="py-3 text-end fw-bold">{{ $currencySymbol }}{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ── TOTALS ── --}}
        <div class="row justify-content-end">
            <div class="col-5">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">{{ __('Sub Total') }}:</span>
                    <span class="fw-bold">{{ $currencySymbol }}{{ number_format($invoice->sub_total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">{{ __('Tax') }} ({{ $invoice->tax_rate }}%):</span>
                    <span class="fw-bold">{{ $currencySymbol }}{{ number_format($invoice->tax_total, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold">{{ __('Grand Total') }}:</h5>
                    <h4 class="fw-bold text-primary">{{ $currencySymbol }}{{ number_format($invoice->total, 2) }}</h4>
                </div>
            </div>
        </div>

        @if($invoice->notes)
        <div class="mt-5 pt-4 border-top">
            <p class="text-muted small text-uppercase fw-bold mb-2">{{ __('Notes') }}</p>
            <p class="small text-muted mb-0">{{ $invoice->notes }}</p>
        </div>
        @endif
    </div>

    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    @php use Illuminate\Support\Facades\Storage; @endphp
</body>
</html>
