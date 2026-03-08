@php
    $statusColors = [
        'draft' => '#6c757d',
        'pending' => '#ffc107',
        'sent' => '#0dcaf0',
        'paid' => '#198754',
        'unpaid' => '#dc3545',
        'partially' => '#0d6efd',
        'overdue' => '#212529',
    ];
    $statusColor = $statusColors[(string)$status] ?? '#0d6efd';
@endphp

<select class="form-select form-select-sm border-0 fw-bold status-selector shadow-sm px-3" 
        data-id="{{ $id }}" 
        style="background-color: transparent; border-bottom: 2px solid {{ $statusColor }} !important; color: {{ $statusColor }}; width: 130px;">
    @foreach ($statusColors as $s => $color)
        <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }} style="color: {{ $color }}; fw-bold">
            {{ ucfirst($s) }}
        </option>
    @endforeach
</select>
