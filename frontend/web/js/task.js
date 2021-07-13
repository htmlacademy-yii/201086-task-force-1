"use strict";
$('.search-task__form input:checkbox').click(function () {
    if ($(this).is(':checked')) {
        $('input:checkbox').not(this).prop('checked', false);
    }

});
