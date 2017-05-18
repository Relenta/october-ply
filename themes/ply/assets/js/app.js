require('./common.js');
require('../vendor/jquery_autocomplete/src/jquery.autocomplete.js');
jQuery(document).ready(function($) {
    $(".mdl-layout-title").on("click", function() {
        location.href = "/";
    });
/*
 * Autocomplete category
 */
    "use strict";
    var category_select = $('.course-create-form #course-category');
    var category_input = $('.course-create-form #course-category-id');

    if (category_select && category_input) {
        $.getJSON( "/api/v1/categories", function(data) {
            var categories = [];

            $.map(data, function(dataItem) {
                categories.push({
                    value: dataItem.title,
                    data: dataItem.id
                });
            });

            $(category_select).autocomplete({
                lookup: categories,
                onSelect: function (suggestion) {
                    $(category_input).val(suggestion.data);
                }
            });
        });
    }
/*
 * MDL file input
 */

    "use strict";
    var file_input = $('.course-create-form .course-create-form__file-input');
    var file_input_title = $('.course-create-form .course-create-form__file-input-title');

    $(file_input).change(function () {
        $(file_input_title).val(this.files[0].name);
    });

/*
    $("#app").on("scroll", function() {
        if ($(".mdl-layout__header").offset().top < 1) {
            $(".mdl-layout__header").addClass("mdl-layout--fixed-header").removeClass("mdl-layout__header--scroll");
            $(".mdl-layout__container").removeClass("has-scrolling-header");
        }
        else {
            $(".mdl-layout__container").addClass("has-scrolling-header");
            $(".mdl-layout__header").removeClass("mdl-layout--fixed-header").addClass("mdl-layout__header--scroll");
        }
    })
*/

/* 
 * Learning dialog linking
 */
    var dialog = document.querySelector('.ply-learning-dialog');
    var showDialogButtons = document.querySelectorAll('.ply-button-show.ply-button-show_dialog_learning');

    if (dialog) {
        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        showDialogButtons.forEach((btn)=>{
            btn.addEventListener('click', function() {
                var id = btn.getAttribute('data-learn-id');
                var type = btn.getAttribute('data-learn-type');

                document.getElementById('learn-id').value = id;
                document.getElementById('learn-type').value = type;

                dialog.showModal();
            });
        });

        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
        });
    }

});

Vue.component('PlyLearnListen', require('./components/PlyLearnListen.vue'));

const app = new Vue({
    el: '#app'
});

