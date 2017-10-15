window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('../static/lte/js/app');
window.Vue = require('vue');
require('vue-resource');
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});
