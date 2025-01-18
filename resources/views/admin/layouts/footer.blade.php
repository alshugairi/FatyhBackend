<footer class="app-footer"> <!--begin::To the end-->
    <div class="float-end d-none d-sm-inline"></div>
    <strong>
        <a href="#" class="text-decoration-none">Fatyh</a>
    </strong>
    <!--end::Copyright-->
</footer> <!--end::Footer-->
</div>

<script src="{{ asset('public/assets/admin') }}/js/jquery-3.7.0.min.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/overlayscrollbars.browser.es6.min.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/popper.min.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/adminlte.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="{{ asset('public/assets/admin') }}/js/scripts.js"></script>


<script>
        var dataTable;
        $('.validate-form').validate();

        var isArabic = $('html').attr('lang') === 'ar';

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": isArabic ? "toast-top-left" : "toast-top-right",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "rtl": isArabic
        };

        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });

        $('.product-select').each(function() {
            var $this = $(this);
            var dropdownParent = $this.closest('.offcanvas, .modal').length ? $this.closest('.offcanvas, .modal') : $(document.body);

            $this.select2({
                dropdownParent: dropdownParent,
                placeholder: "{{ __('admin.select_product') }}",
                ajax: {
                    url: "{{ route('admin.products.select') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                allowClear: true,
                width: '100%'
            });
        });

        $('.category-select').each(function() {
            var $this = $(this);
            var dropdownParent = $this.closest('.offcanvas, .modal').length ? $this.closest('.offcanvas, .modal') : $(document.body);

            $this.select2({
                dropdownParent: dropdownParent,
                placeholder: "{{ __('admin.select') }}",
                ajax: {
                    url: "{{ route('admin.categories.select') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                allowClear: true,
                width: '100%'
            });
        });

        $('.client-select').each(function() {
            var $this = $(this);
            var dropdownParent = $this.closest('.offcanvas, .modal').length ? $this.closest('.offcanvas, .modal') : $(document.body);

            $this.select2({
                dropdownParent: dropdownParent,
                placeholder: "{{ __('admin.select_client') }}",
                ajax: {
                    url: "{{ route('admin.clients.select') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                allowClear: true,
                width: '100%'
            });
        });

        function printContent(divID, title='') {
            const content = document.getElementById(divID).innerHTML;

            const iframe = document.createElement('iframe');
            iframe.style.position = 'absolute';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = 'none';

            document.body.appendChild(iframe);

            const iframeDoc = iframe.contentWindow.document;

            iframeDoc.open();
            iframeDoc.write(`
                <html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                    <head>
                        <title>${title}</title>
                        <style>
                            body { font-family: Arial, sans-serif; }
                        </style>
                    </head>
                    <body>${content}</body>
                </html>
            `);
            iframeDoc.close();

            iframe.contentWindow.focus();
            iframe.contentWindow.print();

            iframe.addEventListener('afterprint', function() {
                document.body.removeChild(iframe);
            });
        }

        function handleAjaxErrors(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;

                $('.error').remove();

                Object.keys(errors).forEach(key => {
                    const errorMessage = errors[key][0];
                    const input = $(`[name="${key}"]`);

                    input.after(`<label class="error" for="${key}">${errorMessage}</label>`);
                });
            } else {
                toastr.error("{{ __('admin.unknown_error') }}", "{{ __('admin.failed_to_place_order') }}" + ' ' + (xhr.responseJSON?.message || "{{ __('admin.unknown_error') }}"));
            }
        }

        const quillEditors = {};

        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'header': 1 }, { 'header': 2 }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['link', 'image'],
            ['clean']
        ];

        $('.quill-editor').each(function() {
            const textareaId = $(this).attr('id');
            const editorId = 'editor_' + textareaId;

            quillEditors[textareaId] = new Quill('#' + editorId, {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            const initialContent = $(this).val();
            if (initialContent) {
                quillEditors[textareaId].root.innerHTML = initialContent;
            }
        });

        $(document).on('click', '.confirm-delete', function(e) {
            e.preventDefault();
            const deleteUrl = $(this).data('url');

            Swal.fire({
                title: '{!! __("admin.are_you_sure") !!}',
                text: '{!! __("admin.you_wont_be_able_to_revert") !!}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{!! __("admin.yes_delete_it") !!}',
                cancelButtonText: '{!! __("admin.cancel") !!}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire(
                                '{!! __("admin.deleted") !!}!',
                                '{!! __("admin.record_has_been_deleted") !!}',
                                'success'
                            );
                            dataTable.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                '{!! __("admin.error") !!}!',
                                '{!! __("admin.there_was_an_error") !!}',
                                'error'
                            );
                        }
                    });
                }
            });
        });

</script>
@stack('scripts')
</body>
</html>
