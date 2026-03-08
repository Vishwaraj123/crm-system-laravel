<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Leads') }}
            </h2>
            <a href="{{ route('leads.create') }}" class="btn btn-primary">
                {{ __('Add New Lead') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Company') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Source') }}</th>
                                    <th class="text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leads as $lead)
                                    <tr>
                                        <td>{{ $lead->first_name }} {{ $lead->last_name }}</td>
                                        <td>{{ $lead->company ?? '-' }}</td>
                                        <td>{{ $lead->email ?? '-' }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'new' => 'bg-info',
                                                    'reached' => 'bg-primary',
                                                    'interested' => 'bg-success',
                                                    'not interested' => 'bg-danger',
                                                ][$lead->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }} text-capitalize">
                                                {{ str_replace('_', ' ', $lead->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $lead->source ?? '-' }}</td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('leads.show', $lead) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this lead?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            {{ __('No leads found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($leads->hasPages())
                    <div class="card-footer bg-white border-top">
                        {{ $leads->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
