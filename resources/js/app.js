require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import {routes} from './routes.js';
import App from './App.vue';
import './axios';
import store from './vuex';

import VueSweetalert2 from 'vue-sweetalert2';
window.Swal = require('sweetalert2');
Vue.use(VueSweetalert2);

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueToast);

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

import utils from './helpers/utilities';
Vue.prototype.$utils = utils;

const router = new VueRouter({
    routes,
    mode: 'history'
});

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        App
    }
});