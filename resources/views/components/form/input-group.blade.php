<!-- resources/views/components/input-group.blade.php -->
@php
    $key = isset($key) ? $key : 'id-' . $name;
    $label = isset($label) ? $label : 'true';
    $type = $type ?? 'text';
    $icon = $icon ?? 'fa fa-user'; // Default icon, can be overridden
    $col = $col ?? 'col-12';
@endphp

<div class="mb-3 {{ $col }}">
    @if(isset($label) && $label === 'true')
        <label for="{{ $key }}" class="form-label {{ $labelClass ?? '' }}">
            {{ $labelName ?? ucfirst(str_replace('_', ' ', $name)) }}
            @isset($required) <sup class="text-danger">*</sup> @endisset
        </label>
    @endif

    <div class="input-group mr-sm-2 custom-input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="{{ $icon }}"></i>
            </div>
        </div>
        <input type="{{ $type }}"
               @if(isset($name)) name="{{ $name }}" @endif
               @isset($readonly) readonly @endisset
               @isset($disabled) disabled @endisset
               id="{{ $key }}"
               @isset($required) required @endisset
               @if($type == 'number') min="0" @endif
               @isset($step) step="{{ $step }}" @endif
               class="form-control @isset($classes) {{ $classes }} @else {{ $name }} @endisset @error($name) is-invalid @enderror"
               @isset($multiple) multiple @endisset
               value="{{ $value ?? $default ?? old($name) }}"
               @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
               @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset
               @isset($autofocus) autofocus @endisset
        >
    </div>

    @error($name)
    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
