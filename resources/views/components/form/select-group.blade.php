@php
    $key = isset($key) ? $key : 'id-' . $name;
    $label = isset($label) ? $label : 'true';
    $col = $col ?? 'col-12';
@endphp

<div class="mb-3 {{ $col }}">
    @if(isset($label) && $label === 'true')
        <label for="{{ $key }}" class="form-label {{ $labelClass ?? '' }}">
            {{ $labelName ?? ucfirst(str_replace('_', ' ', $name)) }}
            @isset($required) <sup class="text-danger">*</sup> @endisset
        </label>
    @endif

    <div class="input-group mb-2 mr-sm-2 custom-input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <i class="{{ $icon ?? 'fa fa-globe' }}"></i> <!-- Default icon for selects -->
            </div>
        </div>
        <select class="form-control @error($name) is-invalid @enderror @isset($classes) {{ $classes }} @endisset"
                id="{{ $key }}"
                @if(isset($name)) name="{{ $name }}" @endif
                @isset($required) required @endisset
                @isset($multiple) multiple @endisset
        >
            {{ $slot }}
        </select>
    </div>

    @error($name)
    <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
