<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Clients') }}
            </h2>
            <div>
                <button type="button" id="bulk-delete-btn" class="btn btn-outline-danger me-2 d-none">
                    {{ __('Bulk Delete') }}
                </button>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    {{ __('Add New Client') }}
                </a>
            </div>
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
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            $(document).on('change', '#check-all', function() {
                $('.client-checkbox').prop('checked', $(this).prop('checked'));
                toggleBulkDeleteBtn();
            });

            $(document).on('change', '.client-checkbox', function() {
                if ($('.client-checkbox:checked').length == $('.client-checkbox').length) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
                toggleBulkDeleteBtn();
            });

            function toggleBulkDeleteBtn() {
                if ($('.client-checkbox:checked').length > 0) {
                    $('#bulk-delete-btn').removeClass('d-none');
                } else {
                    $('#bulk-delete-btn').addClass('d-none');
                }
            }

            $('#bulk-delete-btn').on('click', function() {
                let ids = [];
                $('.client-checkbox:checked').each(function() {
                    ids.push($(this).val());
                });

                if (confirm('Are you sure you want to delete selected clients?')) {
                    $.ajax({
                        url: "{{ route('clients.bulkDelete') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: ids
                        },
                        success: function(response) {
                            if (response.success) {
                                window.LaravelDataTables["Client-table"].ajax.reload();
                                $('#bulk-delete-btn').addClass('d-none');
                                $('#check-all').prop('checked', false);
                                alert(response.message);
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
