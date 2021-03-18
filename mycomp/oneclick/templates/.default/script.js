$(function() {
    $(document).on('click', '.call_form', function () {
        var form = $(this);
        if (form.hasClass('disabled')) {
            return false;
        }
        form.addClass('disabled');
        BX.ajax.runComponentAction('mycomp:oneclick', 'loadModal', {
            mode: 'class',
            data: {
                templateFolder: oneclickTemplateFolder
            }
        }).then(function (data) {
            $('body').append(data.data);
            $('.modal_background').css({'display': 'flex'});
            $('.modal_form').fadeIn();
            form.removeClass('disabled');
        });
    });

    $(document).on('click', '.modal_form', function(e) {
        e.stopPropagation();
    });

    $(document).on('click', '.close_form, .modal_background', function() {
        $(".modal_background").hide().remove();
    });

    if(oneclickParams.PLACE_COMP === 'DETAIL') {
        var offers = oneclickParams.PRODUCT_ID;
        BX.addCustomEvent('onCatalogStoreProductChange', function (changeID) {
            offers = changeID;
        });
    }

    $(document).on('click', '.submit_button .button', function() {
        var data = {};
        var actionType;
        var phoneNumber = $('#phone_number').val();

        if(phoneNumber.length !== 12 ) {
            $('.oneclick .error_form').html('*введите 12 цифр');
            return;
        }
        $(".modal_background").hide().remove();

        if(oneclickParams.PLACE_COMP === 'DETAIL') {
            actionType = 'addDetail';
            var productQuantity = $('input.' + oneclickParams.QUANTITY_NAME).val();
            data = {
                productID: offers,
                productQuantity: productQuantity,
                phoneNumber: phoneNumber
            };
        }
        else if(oneclickParams.PLACE_COMP === 'BASKET') {
            actionType = 'addBasket';
            data = {
                phoneNumber: phoneNumber
            };
        }

        BX.ajax.runComponentAction('mycomp:oneclick', actionType, {
            mode: 'class',
            data: data
        }).then(function(response) {
            $('body').append('<div class="oneclick result_form ' + response.data.class + '">' + response.data.text + '</div>');
            $('.result_form').fadeOut({duration: 3000});
            if(oneclickParams.PLACE_COMP === 'BASKET') {
                location.reload();
            }
        });
    });
});