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
import PurchaseContractCheckOptimizeList from "./components/purchaseContract/HistoryOptimize.vue";
import PurchaseContractDump20170719 from "./components/purchaseContract/Dump20170719.vue";//版本1
import PurchaseContractDump20170406 from "./components/purchaseContract/Dump20170406.vue";//版本12
import PurchaseContractDump20170719pub from "./components/purchaseContract/Dump20170719_pub.vue";//版本1补充条款
import PurchaseContractDump20170406pub from "./components/purchaseContract/Dump20170406_pub.vue";//版本2补充条款
import PurchaseContractSummary from "./components/purchaseContract/summary.vue";//新版摘要
import PurchaseContractZhanghao from "./components/purchaseContract/Zhanghao.vue";
import PurchaseContractHedan from "./components/purchaseContract/Hedan.vue";
import PurchaseContractJiaogedan from "./components/purchaseContract/jiaogedan.vue";


//出房合同
import SaleContractIndex from "./components/saleContract/Index.vue";
import SaleContractAdd from "./components/saleContract/Add.vue";
import SaleContractUpload from "./components/saleContract/Upload.vue";
import SaleContractJieyue from "./components/saleContract/Jieyue.vue";
import SaleContractBuchong from "./components/saleContract/Buchong.vue";
import SaleContractCheckBuchong from "./components/saleContract/Buchong.vue";
import SaleContractCheckBuchongList from "./components/saleContract/HistoryBuchong.vue";
import SaleContractCheckJieyue from "./components/saleContract/Jieyue.vue";
import SaleContractDump20170719 from "./components/saleContract/Dump20170719.vue";
import SaleContractDump20170719pub from "./components/saleContract/Dump20170719_pub.vue";//版本1补充条款
import SaleContractDump20180409 from "./components/saleContract/Dump20180409.vue";
import SaleContractDump20180409pub from "./components/saleContract/Dump20180409_pub.vue";//版本1补充条款
import SaleContractZhanghao from "./components/saleContract/Zhanghao.vue";
import SaleContractHedan from "./components/saleContract/Hedan.vue";
import SaleContractJiaogedan from "./components/saleContract/jiaogedan.vue";
import SaleContractSummary from "./components/saleContract/summary.vue";//新版摘要

//装饰合同
import DecorationList from "./components/decoration/List.vue";
//合同版本
import ContractVersionList from "./components/contractVersion/index.vue";

import SetPassword from "./components/rbac/ModifyPassword.vue";

//渠道公司门店
import qdCompany from "./components/brokerCompany/Index.vue";


import BrokerCompany from "./components/brokerCompanyPart/Index.vue";
import BrokerCompanyUser from "./components/brokerCompanyPart/UserList.vue";
import BrokerCompanyAdd from "./components/brokerCompanyPart/Add.vue";
import BrokerCompanyUserAdd from "./components/brokerCompanyPart/AddUser.vue";
import BrokerCompanyHistory from "./components/brokerCompanyPart/HistoryList.vue";
import BrokerCompanyUserHistory from "./components/brokerCompanyPart/UserHistoryList.vue";
import BrokerUser from "./components/brokerCompanyPart/BrokerUserList.vue";
import BrokerUserAdd from "./components/brokerCompanyPart/AddBrokerUser.vue";
import BrokerUserHistory from "./components/brokerCompanyPart/BrokerUserHistoryList.vue";


//佣金管理
import ChuFangCommission from "./components/Commission/Index.vue";
import ShouFangCommission from "./components/Commission/ShouFangList.vue";
import selectCommissionPayType from "./components/Commission/contractPayType.vue";
import commissionView  from "./components/Commission/commissionView.vue";
import commissionAuditList  from "./components/Commission/commissionFinancial.vue";
import commissionAudit   from "./components/Commission/commissionAudit.vue";
import approvalDump   from "./components/Commission/approval.vue";
import commissionBalanceList  from "./components/Commission/commissionBalance.vue";
//应收
import AccountsReceivable from "./components/Commission/accountsReceivableList.vue";
import ReceivableRecord from "./components/receivable/receivableRecordList.vue";
import Receivable from "./components/receivable/receivableList.vue";
import FinanceReceivable from "./components/receivable/financeReceivableList.vue";
//应付
import PaymentRecord from "./components/payable/paymentRecordList.vue";
import PayableRecord from "./components/payable/payableRecordList.vue";
import Payable from "./components/payable/payableList.vue";
import FinancePayable from "./components/payable/financePayableList.vue";
import PayOrder from "./components/payable/payorder.vue" ;
//报表
import ShoufangReport from "./components/report/Index.vue" ;
import ChufangReport from "./components/report/chuFangReport.vue" ;
import ChanPinReport from "./components/report/chanPinHeYueReport.vue" ;
import FangYuanXKReport from "./components/report/fangYuanXKReport.vue" ;
import JingGengReport from "./components/report/jinggengReport.vue" ;
import ProjectReport from "./components/report/projectReport.vue" ;
import ProjectSaleReport from "./components/report/projectSaleReport.vue" ;
import CommissionReport from "./components/report/commissionReport.vue" ;
import CoreDataReport from "./components/report/coreDataReport.vue" ;
import DaiKanReport from "./components/report/daikanReport.vue" ;
//消息管理
import MessageList from "./components/message/Index.vue";

//agreement
import AgreementAdd from "./components/agreement/Add.vue";
import AgreementDump from "./components/agreement/Dump.vue";
import AgreementList from "./components/agreement/Index.vue";

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

var fk_permission ,fk_permission_user ,fk_permission_role ,fk_permission_per ,
    fk_contract ,fk_contract_purchase  ,fk_contract_sale ,fk_version,
    fk_brokerCompany ,fk_brokerCompanyList,fk_brokerCompanyUserList,fk_brokerUserList,
    fk_commission,fk_shouFangCommission,fk_chuFangCommission,
    fk_account,fk_payableList,fk_financePayableList,fk_receivableList,fk_financeReceivableList,
    fk_setPassword,fk_reportList,fk_shoufangReport,fk_chufangReport,fk_chanpinReport,fk_fangyuanXKReport,
    fk_jinggengReport,fk_projectReport,fk_projectSaleReport,fk_qdCompanyList,fk_commissionReport,fk_coreDataReport,fk_commissionAuditList,
    fk_commissionBalanceList,fk_approvalDump,fk_daikanReport;
fun('permission')==true? fk_permission = false:fk_permission = true;
fun('permission')==true? fk_permission_user = false:fk_permission_user = true;
fun('permission')==true? fk_permission_role = false:fk_permission_role = true;
fun('permission')==true? fk_permission_per = false:fk_permission_per = true;
fun('contract')==true? fk_contract = false:fk_contract = true;
fun('purchaseContract')==true? fk_contract_purchase = false:fk_contract_purchase = true;
fun('saleContract')==true? fk_contract_sale = false:fk_contract_sale = true;
fun('version')==true? fk_version = false:fk_version = true;
fun('brokerCompany')==true? fk_brokerCompany = false:fk_brokerCompany = true;
fun('brokerCompanyList')==true? fk_brokerCompanyList = false:fk_brokerCompanyList = true;
fun('brokerCompanyUserList')==true? fk_brokerCompanyUserList = false:fk_brokerCompanyUserList = true;
fun('brokerUserList')==true? fk_brokerUserList = false:fk_brokerUserList = true;
fun('commission')==true? fk_commission = false:fk_commission = true;
fun('shouFangCommission')==true? fk_shouFangCommission = false:fk_shouFangCommission = true;
fun('chuFangCommission')==true? fk_chuFangCommission = false:fk_chuFangCommission = true;
fun('account')==true? fk_account = false:fk_account = true;
fun('payableList')==true? fk_payableList = false:fk_payableList = true;
fun('financePayableList')==true? fk_financePayableList = false:fk_financePayableList = true;
fun('receivableList')==true? fk_receivableList = false:fk_receivableList = true;
fun('financeReceivableList')==true? fk_financeReceivableList = false:fk_financeReceivableList = true;
fun('setPassword')==true? fk_setPassword = false:fk_setPassword = true;
fun('reportList')==true? fk_reportList = false:fk_reportList = true;
fun('shoufangReport')==true? fk_shoufangReport = false:fk_shoufangReport = true;
fun('chufangReport')==true? fk_chufangReport = false:fk_chufangReport = true;
fun('chanpinReport')==true? fk_chanpinReport = false:fk_chanpinReport = true;
fun('fangyuanXKReport')==true? fk_fangyuanXKReport = false:fk_fangyuanXKReport = true;
fun('jinggengReport')==true? fk_jinggengReport  = false:fk_jinggengReport = true;
fun('projectReport')==true? fk_projectReport  = false:fk_projectReport = true;
fun('projectSaleReport')==true? fk_projectSaleReport  = false:fk_projectSaleReport = true;
fun('qdCompanyList')==true? fk_qdCompanyList  = false:fk_qdCompanyList = true;
fun('commissionReport')==true? fk_commissionReport  = false:fk_commissionReport = true;
fun('coreDataReport')==true? fk_coreDataReport  = false:fk_coreDataReport = true;
fun('commissionAuditList')==true? fk_commissionAuditList  = false:fk_commissionAuditList = true;
fun('approvalDump')==true? fk_approvalDump  = false:fk_approvalDump = true;
fun('commissionBalanceList')==true? fk_commissionBalanceList  = false:fk_commissionBalanceList = true;
fun('daikanReport')==true? fk_daikanReport  = false:fk_daikanReport = true;


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
         // { path: '/fun', component: Permission, name: '权限',hidden:fk_permission_per },
         { path: '/setPass', component: SetPassword, name: '修改密码',hidden:fk_permission_per },
     ]

     },
    {
        path: '/',
        component: navigation,
        name: '合同管理',
        iconCls: 'el-icon-document',//图标样式class
        hidden:fk_contract,
        children: [

            { path:'/purchaseContract', component: PurchaseContractIndex, name: '收房合同',hidden:fk_contract_purchase,params:{name:'liyuequn'}},
            { path:'/purchaseContract/add',component:PurchaseContractAdd,name:'收房录入',hidden:true},
            { path:'/purchaseContract/edit',component:PurchaseContractAdd,name:'收房编辑',hidden:true},
            { path:'/purchaseContract/review',component:PurchaseContractAdd,name:'收房审核',hidden:true},
            { path:'/purchaseContract/view',component:PurchaseContractAdd,name:'收房查看',hidden:true},
            { path:'/purchaseContract/optimize',component:PurchaseContractOptimize,name:'收房优化',hidden:true},
            { path:'/purchaseContract/checkOptimize',component:PurchaseContractCheckOptimize,name:'收房协议查看',hidden:true},
            { path:'/purchaseContract/checkOptimizeList',component:PurchaseContractCheckOptimizeList,name:'历史协议',hidden:true},
            { path:'/purchaseContract/upload',component:PurchaseContractUpload,name:'上传扫描件',hidden:true},
            { path:'/purchaseContract/zhanghao',component:PurchaseContractZhanghao,name:'收房收款账号',hidden:true},
            { path:'/purchaseContract/hedan',component:PurchaseContractHedan,name:'收房合单管理',hidden:true},
            { path:'/purchaseContract/jiaogedan',component:PurchaseContractJiaogedan,name:'交割单',hidden:true},




            { path:'/saleContract', component: SaleContractIndex, name: '出房合同',hidden:fk_contract_sale},
            { path:'/saleContract/add',component:SaleContractAdd,name:'出房录入',hidden:true},
            { path:'/saleContract/see',component:SaleContractAdd,name:'出房查看',hidden:true},
            { path:'/saleContract/edit',component:SaleContractAdd,name:'出房编辑',hidden:true},
            { path:'/saleContract/review',component:SaleContractAdd,name:'出房审核',hidden:true},
            { path:'/saleContract/buchong',component:SaleContractBuchong,name:'出房补充协议',hidden:true},
            { path:'/saleContract/checkBuchong',component:SaleContractCheckBuchong,name:'出房补充协议查看',hidden:true},
            { path:'/saleContract/checkBuchongList',component:SaleContractCheckBuchongList,name:'历史补充协议',hidden:true},
            { path:'/saleContract/jieyue',component:SaleContractJieyue,name:'解约协议',hidden:true},
            { path:'/saleContract/checkJieyue',component:SaleContractCheckJieyue,name:'出房协议查看',hidden:true},
            { path:'/saleContract/upload',component:SaleContractUpload,name:'上传扫描件',hidden:true},
            { path:'/saleContract/zhanghao',component:SaleContractZhanghao,name:'出房付款账号',hidden:true},
            { path:'/saleContract/hedan',component:SaleContractHedan,name:'出房合单管理',hidden:true},
            { path:'/saleContract/jiaogedan',component:SaleContractJiaogedan,name:'交割单',hidden:true},



            // { path:'/decoration', component: DecorationList, name: '工程合同'},
            { path:'/contractVersion', component: ContractVersionList, name: '合同版本管理',hidden:fk_version},

            // { path:'/agreementAdd', component:AgreementAdd , name: '定金协议新增',hidden:fk_version},
            // { path:'/agreementDump', component:AgreementDump , name: '定金协议打印',hidden:fk_version},
            // { path:'/agreementList', component:AgreementList , name: '定金协议',hidden:fk_version},



        ]
    },

    {
        path: '/',
        component: navigation,
        name: '渠道管理',
        iconCls: 'el-icon-document',//图标样式class
        hidden:fk_brokerCompany,
        children: [
            { path:'/qdCompany', component: qdCompany, name: '渠道公司管理',hidden:fk_qdCompanyList},
            { path:'/brokerCompany', component: BrokerCompany, name: '渠道公司门店管理',hidden:fk_brokerCompanyList},
            { path:'/brokerCompany/add',component:BrokerCompanyAdd,name:'渠道公司门店录入',hidden:true},
            { path:'/brokerCompany/edit',component:BrokerCompanyAdd,name:'渠道公司门店编辑',hidden:true},
            { path:'/brokerCompany/view',component:BrokerCompanyAdd,name:'渠道公司门店查看',hidden:true},
            { path:'/brokerCompanyUserList',component:BrokerCompanyUser,name:'渠道公司门店人员管理',hidden:fk_brokerCompanyUserList},
            { path:'/brokerCompanyUserList/add',component:BrokerCompanyUserAdd,name:'渠道公司门店人员录入',hidden:true},
            { path:'/brokerCompanyUserList/edit',component:BrokerCompanyUserAdd,name:'渠道公司门店人员编辑',hidden:true},
            { path:'/brokerCompanyUserList/view',component:BrokerCompanyUserAdd,name:'渠道公司门店人员查看',hidden:true},
            { path:'/brokerCompanyHistory',component:BrokerCompanyHistory,name:'渠道公司门店跟进记录',hidden:true},
            { path:'/brokerCompanyUserHistory',component:BrokerCompanyUserHistory,name:'渠道公司门店人员跟进记录',hidden:true},
            { path:'/brokerUser',component:BrokerUser,name:'自由经纪人管理',hidden:fk_brokerUserList},
            { path:'/brokerUser/add',component:BrokerUserAdd,name:'自由经纪人录入',hidden:true},
            { path:'/brokerUser/edit',component:BrokerUserAdd,name:'自由经纪人编辑',hidden:true},
            { path:'/brokerUser/view',component:BrokerUserAdd,name:'自由经纪人查看',hidden:true},
            { path:'/brokerUserHistory',component:BrokerUserHistory,name:'自由经纪人跟进记录',hidden:true},
        ]
    },
    {

        path: '/',
        component: navigation,
        name: '佣金管理',
        iconCls: 'el-icon-document',//图标样式class
        hidden:fk_commission,
        children: [
            { path:'/shouFangCommission', component: ShouFangCommission, name: '收房佣金管理',hidden:fk_shouFangCommission},
            { path:'/chuFangCommission',component:ChuFangCommission,name:'出房佣金管理',hidden:fk_chuFangCommission},
            { path:'/contractPayType',component:selectCommissionPayType,name:'佣金支付方式',hidden:true},

            {path:'/commissionView', component: commissionView, name: '佣金详情', hidden: true},
            {path:'/commissionAudit', component: commissionAudit, name: '佣金审批', hidden: true},
            {path:'/commissionAuditList', component: commissionAuditList, name: '财务佣金列表', hidden: fk_commissionAuditList},
            {path:'/commissionBalanceList', component: commissionBalanceList, name: '佣金列表', hidden: fk_commissionBalanceList},
        ]
    },
    {
        //版本1
        path:'/purchaseContract/dumps20170719',
        component: PurchaseContractDump20170719,
        name: '收房合同打印',
        hidden: true
    },{
        //版本2
        path:'/purchaseContract/dumps20170406',
        component: PurchaseContractDump20170406,
        name: '收房合同打印',
        hidden: true
    },
    {
        //版本1
        path:'/purchaseContract/dumps20170719pub',
        component: PurchaseContractDump20170719pub,
        name: '收房打印补充条款',
        hidden: true
    },{
        //版本1
        path:'/purchaseContract/dumps20170406pub',
        component: PurchaseContractDump20170406pub,
        name: '收房打印补充条款',
        hidden: true
    },
    { path:'/purchaseContract/summary',component:PurchaseContractSummary,name:'收房摘要',hidden:true},
    { path:'/saleContract/summary',component:SaleContractSummary,name:'出房摘要',hidden:true},
    {path:'/approvalDump/:id', component: approvalDump, name: '出房佣金申请审批单', hidden: true},

    {
        path: '/',
        component: navigation,
        name: '应收应付',
        iconCls: 'el-icon-document',//图标样式class
        hidden:fk_account,
        children: [
            { path:'/payable',component:Payable,name:'应付款管理',hidden:fk_payableList},
            { path:'/financePayable',component:FinancePayable,name:'实付款管理',hidden:fk_financePayableList},
            { path:'/receivable',component:Receivable,name:'应收款管理',hidden:fk_receivableList},
            { path:'/financeReceivable',component:FinanceReceivable,name:'实收款管理',hidden:fk_financeReceivableList},
            { path:'/accountsReceivable',component:AccountsReceivable,name:'修改记录',hidden:true},
            { path:'/receivableRecord',component:ReceivableRecord,name:'已收款记录',hidden:true},
            { path:'/payableRecord',component:PayableRecord,name:'应付款记录',hidden:true},
            { path:'/paymentRecord',component:PaymentRecord,name:'修改记录',hidden:true},
        ]

    },
    {
        //版本1
        path:'/saleContract/dumpx20170719',
        component: SaleContractDump20170719,
        name: '出方合同打印',
        hidden: true
     },
    {
        //版本1
        path:'/saleContract/dumpx20170719pub',
        component: SaleContractDump20170719pub,
        name: '出房打印补充条款',
        hidden: true
    },
    {
        //版本1
        path:'/saleContract/dumpx20180409',
        component: SaleContractDump20180409,
        name: '出方合同打印',
        hidden: true
    },
    {
        //版本1
        path:'/saleContract/dumpx20180409pub',
        component: SaleContractDump20180409pub,
        name: '出房打印补充条款',
        hidden: true
    },
    /*{
         path: '/',
         component: navigation,
         name: '任务管理',
         iconCls: 'el-icon-message',//图标样式class
         hidden:false,
         children: [
             {path:'/message', component: MessageList, name: '我的待办事项', hidden: false},
         ]

     },*/
    {
        //支付凭证
        path:'/payOrder',
        component: PayOrder,
        name: '支付凭证',
        hidden: true
    },
    {
        path: '/',
        component: navigation,
        name: '报表',
        iconCls: 'el-icon-document',//图标样式class
        hidden:fk_reportList,
        children: [
            {path:'/shoufangReport', component: ShoufangReport, name: '收房明细', hidden: fk_shoufangReport},
            {path:'/chufangReport', component: ChufangReport, name: '出房明细', hidden: fk_chufangReport},
            {path:'/chanpinReport', component: ChanPinReport, name: '产品合约表', hidden: fk_chanpinReport},
            {path:'/fangyuanXKReport', component: FangYuanXKReport, name: '房源销控表', hidden: fk_fangyuanXKReport},
            {path:'/jinggengReport', component: JingGengReport, name: '精耕房源表', hidden: fk_jinggengReport},
            {path:'/projectReport', component: ProjectReport, name: '项目汇总表', hidden: fk_projectReport},
            {path:'/projectSaleReport', component: ProjectSaleReport, name: '八周价格对比表', hidden: fk_projectSaleReport},
            {path:'/commissionReport', component: CommissionReport, name: '收房返佣', hidden: fk_commissionReport},
            {path:'/coreDataReport', component: CoreDataReport, name: '收购与销售核心数据表', hidden: fk_coreDataReport},
            {path:'/daikanReport', component: DaiKanReport, name: '客户带看', hidden: fk_daikanReport},
        ]

    },


]

export default routes;
