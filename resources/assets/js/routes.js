/**
 * Created by liyuequn on 2017/5/15.
 */

import navigation from "./components/Navigation.vue";
import Login from "./components/Login.vue";
import NotFound from "./components/404.vue";
import Example from "./components/Example.vue";

import User from "./components/rbac/user.vue";


import PurchaseContractIndex from "./components/purchaseContract/Index.vue";
import PurchaseContractAdd from "./components/purchaseContract/Add.vue";

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
            { path: '/user', component: User, name: '用户' },
            { path: '/role', component: Example, name: '角色' },
            { path: '/permission', component: navigation, name: '权限' },
        ]
     },
     {
         path: '/',
         component: navigation,
         name: '合同管理',
         iconCls: 'el-icon-document',//图标样式class
         children: [
             { path: '/purchaseContact/', component: PurchaseContractIndex, name: '收房合同' },
              { path: '/purchaseContact/add',component:PurchaseContractAdd,name:'房间信息',hidden:true}
         ]
     },
]

export default routes;


