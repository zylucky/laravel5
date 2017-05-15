
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('todos', require('./components/Todos.vue'));
// Vue.component('example', require('./components/Example.vue'));
// Vue.component('navigation', require('./components/Navigation.vue'));
// Vue.component('formtodo', require('./components/FormTodo.vue'));
// Vue.component('login', require('./components/Login.vue'));
// Vue.component('contractIndex', require('./components/Contract/index.vue'));

import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import VueRouter from 'vue-router';
import routes from './routes';


Vue.use(ElementUI);
Vue.use(VueRouter);

const router = new VueRouter({
    routes
})
// const app = new Vue({
//     router,
//     el: '#app'
// });
const app = new Vue({
    router
}).$mount('#app')
