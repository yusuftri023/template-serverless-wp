(function ($) {
    $(document).ready(function () {
        // Fix viewport meta for responsiveness
        var $viewportMeta = $('meta[name="viewport"]');
        if ($viewportMeta.length) {
            $viewportMeta.attr('content', 'width=device-width, initial-scale=1, maximum-scale=1');
        }

        var checkoutForm = $('form.checkout');

        // Append hidden input before placing order
        checkoutForm.on('checkout_place_order', function () {
            if (!checkoutForm.find('#wa-checkout').length) {
                checkoutForm.append('<input type="hidden" id="wa-checkout" name="bpwoo_prevent_submit" value="1">');
            }
            return true;
        });

        // Listen for WooCommerce checkout errors
        $(document.body).on('checkout_error', function () {
            var errorText = $('.woocommerce-error li').first().text().trim();

            if (errorText === 'go_whatsapp_redirect') {
                $('.woocommerce-error, #customer_details').hide();
                $('#wa-checkout').remove();

                // Ensure security nonce is sent
                checkoutForm.append('<input type="hidden" name="security" value="' + brizpress.security + '">');

                // Block the form visually
                checkoutForm.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });

                var sendData = checkoutForm.serialize();

                // Send checkout data via AJAX
                $.ajax({
                    url: brizpress.ajaxurl + '?action=wa-checkout',
                    type: 'POST',
                    data: sendData,
                    dataType: 'json',
                    success: function (response) {
                        var thePhone = response.to_number;
                        var theText = response.wa_message.replace(/\n/g, '%0A'); // preserve line breaks
                    
                        var isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                        var waBaseUrl = isMobile ? 'https://wa.me/' : 'https://web.whatsapp.com/send';
                        var waUrl = isMobile
                            ? waBaseUrl + thePhone + '?text=' + theText
                            : waBaseUrl + '?phone=' + thePhone + '&text=' + theText;
                    
                        window.setTimeout(function () {
                            window.open(waUrl, '_blank');
                        }, 300);
                    
                        window.setTimeout(function () {
                            window.location.href = response.redirect;
                            checkoutForm.unblock();
                        }, 800);
                    }
                    
                });
            } else {
                $('.woocommerce-error').show();
            }
        });
    });
})(jQuery);
