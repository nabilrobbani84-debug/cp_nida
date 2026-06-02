@php
    $statusEnum = $status instanceof \App\Enums\BranchProductionStatus
        ? $status
        : \App\Enums\BranchProductionStatus::tryFrom($status);
@endphp

@if ($statusEnum)
    <span class="badge {{ $statusEnum->badgeClass() }}">{{ $statusEnum->label() }}</span>
@else
    <span class="badge bg-secondary">—</span>
@endif
