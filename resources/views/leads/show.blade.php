<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Lead Details') }}
            </h2>
            <div>
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-primary me-2">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                                <h3 class="h5 mb-0">{{ $lead->first_name }} {{ $lead->last_name }}</h3>
                                @php
                                    $statusClass = [
                                        'new' => 'bg-info',
                                        'reached' => 'bg-primary',
                                        'interested' => 'bg-success',
                                        'not interested' => 'bg-danger',
                                    ][$lead->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }} text-capitalize px-3 py-2">
                                    {{ str_replace('_', ' ', $lead->status) }}
                                </span>
                            </div>
                            
                            <dl class="row">
                                <dt class="col-sm-3">{{ __('Email') }}</dt>
                                <dd class="col-sm-9">{{ $lead->email ?? __('Not provided') }}</dd>

                                <dt class="col-sm-3">{{ __('Phone') }}</dt>
                                <dd class="col-sm-9">{{ $lead->phone ?? __('Not provided') }}</dd>

                                <dt class="col-sm-3">{{ __('Company') }}</dt>
                                <dd class="col-sm-9">{{ $lead->company ?? __('Not provided') }}</dd>

                                <dt class="col-sm-3">{{ __('Job Title') }}</dt>
                                <dd class="col-sm-9">{{ $lead->job_title ?? __('Not provided') }}</dd>

                                <dt class="col-sm-3">{{ __('Country') }}</dt>
                                <dd class="col-sm-9 font-weight-bold">{{ $lead->country ?? __('Not provided') }}</dd>

                                <dt class="col-sm-3">{{ __('Address') }}</dt>
                                <dd class="col-sm-9">{{ $lead->address ?? __('Not provided') }}</dd>

                                <dt class="col-sm-3">{{ __('Source') }}</dt>
                                <dd class="col-sm-9">{{ $lead->source ?? __('N/A') }}</dd>

                                <dt class="col-sm-3">{{ __('Notes') }}</dt>
                                <dd class="col-sm-9">
                                    <div class="bg-light p-3 rounded">
                                        {{ $lead->notes ?? __('No notes available.') }}
                                    </div>
                                </dd>
                                
                                <dt class="col-sm-3 mt-3 text-muted small">{{ __('Created At') }}</dt>
                                <dd class="col-sm-9 mt-3 text-muted small">{{ $lead->created_at->format('M d, Y H:i') }}</dd>

                                <dt class="col-sm-3 text-muted small">{{ __('Last Updated') }}</dt>
                                <dd class="col-sm-9 text-muted small">{{ $lead->updated_at->format('M d, Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
