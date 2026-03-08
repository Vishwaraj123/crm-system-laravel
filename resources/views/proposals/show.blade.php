<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Proposal Details') }}: {{ $proposal->number }}
            </h2>
            <div>
                <a href="{{ route('proposals.edit', $proposal) }}" class="btn btn-primary me-2">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('proposals.index') }}" class="btn btn-outline-secondary">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-2 mb-3">{{ __('Client Information') }}</h5>
                            <p class="mb-1 fw-bold text-primary">{{ $proposal->client->name }}</p>
                            <p class="mb-1 text-muted">{{ $proposal->client->email }}</p>
                            <p class="mb-1 text-muted">{{ $proposal->client->phone }}</p>
                            <p class="mb-0 text-muted">{{ $proposal->client->address }}</p>
                            
                            <h5 class="card-title border-bottom pb-2 mb-3 mt-4">{{ __('Proposal Status') }}</h5>
                            @php
                                $statusClass = [
                                    'draft' => 'bg-secondary',
                                    'pending' => 'bg-warning text-dark',
                                    'sent' => 'bg-info',
                                    'accepted' => 'bg-success',
                                    'declined' => 'bg-danger',
                                    'cancelled' => 'bg-dark',
                                ][$proposal->status] ?? 'bg-primary';
                            @endphp
                            <span class="badge {{ $statusClass }} text-capitalize px-3 py-2 w-100 fs-6">
                                {{ $proposal->status }}
                            </span>

                            <h5 class="card-title border-bottom pb-2 mb-3 mt-4">{{ __('Dates') }}</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">{{ __('Issue Date') }}:</span>
                                    <span class="fw-medium">{{ $proposal->date->format($appSettings['date_format'] ?? 'd/m/Y') }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <span class="text-muted">{{ __('Expiry Date') }}:</span>
                                    <span class="fw-medium text-danger">{{ $proposal->expired_date->format($appSettings['date_format'] ?? 'd/m/Y') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-2 mb-3">{{ __('Items & Summary') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Item') }}</th>
                                            <th class="text-center">{{ __('Qty') }}</th>
                                            <th class="text-end">{{ __('Price') }}</th>
                                            <th class="text-end">{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proposal->items as $item)
                                            <tr>
                                                <td>
                                                    <span class="fw-bold">{{ $item->itemName }}</span>
                                                    @if ($item->description)
                                                        <br><small class="text-muted">{{ $item->description }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-end">{{ number_format($item->price, 2) }}</td>
                                                <td class="text-end">{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end border-0">{{ __('Sub Total') }}</th>
                                            <td class="text-end border-0">{{ number_format($proposal->sub_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-end border-0">{{ __('Tax') }} ({{ $proposal->tax_rate }}%)</th>
                                            <td class="text-end border-0">{{ number_format($proposal->tax_total, 2) }}</td>
                                        </tr>
                                        <tr class="table-primary fw-bold fs-5">
                                            <th colspan="3" class="text-end border-0">{{ __('Grand Total') }}</th>
                                            <td class="text-end border-0">{{ $proposal->currency }} {{ number_format($proposal->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            @if ($proposal->notes)
                                <div class="mt-4">
                                    <h6 class="fw-bold">{{ __('Notes') }}:</h6>
                                    <div class="p-3 bg-light rounded">
                                        {{ $proposal->notes }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
