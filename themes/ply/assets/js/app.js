require('./common.js');

/*
 * Auto hide navbar
 */
jQuery(document).ready(function($){
    $(".button-collapse").sideNav({
        edge: 'right',
        draggable: true
    });
});

Vue.component('PlyCard', require('./components/PlyCard.vue'));
Vue.component('PlyUnitSimple', require('./components/PlyUnitSimple.vue'));
Vue.component('PlyUnitTimeout', require('./components/PlyUnitTimeout.vue'));

const app = new Vue({
    el: '#app'
});

