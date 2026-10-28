@props(['name', 'id' => null, 'value' => null, 'placeholder' => null, 'required' => false])
@use('Svenbw\LaravelTabler\Helpers\Form')
@php
    $isInvalid = isset($errors) && $errors->has(Form::errorKey($name));
    $id ??= $name;
    $describedBy = Form::describedBy($id, $isInvalid, false);
@endphp
<div class="input-group input-group-flat" x-data="{ show: true }">
    <input 
        :type="show ? 'password' : 'text'"
        name="{{ $name }}"
        id="{{ $id }}"
        autocomplete="current-password"
        @class(['form-control', 'is-invalid' => $isInvalid])
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($value) value="{{ $value }}" @endif
        @if($required) aria-required="true" @endif
        @if($describedBy) aria-describedby="{{ $describedBy }}" @endif
        @if($isInvalid) aria-invalid="true" @endif
    >
    <span class="input-group-text">
        <a href="#" x-on:click.prevent="show=!show" class="link-secondary" role="button" x-bind:title="show ? @js(__('tabler::form.show_password')) : @js(__('tabler::form.hide_password'))" x-bind:aria-label="show ? @js(__('tabler::form.show_password')) : @js(__('tabler::form.hide_password'))">
            <template x-if="show">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="2"></circle>
                    <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                </svg>
            </template>
            <template x-if="!show">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="3" y1="3" x2="21" y2="21"></line>
                    <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
                    <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
                </svg>
            </template>
        </a>
    </span>
</div>
