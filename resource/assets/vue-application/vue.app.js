window.Vue = require('vue');


import VueResource from 'vue-resource'
import VeeValidate, { Validator } from 'vee-validate';




Vue.use(VeeValidate);
Vue.use(VueResource);





Vue.component('auth-login', require('./components/auth/login.vue')); // Login
Vue.component('auth-register', require('./components/auth/register.vue')); // Register

const app = new Vue({
    el: '#comments-app'
});
