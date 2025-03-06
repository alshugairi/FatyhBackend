<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading1">
            <button class="accordion-button" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                {{ __('admin.categories') }}
            </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse show"
             aria-labelledby="heading1" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                @foreach($categories as $category)
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="category{{ $category->id }}"
                               data-type="category"
                               data-id="{{ $category->id }}"
                               data-url="/products?c={{ $category->id }}"
                               data-title="{{ $category->name }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="category{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
                <div class="mt-3">
                    <button type="button" class="btn btn-primary"
                            id="add-category">{{ __('admin.add_to_menu') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="heading2">
            <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse2"
                    aria-expanded="false" aria-controls="collapse2">
                {{ __('admin.pages') }}
            </button>
        </h2>
        <div id="collapse2" class="accordion-collapse collapse"
             aria-labelledby="heading2" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                @foreach($pages as $page)
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="page{{ $page->id }}" data-type="page"
                               data-id="{{ $page->id }}"
                               data-url="/page/{{ $page->slug }}"
                               data-title="{{ $page->name }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="page{{ $page->id }}">{{ $page->name }}</label>
                    </div>
                @endforeach
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="page_homepage" data-type="static"
                               data-id=""
                               data-translation_key="home"
                               data-url="/"
                               data-title="{{ __('admin.home') }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="page_homepage">{{ __('admin.homepage') }}</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="page_new_arrivals" data-type="static"
                               data-id=""
                               data-translation_key="new_arrivals"
                               data-url="/new-arrivals"
                               data-title="{{ __('admin.new_arrivals') }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="page_new_arrivals">{{ __('admin.new_arrivals') }}</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="page_best_sellers" data-type="static"
                               data-id=""
                               data-translation_key="best_sellers"
                               data-url="/best-sellers"
                               data-title="{{ __('admin.best_sellers') }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="page_best_sellers">{{ __('admin.best_sellers') }}</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="page_featured_products" data-type="static"
                               data-id=""
                               data-translation_key="featured_products"
                               data-url="/featured"
                               data-title="{{ __('admin.featured_products') }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="page_featured_products">{{ __('admin.featured_products') }}</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox"
                               class="form-check-input add-to-menu"
                               id="page_contact" data-type="static"
                               data-id=""
                               data-translation_key="contact"
                               data-url="/contact"
                               data-title="{{ __('admin.contact') }}">
                        <label class="form-check-label fs-15 fw-600"
                               for="page_contact">{{ __('admin.contact') }}</label>
                    </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary"
                            id="add-page">{{ __('admin.add_to_menu') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="heading4">
            <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapse4"
                    aria-expanded="false" aria-controls="collapse4">
                {{ __('admin.custom_links') }}
            </button>
        </h2>
        <div id="collapse4" class="accordion-collapse collapse"
             aria-labelledby="heading4" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <form id="custom-link-form">
                    <div class="mb-3">
                        <label for="custom-title"
                               class="form-label">{{ __('admin.title') }}</label>
                        <input type="text" class="form-control custom-title"
                               placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="custom-url"
                               class="form-label">{{ __('admin.url') }}</label>
                        <input type="text" class="form-control custom-url"
                               placeholder="">
                    </div>
                    <button type="button" class="btn btn-secondary"
                            id="add-custom-link-temp">{{ __('admin.add_another_link') }}</button>
                    <button type="button" class="btn btn-primary"
                            id="add-custom-links-to-menu">{{ __('admin.add_to_menu') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
