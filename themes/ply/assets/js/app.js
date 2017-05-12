require('./common.js');

/*
 * Auto fix header
 */
$(document).ready(function($){
	$(".mdl-layout-title").on("click", function() {
		location.href = "/";
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
});

Vue.component('PlyCard', require('./components/PlyCard.vue'));
Vue.component('PlyUnitSimple', require('./components/PlyUnitSimple.vue'));
Vue.component('PlyUnitTimeout', require('./components/PlyUnitTimeout.vue'));

const app = new Vue({
    el: '#app'
});

