@props(['minWidth' => '120px', 'title' => __('tabler::common.progress'), 'height' => '10px', 'progress', 'align' => 'end', 'color' => null ])
@php
if ($color === null) {
    $color = ((int) $progress) === 100 ? 'bg-success' : 'bg-primary';
}
@endphp
<div class="text-{{ $align }} ms-3" style="min-width:{{ $minWidth }};">
    <div class="small">{{ $title }}</div>
    <div class="d-flex align-items-center gap-2">
        <div class="progress flex-grow-1" style="height:{{ $height }};">
            <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%"></div>
        </div>
        <span class="badge">
            {{ $progress }}%
        </span>
    </div>
</div>
