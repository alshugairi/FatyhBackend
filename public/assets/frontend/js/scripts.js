$(document).ready(function() {

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "3000"
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.print_receipt').click(function (e) {
        let orderId = $(this).data('id');
        $.get(`/account/orders/invoice/${orderId}`, function(content) {
            printContent(content);
        });
    });

    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();
        const button = $(this);
        const productCard = button.closest('.product-card');
        const productId = button.data('id');
        const page = button.data('page');
        const isInWishlist = button.hasClass('active');

        const url = isInWishlist ? `/wishlist/remove/${productId}` : '/wishlist/add';
        const method = isInWishlist ? 'DELETE' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: {
                product_id: productId
            },
            beforeSend: function() {
                button.prop('disabled', true);
                const icon = button.find('i');
                icon.removeClass('fa-heart').addClass('fa-spinner fa-spin');
            },
            success: function(response, status, xhr) {
                if (xhr.status === 200) {
                    if (!isInWishlist) {
                        button.addClass('active');
                        button.find('i').addClass('text-danger');
                    } else {
                        button.removeClass('active');
                        button.find('i').removeClass('text-danger');
                        if (page === 'wishlist') {
                            productCard.parent().remove();

                            if (!$('.product-card').length) {
                                $('.empty-wishlist').show();
                            }
                        }
                    }
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON?.message || 'Error updating wishlist');
            },
            complete: function() {
                button.prop('disabled', false);
                button.find('i')
                    .removeClass('fa-spinner fa-spin')
                    .addClass('fa-heart');
            }
        });
    });

    $(document).on('click', '.add-to-cart', function(e) {
        e.preventDefault();

        const $button = $(this);
        if ($button.hasClass('loading')) return;

        const productData = {
            id: $button.data('id'),
            quantity: 1
        };

        addToCart($button, productData);
    });

    $('.remove-from-cart').on('click', function(e) {
        e.preventDefault();
        const $cartItem = $(this).closest('.cart-item');
        const productId = $cartItem.data('id');

        $.ajax({
            url: `/cart/${productId}`,
            type: 'DELETE',
            success: function(response, status, xhr) {
                if (xhr.status === 200) {
                    toastr.success(response.message);
                    $cartItem.remove();
                    $('.cart-amount').text(response.data.cart_amount);
                    $('.order_total').text(response.data.cart_amount);
                    $('.order_subtotal').text(response.data.cart_amount);

                    if (!$('.cart-item').length) {
                        $('.cart-items').hide();
                        $('.empty-cart').show();
                    }
                }
            },
            error: function(error) {
                toastr.error(xhr.responseJSON?.message || 'Error updating wishlist');
            }
        });
    });

    $('.quantity-control').each(function() {
        const $control = $(this);
        const $input = $control.find('input');

        $control.find('.decrease').on('click', function() {
            let currentValue = parseInt($input.val());
            if (currentValue > 1) {
                $input.val(currentValue - 1);
                updateCart($input, currentValue - 1);
            }
        });

        $control.find('.increase').on('click', function() {
            let currentValue = parseInt($input.val());
            $input.val(currentValue + 1);
            updateCart($input, currentValue + 1);
        });
    });

    $('#filterProductsForm').on('submit', function(e) {
        var selectedBrands = $('.filter-brand:checked')
            .map(function() {
                return $(this).val();
            })
            .get()
            .join(',');

        $('input[name="brand"]').val(selectedBrands);
    });
});

function addToCart($button, productData) {
    $button.addClass('loading');
    $button.find('i').removeClass('fa-basket-shopping').addClass('fa-spinner fa-spin');

    $.ajax({
        url: '/cart/add',
        type: 'POST',
        data: productData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response, status, xhr) {
            if (xhr.status === 200) {
                toastr.success('Product added to cart successfully!');
                $('.cart-amount').text(response.data.cart_amount)
            } else {
                toastr.error('Failed to add product to cart');
            }
        },
        error: function(xhr) {
            const errorMessage = xhr.responseJSON?.message || 'Failed to add product to cart';
            toastr.error(errorMessage);
        },
        complete: function() {
            $button.removeClass('loading');
            $button.find('i').removeClass('fa-spinner fa-spin').addClass('fa-basket-shopping');
        }
    });
}

function updateCart($input, newQuantity) {
    const productId = $input.closest('.cart-item').data('id');

    $.ajax({
        url: `/cart/${productId}`,
        type: 'PATCH',
        data: {
            quantity: newQuantity,
        },
        success: function(response, status, xhr) {
            if (xhr.status === 200) {
                toastr.success(response.message);
                $('.cart-amount').text(response.data.cart_amount);
                $('.order_total').text(response.data.cart_amount);
                $('.order_subtotal').text(response.data.cart_amount);
                $input.closest('.cart-item').find('.price').text(response.data.formatted_price);
            }
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON?.message || 'Error updating wishlist');
        },
    });
}

function printContent(content, title='') {
    const iframe = document.createElement('iframe');
    iframe.style.position = 'absolute';
    iframe.style.width = '0';
    iframe.style.height = '0';
    iframe.style.border = 'none';

    document.body.appendChild(iframe);

    const iframeDoc = iframe.contentWindow.document;

    iframeDoc.open();
    iframeDoc.write(`
            <html lang="${appLocale}" dir="${textDirection}">
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
