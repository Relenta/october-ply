require('./common.js');
require('../vendor/jquery_autocomplete/src/jquery.autocomplete.js');
/*
 * Autocomplete category
 */
jQuery(document).ready(function($) {
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
});

/*
 * MDL file input
 */

jQuery(document).ready(function($) {
    "use strict";
    var file_input = $('.course-create-form .course-create-form__file-input');
    var file_input_title = $('.course-create-form .course-create-form__file-input-title');

    $(file_input).change(function () {
        $(file_input_title).val(this.files[0].name);
    });
});

Vue.component('PlyCard', require('./components/PlyCard.vue'));
Vue.component('PlyUnitSimple', require('./components/PlyUnitSimple.vue'));
Vue.component('PlyUnitTimeout', require('./components/PlyUnitTimeout.vue'));

const app = new Vue({
    el: '#app'
});

