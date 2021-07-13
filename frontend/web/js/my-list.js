"use strict";
$(document).ready(function () {
    $('.menu-toggle__item').click(function (evt) {
        evt.stopPropagation();
        $(this).addClass('menu_toggle__item--current');
        $(this).siblings().removeClass('menu_toggle__item--current');
        $('.' + $(this).data('status') + '-wrapper').addClass('active');
        $('.' + $(this).data('status') + '-wrapper').siblings().removeClass('active');
    });


});
