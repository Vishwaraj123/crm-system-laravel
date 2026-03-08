<div class="dropdown">
    <button class="btn btn-sm btn-light border shadow-sm rounded-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="las la-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
        <li><a class="dropdown-item px-3" href="{{ route('invoices.show', $id) }}"><i class="las la-eye me-2 text-info"></i> {{ __('View') }}</a></li>
        <li><a class="dropdown-item px-3" href="{{ route('invoices.edit', $id) }}"><i class="las la-pencil-alt me-2 text-secondary"></i> {{ __('Edit') }}</a></li>
        <li><a class="dropdown-item px-3" href="{{ route('invoices.print', $id) }}" target="_blank"><i class="las la-print me-2 text-primary"></i> {{ __('Print') }}</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ route('invoices.destroy', $id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item px-3 text-danger"><i class="las la-trash me-2"></i> {{ __('Delete') }}</button>
            </form>
        </li>
    </ul>
</div>
