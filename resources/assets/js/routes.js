/**
 * Created by liyuequn on 2017/5/15.
 */

import navigation from "./components/Navigation.vue";
import Login from "./components/Login.vue";
import NotFound from "./components/404.vue";

import purchaseContractIndex from "./components/purchaseContract/index.vue";
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
        name: '权限管理',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/purchaseContract-index', component: purchaseContractIndex, name: '用户' },
            { path: '/form', component: navigation, name: 'Form' },
            { path: '/user', component: navigation, name: '列表' },
        ]
    },
]

export default routes;


