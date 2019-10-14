import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import { updateAuthorizationHeader, getAccess } from './shared/helpers';

window.Vue = Vue;
Vue.use(VueRouter);
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
updateAuthorizationHeader();

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}
