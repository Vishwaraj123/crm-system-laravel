<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ __('Payments Mode') }}</h2>
            <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModeModal">
                <i class="las la-plus me-1"></i> {{ __('Add New') }}
            </button>
        </div>
    </x-slot>

    <div class="py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mb-4 shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overlay-hidden">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paymentModes as $mode)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $mode->name }}</div>
                                    </td>
                                    <td>{{ $mode->description ?? '-' }}</td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#editPaymentModeModal{{ $mode->id }}">
                                                <i class="las la-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('payment-modes.destroy', $mode) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border text-danger">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editPaymentModeModal{{ $mode->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold">{{ __('Edit Payment Mode') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('payment-modes.update', $mode) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Name') }}</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $mode->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('Description') }}</label>
                                                        <textarea name="description" class="form-control" rows="2">{{ $mode->description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-modal="dismiss">{{ __('Cancel') }}</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4">{{ __('Update') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        {{ __('No payment modes found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addPaymentModeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">{{ __('Add Payment Mode') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payment-modes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Bank Transfer, Cash, PayPal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Description') }}</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Optional description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
