require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import {routes} from './routes.js';
import App from './App.vue';
import './axios';
import store from './vuex';
Vue.use(VueRouter);

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