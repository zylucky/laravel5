/**
 * Created by liyuequn on 2017/5/15.
 */
// import todos from "./components/Todos.vue";
// import example from "./components/Example.vue";
import navigation from "./components/Navigation.vue";
import formtodo from "./components/FormTodo.vue";
// import login from "./components/Login.vue";
// import contractIndex from "./components/Contract/index.vue";
//  Vue.component('todos', require('./components/Todos.vue'));
//  Vue.component('example', require('./components/Example.vue'));
//  Vue.component('navigation', require('./components/Navigation.vue'));
//  Vue.component('formtodo', require('./components/FormTodo.vue'));
//  Vue.component('login', require('./components/Login.vue'));
//  Vue.component('contractIndex', require('./components/Contract/index.vue'));
 let routes = [
    {
        path: '/',
        component: navigation,
        name: '合同管理',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            
            { path: '/table', component: formtodo, name: 'Table' },
            { path: '/form', component: formtodo, name: 'Form' },
            { path: '/user', component: formtodo, name: '列表' },
        ]
    },
    {
        path: '/',
        component: navigation,
        name: '导航er',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/main', component:formtodo , name: '主页', hidden: true },
            { path: '/table', component: formtodo, name: 'Table' },
            { path: '/form', component: formtodo, name: 'Form' },
            { path: '/user', component: formtodo, name: '列表' },
        ]
    },
]

export default routes;


