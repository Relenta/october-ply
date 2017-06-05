require('./common.js');

require('../vendor/jquery_autocomplete/src/jquery.autocomplete.js');
jQuery(document).ready(function($) {
/*
 * Header title "home" link
 */
    $(".mdl-layout-title").on("click", function() {
        location.href = "/";
    });

/*
 * Cards on hover
 */
    // $(".mdl-card", ".ply-category-container")
    $(".mdl-card", ".page-content")
        .mouseenter(function(){
            $(this).removeClass("mdl-shadow--1dp").addClass("mdl-shadow--3dp");
        })
        .mouseleave(function(){
            $(this).removeClass("mdl-shadow--3dp").addClass("mdl-shadow--1dp");
        })

/*
 * Course categories toggle
 */
    $(".ply-category-title", ".ply-category-list").on("click", function() {
        $(this).closest(".ply-category-container").toggleClass("closed").toggleClass("open");
        $(".ply-category-container-toggle", this).text(
            $(this).closest(".ply-category-container").hasClass("open") ? "expand_less" : "expand_more"
        )
    });

/*
 * Course list cards 
 */
    $(".course-countainer", ".ply-course-list")
        .on("click", function() {
            if ($(this).data('href')) {
                location.href = $(this).data('href');
            }
        })
        .mouseenter(function(){
            $(".chevron", this).show();
        })
        .mouseleave(function(){
            $(".chevron", this).hide();
        })

/*
 * Course unit list
 */
    $(".unit-info", ".ply-course-view")
        .on("click", function() {
            if ($(this).data('href')) {
                location.href = $(this).data('href');
            }
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
    var dialog = document.querySelector('.ply-dialog-learning');
    var showDialogButtons = document.querySelectorAll('.button-show.button-show_dialog_learning');

    if (dialog) {
        if (! dialog.showModal) {
            dialogPolyfill.registerDialog(dialog);
        }
        showDialogButtons.forEach((btn)=>{
            btn.addEventListener('click', function() {
                $("input[name=learn-id]", dialog).val($(btn).data('learn-id'));
                $("input[name=learn-type]", dialog).val($(btn).data('learn-type'));

                // var id = btn.getAttribute('data-learn-id');
                // var type = btn.getAttribute('data-learn-type');

                // document.getElementById('learn-id').value = id;
                // document.getElementById('learn-type').value = type;

                dialog.showModal();
            });
        });

        dialog.querySelector('.close').addEventListener('click', function() {
            dialog.close();
        });
    }

    $(".dialog-action-button", dialog).on("click", function() {
        location.href = $("form", dialog).attr("action")+"/?learn-id="+$("input[name=learn-id]",dialog).val()+"&learn-type="+$("input[name=learn-type]",dialog).val()+"&mode="+$(this).data("mode");
    });
});

Vue.component('PlyLearnListen', require('./components/PlyLearnListen.vue'));
Vue.component('PlyLearnFlashcards', require('./components/PlyLearnFlashcards.vue'));
Vue.component('PlyLearnTyped', require('./components/PlyLearnTyped.vue'));

window.eventBus = new Vue();

const app = new Vue({
    el: '#app'
});

