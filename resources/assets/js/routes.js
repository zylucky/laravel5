/**
 * Created by liyuequn on 2017/5/15.
 */

import navigation from "./components/Navigation.vue";
import Login from "./components/Login.vue";
import NotFound from "./components/404.vue";

import User from "./components/rbac/User.vue";
import Permission from "./components/rbac/Permission.vue";
import Role from "./components/rbac/Role.vue";
//收房合同
import PurchaseContractIndex from "./components/purchaseContract/Index.vue";
import PurchaseContractAdd from "./components/purchaseContract/Add.vue";
import PurchaseContractUpload from "./components/purchaseContract/Upload.vue";
import PurchaseContractOptimize from "./components/purchaseContract/Optimize.vue";
import PurchaseContractCheckOptimize from "./components/purchaseContract/Optimize.vue";
import PurchaseContractDump from "./components/purchaseContract/Dump.vue";


//出房合同
import SaleContractIndex from "./components/saleContract/Index.vue";
import SaleContractAdd from "./components/saleContract/Add.vue";
import SaleContractUpload from "./components/saleContract/Upload.vue";
import SaleContractWeiyue from "./components/saleContract/Weiyue.vue";
import SaleContractJieyue from "./components/saleContract/Jieyue.vue";
import SaleContractCheckJieyue from "./components/saleContract/Jieyue.vue";
import SaleContractDump from "./components/saleContract/Dump.vue";


//渠道公司
import BrokerCompany from "./components/brokerCompany/Index.vue";
import BrokerCompanyUser from "./components/brokerCompany/UserList.vue";
//佣金管理
import ChuFangCommission from "./components/Commission/Index.vue";
import ShouFangCommission from "./components/Commission/ShouFangList.vue";
import selectCommissionPayType from "./components/Commission/contractPayType.vue";
//应收
import AccountsReceivable from "./components/Commission/accountsReceivableList.vue";
import ReceivableRecord from "./components/Commission/receivableRecordList.vue";
import Receivable from "./components/Commission/receivableList.vue";
//应付
import PaymentRecord from "./components/Report/paymentRecordList.vue";
import PayableRecord from "./components/Report/payableRecordList.vue";
import Payable from "./components/Report/payableList.vue";

var fk_permission ;
fun('permission')==true? fk_permission = false:fk_permission = true;

var fk_permission_user ;
fun('permission')==true? fk_permission_user = false:fk_permission_user = true;

var fk_permission_role ;
fun('permission')==true? fk_permission_role = false:fk_permission_role = true;

var fk_permission_per ;
fun('permission')==true? fk_permission_per = false:fk_permission_per = true;

var fk_contract ;
fun('contract')==true? fk_contract = false:fk_contract = true;

var fk_contract_purchase ;
fun('purchaseContract')==true? fk_contract_purchase = false:fk_contract_purchase = true;

var fk_brokerCompany ;
fun('brokerCompany')==true? fk_brokerCompany = false:fk_brokerCompany = true;

var fk_brokerCompanyList ;
fun('brokerCompanyList')==true? fk_brokerCompanyList = false:fk_brokerCompanyList = true;

var fk_brokerCompanyUserList ;
fun('brokerCompanyUserList')==true? fk_brokerCompanyUserList = false:fk_brokerCompanyUserList = true;



function fun(funKey) {
    let res = JSON.parse(sessionStorage.getItem('permission'));
    if(res!=null){
        var i = res.length;
        while (i--) {
            if (res[i] === funKey) {
                return true;
            }
        }
    }

}






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
         hidden:fk_permission,
        children: [
            { path: '/user', component: User, name: '用户' ,hidden:fk_permission_user},
            { path: '/role', component: Role, name: '角色' ,hidden:fk_permission_role},
            { path: '/fun', component: Permission, name: '权限',hidden:fk_permission_per },
        ]
     },
     {
         path: '/',
         component: navigation,
         name: '合同管理',
         iconCls: 'el-icon-document',//图标样式class
         hidden:fk_contract,
         children: [

             { path:'/purchaseContract', component: PurchaseContractIndex, name: '收房合同',hidden:fk_contract_purchase},
             { path:'/purchaseContract/add',component:PurchaseContractAdd,name:'收房录入',hidden:true},
             { path:'/purchaseContract/edit',component:PurchaseContractAdd,name:'收房编辑',hidden:true},
             { path:'/purchaseContract/review',component:PurchaseContractAdd,name:'收房审核',hidden:true},
             { path:'/purchaseContract/optimize',component:PurchaseContractOptimize,name:'收房优化',hidden:true},
             { path:'/purchaseContract/checkOptimize',component:PurchaseContractCheckOptimize,name:'收房协议查看',hidden:true},
             { path:'/purchaseContract/upload',component:PurchaseContractUpload,name:'上传扫描件',hidden:true},

             { path:'/saleContact', component: SaleContractIndex, name: '出房合同'},
             { path:'/saleContact/add',component:SaleContractAdd,name:'出房录入',hidden:true},
             { path:'/saleContract/edit',component:SaleContractAdd,name:'出房编辑',hidden:true},
             { path:'/saleContract/review',component:SaleContractAdd,name:'出房审核',hidden:true},
             { path:'/saleContract/weiyue',component:SaleContractWeiyue,name:'出房违约',hidden:true},
             { path:'/saleContract/jieyue',component:SaleContractJieyue,name:'解约协议',hidden:true},
             { path:'/saleContract/checkJieyue',component:SaleContractCheckJieyue,name:'出房协议查看',hidden:true},
             { path:'/saleContact/upload',component:SaleContractUpload,name:'上传扫描件',hidden:true}


         ]
     },
     {
         path: '/',
         component: navigation,
         name: '基础数据管理',
         iconCls: 'el-icon-document',//图标样式class
         hidden:fk_brokerCompany,
         children: [
             { path:'/brokerCompany', component: BrokerCompany, name: '渠道公司维护',hidden:fk_brokerCompanyList},
             { path:'/brokerCompanyUserList',component:BrokerCompanyUser,name:'渠道公司人员维护',hidden:fk_brokerCompanyUserList},
         ]
     },
     {

         path: '/',
         component: navigation,
         name: '佣金管理',
         iconCls: 'el-icon-document',//图标样式class
         hidden:false,
         children: [
             { path:'/shouFangCommission', component: ShouFangCommission, name: '收房佣金管理',hidden:false},
             { path:'/chuFangCommission',component:ChuFangCommission,name:'出房佣金管理',hidden:false},
             { path:'/contractPayType',component:selectCommissionPayType,name:'佣金支付方式',hidden:true},
         ]
     },
     {
         path: '/',
         component: navigation,
         name: '统计',
         iconCls: 'el-icon-document',//图标样式class
         hidden:false,
         children: [
             { path:'/receivable',component:Receivable,name:'应收款信息',hidden:false},
             { path:'/accountsReceivable',component:AccountsReceivable,name:'应收款记录',hidden:true},
             { path:'/receivableRecord',component:ReceivableRecord,name:'已收款记录',hidden:true},
             { path:'/payable',component:Payable,name:'应付款信息',hidden:false},
             { path:'/payableRecord',component:PayableRecord,name:'应付款记录',hidden:true},
             { path:'/paymentRecord',component:PaymentRecord,name:'已付款记录',hidden:true},
         ]

     },
     {
         path:'/purchaseContract/dump',
         component: PurchaseContractDump,
         name: '合同打印',
         hidden: true
     },
    {
        path:'/saleContract/dump',
            component: SaleContractDump,
        name: '合同打印',
        hidden: true
    },
]

export default routes;


