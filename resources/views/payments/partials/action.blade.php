<div class="dropdown">
    <button class="btn btn-sm btn-light border shadow-sm rounded-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="las la-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
        <li><a class="dropdown-item px-3" href="{{ route('payments.show', $id) }}"><i class="las la-eye me-2 text-info"></i> {{ __('View') }}</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ route('payments.destroy', $id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item px-3 text-danger"><i class="las la-trash me-2"></i> {{ __('Delete') }}</button>
            </form>
        </li>
    </ul>
</div>
