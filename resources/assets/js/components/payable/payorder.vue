
<template>
    <el-row >

        <table width="750"  border="1" style="border-collapse:collapse!important">
            <caption><h2> 支 出 凭 单</h2><p style="text-align:right;padding:0;margin:0;">打印时间：'.$time.'</p></caption>
            <tbody>
            <tr >
                <td height="40"  ><div align="left">用友编号：{{Payable.fukuanyinhang}}</div></td>
                <td >&nbsp;&nbsp;&nbsp;&nbsp; {{Payable.fukuandate}}</td>
                <td height="40" colspan="2"><b>第&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</b></td>
            </tr>
            <tr>
                <td  height="110"><div><b>付款摘要</b></div></td>
                <td colspan="3">
                    <div align="left">
                        <b>项 目:</b>{{Payable.xiangmu}}<br>
                        <b>租 期:</b>{{Payable.zuqi}}<br>
                        <b>付款方式:</b>{{Payable.zhifufangshi}}<b>业主</b><u style="text-decoration:none;border-bottom:1px solid #555;padding-bottom:2px;">&nbsp;&nbsp;&nbsp;&nbsp;</u>个月房租<br>
                        <b>月租金:</b>{{Payable.monthmoney}}元<br>
                        <b>单价:</b>{{Payable.price}}<br>
                    </div>
                </td>
            </tr>
            <tr>
                <td height="30" ><div><b>计人民币</b></div></td>
                <td height="30" colspan="3"><div>{{Payable.tijiaomoney}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;¥<u style="text-decoration:none;border-bottom:1px solid #555;padding-bottom:2px;">{{Payable.tijiaomoney}}元</u></div></td>
            </tr>
            <tr>
                <td height="25" ><div><b>收款人/单位名称</b></div></td>
                <td height="25" colspan="3"><div >{{Payable.zhanghu}}</div></td>
            </tr>

            <tr>
                <td height="25"><div><b>银行账号</b></div></td>
                <td height="25" colspan="3"><div >{{Payable.fukuanzhanghao}}</div></td>
            </tr>
            <tr>
                <td height="25"><div><b>开户银行</b></div></td>
                <td height="25" colspan="3"><div >{{Payable.fukuanyinhang}}</div></td>
            </tr>
            <tr>
                <td height="80"><div><b>租户收款信息</b></div></td>
                <td height="80" colspan="3">
                    <div align="left">
                        <b>租金交至:</b><br><br>
                        <b>月租金:</b><br><br>
                        <b>付款方式:</b><br><br>
                        <b>单价:</b><br>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
        <div align="left" class="printbottom" >
            <b>财务主管：</b><span style="font-family:Times New Roman;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <b>记账：</b><span style="font-family:Times New Roman;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <b>出纳：</b><span style="font-family:Times New Roman;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <b>审核：</b><span style="font-family:Times New Roman;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <b>制单：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
            <b>主管审批:</b><span style="font-family:Times New Roman;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </div>
    </el-row>
</template>
<style>
    .printbottom{margin-bottom:280px;}
    .printbottom:last-child{margin-bottom:0px;margin-left:130px;}
    table{margin-left:130px;}
    div{margin-left:10px;}
    *{margin-top:0px;}
</style>
<script>

    import {
        getPayOrder,
    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                Payable:[],
            }
        },
        methods:{
            //时间戳转日期格式
            changeDate(fkdate){
                var newDate = new Date();
                newDate.setTime(fkdate);
                return newDate.toLocaleDateString()
            },
            //获取应付款列表
            getPayable() {
                let para = {
                    id: this.$route.query.id
                };
                this.listLoading = true;
                getPayOrder(para).then((res) => {
                    this.Payable = res.data.data;
                    this.listLoading = false;
                });
            },
        },
        mounted() {
            this.getPayable();
        }
    }
</script>
