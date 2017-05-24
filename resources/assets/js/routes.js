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

import PurchaseContractAddDate from "./components/purchaseContract/AddDate.vue";

import PurchaseContractUpload from "./components/purchaseContract/Upload.vue";


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

             { path: '/purchaseContact', component: PurchaseContractIndex, name: '收房合同'},
             { path:'/purchaseContact/Add',component:PurchaseContractAdd,name:'房间信息',hidden:true},
             { path:'/purchaseContact/AddDate',component:PurchaseContractAddDate,name:'租期信息',hidden:true},
             { path: '/purchaseContact/upload',component:PurchaseContractUpload,name:'上传扫描件',hidden:true}

         ]
     },
]

export default routes;


