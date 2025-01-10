@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function () {
            let itemId = "{{ $counter ?? 1 }}";
            let menuStructure = [];

            function initializeSortable() {
                $("#menu-items").sortable({
                    handle: ".sort-item",
                    placeholder: "sortable-placeholder",
                    items: "> .accordion-item",
                    connectWith: "#menu-items",
                    tolerance: "pointer",
                    delay: 150,
                    start: function(e, ui) {
                        ui.placeholder.height(ui.item.height());
                        ui.item.data('startPosition', ui.item.index());
                        ui.item.data('startX', e.clientX);
                    },
                    over: function(e, ui) {
                        const currentX = e.clientX;
                        const startX = ui.item.data('startX');
                        const prevItem = ui.placeholder.prev('.accordion-item');
                        const xDiff = currentX - startX;

                        if (xDiff > 50 && prevItem.length) {
                            ui.placeholder.addClass('nested-placeholder');
                        } else {
                            ui.placeholder.removeClass('nested-placeholder');
                        }
                    },
                    stop: function(e, ui) {
                        const currentX = e.clientX;
                        const startX = ui.item.data('startX');
                        const prevItem = ui.item.prev('.accordion-item');
                        const xDiff = currentX - startX;

                        ui.item.removeClass('nested-item nested-placeholder');

                        if (xDiff > 50 && prevItem.length) {
                            ui.item.addClass('nested-item');
                        }

                        const startIndex = ui.item.data('startPosition');
                        const currentIndex = ui.item.index();

                        if (startIndex !== currentIndex) {
                            const children = getChildren(ui.item);
                            if (children.length) {
                                ui.item.after(children);
                            }
                        }

                        updateMenuStructure();
                    }
                }).disableSelection();
            }

            function getChildren($item) {
                const children = [];
                let next = $item.next('.accordion-item');

                while (next.length && next.hasClass('nested-item')) {
                    children.push(next);
                    next = next.next('.accordion-item');
                }

                return children;
            }

            function updateMenuStructure() {
                menuStructure = [];

                function getItemData($item) {
                    const titleSpan = $item.find('.accordion-button span').first();
                    return {
                        id: $item.attr('id'),
                        related_id: $item.data('id'),
                        title: titleSpan.length ? titleSpan.text().trim() : '',
                        type: $item.data('type'),
                        translation_key: $item.data('translation_key') || '',
                        url: $item.find('.url-input').val() || '',
                        css_class: $item.find('.css-input').val() || '',
                        children: []
                    };
                }

                $('#menu-items > .accordion-item').each(function() {
                    const $item = $(this);
                    if (!$item.hasClass('nested-item')) {
                        const itemData = getItemData($item);

                        let $next = $item.next();
                        while ($next.length && $next.hasClass('nested-item')) {
                            itemData.children.push(getItemData($next));
                            $next = $next.next();
                        }

                        menuStructure.push(itemData);
                    }
                });

                console.log('Menu Structure:', menuStructure);

                $('#menu-structure-debug').remove();
                $('<pre id="menu-structure-debug">')
                    .css({
                        position: 'fixed',
                        bottom: '10px',
                        right: '10px',
                        background: '#f8f9fa',
                        padding: '10px',
                        border: '1px solid #ddd',
                        maxHeight: '200px',
                        overflow: 'auto',
                        zIndex: 1000,
                        fontSize: '12px'
                    })
                    .text(JSON.stringify(menuStructure, null, 2))
                    .appendTo('body');
            }
            initializeSortable();

            function addItemToMenu(type, id, title, url,translation_key='') {
                const itemKey = `menuItem${itemId++}`;

                $('#menu-items').append(`
                    <div class="accordion-item" data-id="${id}" data-type="${type}" data-translation_key="${translation_key}" id="${itemKey}">
                        <h2 class="accordion-header d-flex align-items-center" id="${itemKey}Header">
                            <div class="sort-item px-3 py-2"><i class="fa-solid fa-arrows-up-down-left-right"></i></div>
                            <button class="accordion-button collapsed flex-grow-1" type="button" data-bs-toggle="collapse" data-bs-target="#menuItem${itemKey}Collapse" aria-expanded="false" aria-controls="menuItem${itemKey}Collapse">
                                <div class="d-flex justify-content-between w-100">
                                    <span>${title}</span>
                                    <span class="text-muted">${type}</span>
                                </div>
                            </button>
                        </h2>
                        <div id="menuItem${itemKey}Collapse" class="accordion-collapse collapse" aria-labelledby="menuItem${itemKey}Header">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.url') }}</label>
                                    <input type="text" class="form-control url-input" placeholder="Enter URL" value="${url}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">{{ __('admin.css_class') }}</label>
                                    <input type="text" class="form-control css-input" placeholder="Optional CSS class">
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success update-item">{{ __('admin.update') }}</button>
                                    <button type="button" class="btn btn-secondary cancel-item">{{ __('admin.cancel') }}</button>
                                    <button type="button" class="btn btn-danger delete-item">{{ __('admin.delete') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);

                updateMenuStructure();
            }

            $('#add-category').on('click', function () {
                $('.add-to-menu[data-type="category"]:checked').each(function () {
                    addItemToMenu($(this).data('type'), $(this).data('id'), $(this).data('title'), $(this).data('url'));
                    $(this).prop('checked', false);
                });
            });

            $('#add-page').on('click', function () {
                $('.add-to-menu[data-type="page"]:checked,.add-to-menu[data-type="static"]:checked').each(function () {
                    addItemToMenu($(this).data('type'), $(this).data('id'), $(this).data('title'), $(this).data('url'), $(this).data('translation_key'));
                    $(this).prop('checked', false);
                });
            });

            $('#menu-items').on('click', '.delete-item', function () {
                const $item = $(this).closest('.accordion-item');
                const children = getChildren($item);
                children.forEach($child => $child.remove());
                $item.remove();
                updateMenuStructure();
            });

            $('#menu-items').on('click', '.cancel-item', function () {
                $(this).closest('.accordion-collapse').collapse('hide');
            });

            $('#menu-items').on('click', '.update-item', function () {
                const $item = $(this).closest('.accordion-item');
                const title = $item.find('.accordion-button span').first().text();
                const url = $item.find('.url-input').val();
                const css_class = $item.find('.css-input').val();

                console.log('Updated:', {title, url, css_class});
                updateMenuStructure();
            });

            $('#submitForm').on('submit', function() {
                updateMenuStructure();
                $('#menu_items_structure').val(JSON.stringify(menuStructure));
            });

            $('.position-checkbox').on('change', function() {
                if ($(this).prop('checked')) {
                    $('.position-checkbox').not(this).prop('checked', false);
                }
                let selectedPosition = $('.position-checkbox:checked').val() || '';
                if (!selectedPosition) {
                    selectedPosition = null;
                }
                $('#position-value').val(selectedPosition);
            });

        });
    </script>
@endpush
