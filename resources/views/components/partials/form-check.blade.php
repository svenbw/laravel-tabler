@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $model = $attributes->whereStartsWith('wire:model')->first();
    $errorKey = $name !== null ? Form::errorKey($name) : $model;
    $isInvalid = $errorKey !== null && isset($errors) && $errors->has($errorKey);

    $perValue = $type === 'radio' || str_ends_with((string) $name, '[]');
    $id ??= ($name ?? $model) !== null ? Form::id($name ?? $model, $perValue ? $value : null) : null;

    if ($name !== null && session()->hasOldInput()) {
        $old = session()->getOldInput($errorKey);
        $checked = is_array($old)
            ? in_array((string) $value, array_map('strval', $old), true)
            : $old !== null && (string) $old === (string) $value;
    } else {
        $checked = filter_var($checked, FILTER_VALIDATE_BOOL);
    }

    $margin = Form::margin($attributes->get('class'), $defaultMargin);
    $describedBy = $id !== null ? Form::describedBy($id, $isInvalid && ! $inline, false) : null;
@endphp
<div {{ $attributes->only('class')->class([$margin, Form::colClass($col)]) }}>
    <label @class(['form-check', 'form-switch' => $switch, 'form-check-inline' => $inline]) @if($id) for="{{ $id }}" @endif>
        <input
            type="{{ $type }}"
            @class(['form-check-input', 'is-invalid' => $isInvalid])
            @if($id) id="{{ $id }}" @endif
            @if($name !== null) name="{{ $name }}" @endif
            value="{{ $value }}"
            {{ $attributes->except('class') }}
            @checked($checked)
            @disabled($disabled)
            @if($readonly) readonly @endif
            @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
            @if($isInvalid) aria-invalid="true" @endif
        />
        <span class="form-check-label">{{ $label }}</span>
        @if($hint)
            <span class="form-check-description">{{ $hint }}</span>
        @endif
    </label>
    @if($isInvalid && ! $inline)
        <div class="invalid-feedback d-block" @if($id) id="{{ Form::errorId($id) }}" @endif>{{ join(', ', $errors->get($errorKey)) }}</div>
    @endif
</div>
