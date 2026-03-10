<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-bold">{{ __('Dashboard') }}</h2>
    </x-slot>

    @php
        $invoiceTotal = max($stats['invoice_total'], 1);
        $proposalTotal = max($stats['proposal_total'], 1);
        $clientTotal = max($stats['clients_total'], 1);
        $fmt = $appSettings['date_format'] ?? 'd/m/Y';
        $sym = $appSettings['default_currency'] ?? '';

        $invoiceLabels = [
            'draft' => 'Draft',
            'pending' => 'Pending',
            'overdue' => 'Overdue',
            'paid' => 'Paid',
            'unpaid' => 'Unpaid',
            'partially' => 'Partially',
        ];
        $proposalLabels = [
            'draft' => 'Draft',
            'pending' => 'Pending',
            'sent' => 'Sent',
            'accepted' => 'Accepted',
            'declined' => 'Declined',
            'cancelled' => 'Expired',
        ];

        $statusColors = [
            'draft' => 'bg-secondary',
            'pending' => 'bg-warning',
            'overdue' => 'bg-danger',
            'paid' => 'bg-success',
            'unpaid' => 'bg-dark',
            'partially' => 'bg-info',
            'sent' => 'bg-info',
            'accepted' => 'bg-success',
            'declined' => 'bg-danger',
            'cancelled' => 'bg-dark',
        ];
    @endphp

    <div class="py-4">
        <div class="container-fluid">

            {{-- ── Summary Boxes ── --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm text-white h-100" style="background-color:#754511;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Clients') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['clients_total'] }}</h3>
                                </div>
                                <i class="las la-users fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Invoices') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['invoice_total'] }}</h3>
                                </div>
                                <i class="las la-file-invoice-dollar fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Proposals') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['proposal_total'] }}</h3>
                                </div>
                                <i class="las la-file-alt fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Payments') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['payments'] }}</h3>
                                </div>
                                <i class="las la-credit-card fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── ROW 1: Invoices | Proposals | Customers ── --}}
            <div class="row g-4 mb-4">

                {{-- Invoices --}}
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-3">{{ __('Invoices') }}</h6>
                            @foreach ($invoiceLabels as $key => $label)
                                @php
                                    $count = $stats['invoice_counts'][$key] ?? 0;
                                    $pct = round(($count / $invoiceTotal) * 100);
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">{{ $label }}</span>
                                        <span class="fw-bold">{{ $pct }} %</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius:3px;">
                                        <div class="progress-bar {{ $statusColors[$key] ?? 'bg-primary' }}"
                                            role="progressbar" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Proposals (Proposals) --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-primary mb-3">{{ __('Proposals') }}</h6>
                            @foreach ($proposalLabels as $key => $label)
                                @php
                                    $count = $stats['proposal_counts'][$key] ?? 0;
                                    $pct = round(($count / $proposalTotal) * 100);
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">{{ $label }}</span>
                                        <span class="fw-bold">{{ $pct }} %</span>
                                    </div>
                                    <div class="progress" style="height: 6px; border-radius:3px;">
                                        <div class="progress-bar {{ $statusColors[$key] ?? 'bg-primary' }}"
                                            role="progressbar" style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Customers --}}
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                            <h6 class="fw-bold mb-4">{{ __('Customers') }}</h6>

                            {{-- Ring chart --}}
                            @php $newPct = round(($stats['new_clients_month'] / $clientTotal) * 100); @endphp
                            <div class="position-relative d-inline-block mb-3" style="width:120px;height:120px;">
                                <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg)">
                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e9ecef"
                                        stroke-width="3" />
                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#6366f1"
                                        stroke-width="3" stroke-dasharray="{{ $newPct }}, 100"
                                        stroke-linecap="round" />
                                </svg>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <strong class="fs-5">{{ $newPct }}%</strong>
                                </div>
                            </div>

                            <p class="text-muted small mb-3">{{ __('New Customer This Month') }}</p>
                            <hr class="w-100">
                            <p class="text-muted small mb-1">{{ __('Active Customer') }}</p>
                            <p class="fw-bold fs-6 text-success mb-0">
                                ↑ {{ $stats['active_pct'] }} %
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── ROW 2: Recent Invoices | Recent Proposals ── --}}
            <div class="row g-4">

                {{-- Recent Invoices --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold text-primary mb-0">{{ __('Recent Invoices') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small px-3">{{ __('Number') }}</th>
                                            <th class="small">{{ __('Client') }}</th>
                                            <th class="small">{{ __('Total') }}</th>
                                            <th class="small">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stats['recent_invoices'] as $inv)
                                            <tr>
                                                <td class="px-3 small fw-bold">
                                                    <a href="{{ route('invoices.show', $inv) }}"
                                                        class="text-decoration-none">{{ $inv->number }}</a>
                                                </td>
                                                <td class="small">{{ $inv->client->name }}</td>
                                                <td class="small">
                                                    {{ $sym }}{{ number_format($inv->total, 2) }}</td>
                                                <td class="small">
                                                    <span
                                                        class="badge {{ $statusColors[$inv->status] ?? 'bg-secondary' }} text-capitalize">{{ $inv->status }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4 small">
                                                    <i class="las la-inbox fs-2 d-block mb-2 opacity-25"></i>
                                                    {{ __('No data') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center py-2">
                            <a href="{{ route('invoices.index') }}"
                                class="btn btn-sm btn-link text-decoration-none small">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>

                {{-- Recent Proposals --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="fw-bold text-primary mb-0">{{ __('Recent Proposals') }}</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="small px-3">{{ __('Number') }}</th>
                                            <th class="small">{{ __('Client') }}</th>
                                            <th class="small">{{ __('Total') }}</th>
                                            <th class="small">{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stats['recent_proposals'] as $prop)
                                            <tr>
                                                <td class="px-3 small fw-bold">
                                                    <a href="{{ route('proposals.show', $prop) }}"
                                                        class="text-decoration-none">{{ $prop->number }}</a>
                                                </td>
                                                <td class="small">{{ $prop->client->name }}</td>
                                                <td class="small">
                                                    {{ $sym }}{{ number_format($prop->total, 2) }}</td>
                                                <td class="small">
                                                    <span
                                                        class="badge {{ $statusColors[$prop->status] ?? 'bg-secondary' }} text-capitalize">{{ $prop->status }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4 small">
                                                    <i class="las la-inbox fs-2 d-block mb-2 opacity-25"></i>
                                                    {{ __('No data') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center py-2">
                            <a href="{{ route('proposals.index') }}"
                                class="btn btn-sm btn-link text-decoration-none small">{{ __('View All') }}</a>
                        </div>
                    </div>
                </div>

            </div><!-- end row 2 -->

        </div>
    </div>
</x-app-layout>
