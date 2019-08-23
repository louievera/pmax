/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)


Vue.component('apexchart', VueApexCharts)

Vue.use(Vuetify)

let routes = [
    {path: '/dashboard', component: require('./components/DashboardComponent.vue').default }
];

const router = new VueRouter({
    routes
})

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router
});
