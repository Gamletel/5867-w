// Изменение количества товаров в корзине
var tct = null;

function cChangeValue(id, m) {
    var i = jQuery('#input-' + id);
    var cv = i.val();
    if (m == 1) {
        cv--;
        i.val(cv);
    }
    if (m == 0) {
        cv++;
        i.val(cv);
    }
    if (tct) {
        var q = tct;
        clearTimeout(q);
    }
    tct = setTimeout(function () {
        i.trigger('change');
        clearTimeout(tct);
    }, 300);
}

jQuery(document).ready(function ($) {
    console.log('test');

    $('input[type=tel]').inputmask({"mask": "+7 999 999-99-99"}); //specifying options

    window.formPhoneValidator = function (input) {
        let tempInput = input.toString().replaceAll('_', '');
        tempInput = tempInput.replaceAll(' ', '');
        tempInput = tempInput.replaceAll('-', '');

        return tempInput.length === 12;
    }

    // const addressSection = $('.additional-section__wrapper');
    // const shippingMethods = $('.woocommerce-shipping-methods input');
    // shippingMethods.each(function () {
    //     $(this).click(function () {
    //         addressSection.show();
    //     })
    // })
    // const localPickup = $('#shipping_method_0_local_pickup1');
    // localPickup.click(function () {
    //     addressSection.hide();
    // })
    // const shippingMethods = $('.woocommerce-shipping-methods .method__text');
    // shippingMethods.each(function (){
    //     $(this).click(function (){
    //         shippingMethods.each(function (){
    //             $(this).removeClass('selected');
    //         })
    //         $(this).addClass('selected');
    //     })
    // })
    //
    // const paymentMethods = $('.wc_payment_methods .wc_payment_method');
    // paymentMethods.each(function (){
    //     $(this).click(function (){
    //         paymentMethods.each(function (){
    //             $(this).removeClass('selected');
    //         })
    //         $(this).addClass('selected');
    //     })
    // })

    // $(document).scroll(function() {
    //     if ($(this).scrollTop() >= 50) {
    //     $('#header').addClass('painted');
    //     // console.log('scroll')
    //     }else{
    //     $('#header').removeClass('painted');
    //     }
    // });
    //

    // $("li.nav-menu-element a").click(function() { // ID откуда кливаем
    // 	let hash = $(this).attr('href');
    // 	if(hash.length > 1) {
    // 		$(this).parent().addClass('active');
    // 		$(this).parent().siblings().removeClass('active');
    // 		$('html, body').animate({
    //             scrollTop: $(hash).offset().top - 120 // класс объекта к которому приезжаем
    //         }, 1000); // Скорость прокрутки
    // 	}
    // });


    /*============ FUNCTIONS ===========*/

    // function getCallbackForm(modal, props) {
    //     let id = props['data-modal'].value;
    //     if($(modal).find('.form__holder').html() == '') {
    //         $.ajax({
    //             url: `/wp-admin/admin-ajax.php?action=get_modal_form&modal=${id}`,
    //             method: 'GET',
    //             success: function (data){
    //                 $(modal).find('.form__holder').html(data);
    //                 let form = $(modal).find('form').get(0);

    //                 ThemeModal.reinitForms(form);
    //                 ThemeModal.getInstance().openModal(id);
    //             },
    //             error: function (data) {
    //                 ThemeModal.getInstance().openModal('error');
    //             }
    //         });
    //     }else{
    //         ThemeModal.getInstance().openModal(id);
    //     }
    // }

    let mobileMenu = new MobileMenu(); // Вызов объекта класса мобильного меню
    mobileMenu.init(); // Инициализация мобильного меню
    let themeModal = new ThemeModal({}); // Вызов объекта класса модалок

    // themeModal.modalsView['callback'] = {
    // 	callback: getCallbackForm
    // };
    themeModal.init(); // Инициализация модалок

});
