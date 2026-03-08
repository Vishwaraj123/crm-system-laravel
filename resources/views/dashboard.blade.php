<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <!-- Stats Widgets -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Clients') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['clients'] }}</h3>
                                </div>
                                <i class="las la-users fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ... other widgets ... -->
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Leads') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['leads'] }}</h3>
                                </div>
                                <i class="las la-chart-bar fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Total Proposals') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['proposals'] }}</h3>
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
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Payments') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['payments'] ?? 0 }}</h3>
                                </div>
                                <i class="las la-credit-card fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-secondary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-1 opacity-75">{{ __('Payments Mode') }}</h6>
                                    <h3 class="card-title mb-0">{{ $stats['payment_modes'] ?? 0 }}</h3>
                                </div>
                                <i class="las la-wallet fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">{{ __('Recent Leads') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stats['recent_leads'] as $lead)
                                            <tr>
                                                <td>{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                                <td>
                                                    <span class="badge bg-info text-capitalize">{{ $lead->status }}</span>
                                                </td>
                                                <td>{{ $lead->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top text-center">
                            <a href="{{ route('leads.index') }}" class="btn btn-sm btn-link text-decoration-none">{{ __('View All Leads') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">{{ __('Recent Proposals') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Number') }}</th>
                                            <th>{{ __('Client') }}</th>
                                            <th>{{ __('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stats['recent_proposals'] as $proposal)
                                            <tr>
                                                <td class="fw-bold">{{ $proposal->number }}</td>
                                                <td>{{ $proposal->client->name }}</td>
                                                <td>{{ number_format($proposal->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top text-center">
                            <a href="{{ route('proposals.index') }}" class="btn btn-sm btn-link text-decoration-none">{{ __('View All Proposals') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
