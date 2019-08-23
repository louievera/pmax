/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue');


 import Vuetify from 'vuetify'
 import NProgress from 'nprogress';
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

import VueApexCharts from 'vue-apexcharts'
import VueRouter from 'vue-router'

import '../../node_modules/nprogress/nprogress.css'

import { VueSpinners } from '@saeris/vue-spinners'

Vue.use(VueSpinners)

Vue.use(VueApexCharts)
Vue.use(VueRouter)
Vue.use(require('vue-moment'));


Vue.component('apexchart', VueApexCharts)

Vue.use(Vuetify)

let routes = [
{path: '/', redirect: '/dashboard'},
{path: '/dashboard', component: require('./components/DashboardComponent.vue').default, name:'dashboard' },
{path: '/directUserApproval', component: require('./components/DirectUserApprovalComponent.vue').default, name:'directUserApproval' },

    // transactions
    {path: '/transactions/createTransaction', component: require('./components/Transactions/CreateTransactionComponent.vue').default, name:'transactions/createTransaction' },
    {path: '/transactions/listOfTransaction', component: require('./components/Transactions/ListOfTransactionComponent.vue').default, name:'transactions/listOfTransaction' },
    {path: '/transactions/branchPayment', component: require('./components/Transactions/BranchPaymentComponent.vue').default, name:'transactions/branchPayment' },
    {path: '/transactions/holdBranch', component: require('./components/Transactions/HoldBranchComponent.vue').default, name:'transactions/holdBranch' },

    //reports
    {path: '/reports/generalReports', component: require('./components/reports/GeneralReportComponent.vue').default, name:'reports/generalReports' },
    {path: '/reports/austracReport', component: require('./components/reports/AUSTRACReportComponent.vue').default, name:'reports/austracReport' },
    {path: '/reports/counts', component: require('./components/reports/CountsComponent.vue').default, name:'reports/counts' },
    {path: '/reports/certificate', component: require('./components/reports/CertificateComponent.vue').default, name:'reports/certificate' },
    {path: '/reports/mlhuilier', component: require('./components/reports/MlhuilierComponent.vue').default, name:'reports/mlhuilier' },
    {path: '/reports/bankToBank', component: require('./components/reports/BanktoBankComponent.vue').default, name:'reports/bankToBank' },

    //maintenance
    {path: '/maintenance/users', component: require('./components/maintenance/UsersComponent.vue').default, name:'maintenance/users' },
    {path: '/maintenance/sender', component: require('./components/maintenance/SenderComponent.vue').default, name:'maintenance/sender' },
    {path: '/maintenance/branches', component: require('./components/maintenance/BranchesComponent.vue').default, name:'maintenance/branches' },
    {path: '/maintenance/serviceModels', component: require('./components/maintenance/ServiceModelsComponent.vue').default, name:'maintenance/serviceModels' },
    {path: '/maintenance/serviceCenters', component: require('./components/maintenance/ServiceCentersComponent.vue').default, name:'maintenance/serviceCenters' },
    {path: '/maintenance/exchangeRate', component: require('./components/maintenance/ExchangeRateComponent.vue').default, name:'maintenance/exchangeRate' },

    {path: '/logs', component: require('./components/LogsComponent.vue').default, name:'logs' },


    ];

    const router = new VueRouter({
        routes
    })

    Vue.component('example-component', require('./components/ExampleComponent.vue').default);

    router.beforeResolve((to, from, next) => {
      if (to.name) {
        
          NProgress.start()
      }
      next()
  })


    router.afterEach((to, from) => {
      NProgress.done()
  })
    const app = new Vue({
        el: '#app',
        router
    });
