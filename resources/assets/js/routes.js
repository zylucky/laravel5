/**
 * Created by liyuequn on 2017/5/15.
 */

import navigation from "./components/Navigation.vue";
import Login from "./components/Login.vue";
import NotFound from "./components/404.vue";
 let routes = [
     {
         path: '/login',
         component: Login,
         name: '',
         hidden: true
     },
     {
         path: '/404',
         component: NotFound,
         name: '',
         hidden: true
     },
    {
        path: '/',
        component: navigation,
        name: '合同管理',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/table', component: navigation, name: 'Table' },
            { path: '/form', component: navigation, name: 'Form' },
            { path: '/user', component: navigation, name: '列表' },
        ]
    },
]

export default routes;


