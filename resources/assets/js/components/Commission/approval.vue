<template>
    <div class="approval">
        <div class="header">
            <h1>出房佣金申请审批单</h1>
            <span>北京幼狮科技有限公司</span>
            <span>申请时间：{{format_date(approval.data.createdate)}}</span>
        </div>
        <div class="container">
            <table style="border-collapse: collapse;">
                <tr>
                    <th align="center" width="200" height="30">申请人:</th>
                    <td align="center" width="400" height="30">{{approval.data.xiaoshou}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 申请人部门:</th>
                    <td align="center" width="400" height="30">{{approval.data.sondeptname}}{{approval.data.groupname}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 房间:</th>
                    <td align="center" width="400">
                        {{approval.data.loupan}}-
                        {{approval.data.loudong}}-
                        {{approval.data.fanghao}}
                    </td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 佣金金额:</th>
                    <td align="center" width="400">¥{{approval.data.xsyongjin}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 佣金信息:</th>
                    <td align="center" width="400">{{approval.data.xsyongjinxinxi==true?'正常':'不正常'}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 月租金:</th>
                    <td align="center" width="400">¥{{approval.data.yzj}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 佣金计算公式:</th>
                    <td align="center" width="400">{{approval.data.xsjisuangongshi}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30">  渠道姓名:</th>
                    <td align="center" width="400">{{approval.data.xsqvdao}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30">  渠道联系方式:</th>
                    <td align="center" width="400">{{approval.data.xsqvdaotel}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 收款方户名:</th>
                    <td align="center" width="400">{{approval.data.qdhuming}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30"> 收款银行:</th>
                    <td align="center" width="400">{{(approval.data.qdkaihuhang)}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30">    收款账号:</th>
                    <td align="center" width="400">{{format_bank(approval.data.qdzhanghao)}}</td>
                </tr>
                <tr>
                    <th align="center" width="200" height="30">  渠道备注:</th>
                    <td align="center" width="400">{{approval.data.qdbeizhu}}</td>
                </tr>
                <tr>
                    <th align="center" :rowspan="approval.shenPi.length"  width="200" height="30"> 审批人:</th>
                    <td align="center" width="400">{{approval.shenPi[0].person}}
                        {{format_shenpi(approval.shenPi[0].shenpi)}}
                        {{format_date(approval.shenPi[0].shenpitime)}}</td>
                </tr>
                <tr v-if="index>=1" v-for="(item,index) in approval.shenPi">
                    <td  align="center" width="400">
                        {{item.person}}
                        {{format_shenpi(item.shenpi)}}
                        {{format_date(item.shenpitime)}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    import {getApprovalInfo} from "../../api/api"

    export default{
        data(){
            return {
                approval:{
                    data:{
                        createdate:'',
                        deptid: null,
                        deptname: null,
                        fanghao: null,
                        groupname: null,
                        groupteam: null,
                        id: null,
                        loudong: null,
                        loupan: null,
                        sondeptid: null,
                        sondeptname: null,
                        xiaoshou: null,
                        xiaoshouid: null,
                        xsjisuangongshi: null,
                        xsqvdao:null,
                        xsqvdaotel: null,
                        xsyongjin: 10000,
                        xsyongjinxinxi: true,
                        qdbeizhu:'',
                        qdhuming:'',
                        qdkaihuhang:'',
                        qdzhanghao:'',
                        yzj:'',
                    },
                    shenPi:[
                        {
                            person:"王谦",
                            shenpitime:'',
                        }
                    ],
                }
            }
        },
        methods:{
            getInfo(){
                let params = {
                    id:this.$route.params.id,
                }
                getApprovalInfo(params).then((res)=>{
                    console.log(res.data)
                    this.approval = res.data;
                    this.approval.data.yzj=this.$route.query.yzj;
                })
            },
            format_shenpi(shenpi){
                var res = '';
                switch(shenpi)
                {
                    case 1:
                        res = '已同意';
                        break;
                    case 2:
                        res = '已驳回';
                        break;
                    default:
                        res = '未处理';
                }
                return res;
            },
            format_date(date){
                if(!date){
                    return '';
                }
                var myDate = new Date(date);
                var year = myDate.getFullYear();
                var month = myDate.getMonth()+1;
                var day = myDate.getDate();
                var hour = myDate.getHours();
                var minute = myDate.getMinutes();
                var second = myDate.getSeconds();
                if(month<10){month = '0' + month;}
                if(day<10){day = '0' + day;}
                if(hour<10){hour = '0' + hour;}
                if(minute<10){minute = '0' + minute;}
                if(second<10){second = '0' + second;}
                return year+'-'+month+'-'+day + ' ' + hour + ':' + minute;
            },
            format_bank(num){
               if(num){
                   return num.replace(/[\s]/g, '').replace(/(\d{4})(?=\d)/g, "$1 ")
               }
            }
        },
        mounted(){
            this.getInfo();
        }
    }
</script>
<style>
    .approval{
        text-align: center;
    }
    .approval .container table{
        margin: 50px 0 0 10%;
    }
    .approval table td{
        border: 1px solid;
    }
    .approval table th{
        border: 1px solid;
    }
</style>