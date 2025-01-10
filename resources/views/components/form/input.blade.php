@php($key = isset($key) ? $key : 'id-'.$name)
@php($label = isset($label) ? $label : 'true')
<div class="mb-3 {{ $col ?? "col-12" }}">
    @if(isset($label) && $label ==='true')
        <label for="{{ $key }}" class="form-label {{ $labelClass ?? '' }}">
            {{ $labelName }}
            @isset($required) <sup class="text-danger">*</sup> @endisset
        </label>
    @endif
    @php($type = $type ?? 'text')
    <input type="{{$type}}"
           @if(isset($name)) name="{{ $name }}" @endif
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
           id="{{ $key }}"
           @isset($required) required @endisset
           @if($type=='number') min="0" @endif
           @isset($step) step="{{ $step }}" @endif
           class="form-control @isset($classes) {{ $classes }} @else {{ $name }} @endisset @error($name) is-invalid @enderror"
           @isset($multiple) multiple @endisset
           value="{{ $value ?? $default ?? old($name) }}"
    >
    @error($name) <span class="text-danger fw-bold">{{ $message }}</span> @enderror
</div>

