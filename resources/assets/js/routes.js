/**
 * Created by liyuequn on 2017/5/15.
 */
 Vue.component('todos', require('./components/Todos.vue'));
 Vue.component('example', require('./components/Example.vue'));
 Vue.component('navigation', require('./components/Navigation.vue'));
 Vue.component('formtodo', require('./components/FormTodo.vue'));
 Vue.component('login', require('./components/Login.vue'));
 Vue.component('contractIndex', require('./components/Contract/index.vue'));
 let routes = [
    {
        path: '/',
        component: '',
        name: '导航一',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/main', component:'' , name: '主页', hidden: true },
            { path: '/table', component: '', name: 'Table' },
            { path: '/form', component: '', name: 'Form' },
            { path: '/user', component: '', name: '列表' },
        ]
    },
    {
        path: '/',
        component: '',
        name: '导航er',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/main', component:'' , name: '主页', hidden: true },
            { path: '/table', component: '', name: 'Table' },
            { path: '/form', component: '', name: 'Form' },
            { path: '/user', component: '', name: '列表' },
        ]
    },
]

export default routes;


