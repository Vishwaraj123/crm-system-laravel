<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-dark mb-0">
                {{ __('Proposals') }}
            </h2>
            <a href="{{ route('proposals.create') }}" class="btn btn-primary">
                {{ __('Add New Proposal') }}
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
            $(document).on('change', '.proposal-status-selector', function() {
                let id = $(this).data('id');
                let status = $(this).val();
                let selector = $(this);
                
                $.ajax({
                    url: "/proposals/" + id + "/status",
                    type: "PATCH",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: function(response) {
                        if(response.success) {
                            selector.css("border-bottom-color", response.color);
                            selector.css("color", response.color);
                            toastr.success(response.message);
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong!");
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
