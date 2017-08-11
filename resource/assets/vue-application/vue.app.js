window.Vue = require('vue');


import VueResource from 'vue-resource'
import VeeValidate, { Validator } from 'vee-validate';
import Vuex from 'vuex'




Vue.use(VeeValidate);
Vue.use(VueResource);
Vue.use(Vuex);


Vue.component('auth-login', require('./components/auth/login.vue')); // Login
Vue.component('auth-register', require('./components/auth/register.vue')); // Register
Vue.component('comments-page', require('./components/comments/comments.vue')); // Comments main component


window.CommentsEvent = new class {
    constructor(){
        this.vue = new Vue();
    }

    fire(event , data = null){
        this.vue.$emit(event , data);
    }

    listen(event , callback){
        this.vue.$on(event , callback);
    }
};

const commentsStore = new Vuex.Store({
    state: {
        authUserState: {
            user_id: 1,
        },
    },
});

const app = new Vue({
    el: '#comments-app',
    store: commentsStore,
});
