<div class="accordion-item {{ $level > 0 ? 'nested-item' : '' }}" data-id="{{ $item['related_id'] }}" data-translation_key="{{ $item['translation_key'] }}" data-type="{{ $item['type'] }}" id="menuItem{{ $item['id'] }}">
    <h2 class="accordion-header d-flex align-items-center" id="menuItem{{ $item['id'] }}Header">
        <div class="sort-item px-3 py-2"><i class="fa-solid fa-arrows-up-down-left-right"></i></div>
        <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse" data-bs-target="#menuItem{{ $item['id'] }}Collapse" aria-expanded="false" aria-controls="menuItem{{ $item['id'] }}Collapse">
            <div class="d-flex justify-content-between w-100">
                <span>{{ $item['type'] === 'static'? __('admin.'.$item['translation_key']) : $item['name'] }}</span>
                <span class="text-muted">{{ $item['type'] }}</span>
            </div>
        </button>
    </h2>
    <div id="menuItem{{ $item['id'] }}Collapse" class="accordion-collapse collapse" aria-labelledby="menuItem{{ $item['id'] }}Header">
        <div class="accordion-body">
            <div class="mb-3">
                <label class="form-label">{{ __('admin.url') }}</label>
                <input type="text" class="form-control url-input" value="{{ $item['url'] }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('admin.css_class') }}</label>
                <input type="text" class="form-control css-input" value="{{ $item['css_class'] }}">
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success update-item">{{ __('admin.update') }}</button>
                <button type="button" class="btn btn-secondary cancel-item">{{ __('admin.cancel') }}</button>
                <button type="button" class="btn btn-danger delete-item">{{ __('admin.delete') }}</button>
            </div>
        </div>
    </div>
</div>


@if (!empty($item['children']))
    @foreach($item['children'] as $child)
        @include('admin.partial.menus.menu_item', ['item' => $child, 'level' => $level + 1])
    @endforeach
@endif
