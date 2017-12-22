<template>
    <el-row>

        <table   border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 基本信息</td></tr>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 基本信息</td></tr>
            <tr class="tr1" >
                <td   class="td1"> 楼盘：
                </td>
                <td  class="td2">{{Payable.loupan}}</td>
                <td  class="td1" >
                    座栋：
                </td>
                <td  class="td2">
                    {{Payable.loudong}}
                </td>
                <td   class="td1">
                    房间号：
                </td>
                <td  class="td2" >
                    {{Payable.fanghao}}
                </td>
            </tr>
            <tr class="tr1">
                <td  > 签单人：
                </td>
                <td>{{Payable.salesmanName}}</td>
                <td  >
                    联系电话：
                </td>
                <td  >
                    {{Payable.salesmanPhone}}
                </td>
                <td  >
                    申领金额：
                </td>
                <td  >
                    {{toDecimal(Payable.yongjin)}}
                </td>
            </tr>
            <tr class="tr1">
                <td  > 渠道门店：
                </td>
                <td>{{Payable.gsname}}</td>
                <td  >
                    渠道人员：
                </td>
                <td  >
                    {{Payable.qvdao}}
                </td>
                <td  >
                    联系电话：
                </td>
                <td >
                    {{Payable.phone}}
                </td>
            </tr>
            <tr class="tr1">
                <td  > 收款方户名：
                </td>
                <td>{{Payable.huming}}</td>
                <td  >
                    开户行：
                </td>
                <td  >
                    {{Payable.kaihuhang}}
                </td>
                <td  >
                    银行账号：
                </td>
                <td >
                    {{Payable.zhanghao.replace(/\s/g, '').replace(/(.{4})/g, "$1 ")}}
                </td>
            </tr>
            </tbody>
        </table>
        <table  width="1220px" border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;margin-top:30px" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 审批进度</td></tr>
            <tr style=" text-align:left; height: 40px"><td colspan="6"> <div style="margin-left:60px;margin-top:30px;width: 100%;height: 130px">
        <el-steps :active="3" align-center >
            <el-step title="发起申请" description="张三  2017-12-15"></el-step>
            <el-step title="佣金确认" description="李四  2017-12-15"></el-step>
            <el-step title="领导审批" description="赵五  2017-12-15"></el-step>
            <el-step title="财务审批" description="刘六  2017-12-15"></el-step>
            <el-step title="领导审批" description="赵五  2017-12-15"></el-step>
            <el-step title="财务审批" description="刘六  2017-12-15"></el-step>
        </el-steps>
        </div></td></tr>
            </tbody>
        </table>
        <table  width="1220px" border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;margin-top:30px" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 审批意见</td></tr>

            </tbody>
        </table>
            <el-input type="textarea"  auto-complete="off"
                      placeholder="请输入意见"    style="width:1220px"></el-input>
       <div > <el-button @click.native="handleAgis">通过</el-button>
           <el-button @click.native="handleReject">驳回</el-button></div>
    </el-row>
</template>
<style>

    .tr1{
        height: 40px;
    }
    .td1{
        width:160px;
    }
    .td2{
        width:240px;
    }

</style>
<script>

    import {
        showcommission,auditComm
    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                Payable: [],
                nowDate: '',
            }
        },
        methods: {
            //时间戳转日期格式
            changeDate(value){
                if (value != '' || value != null) {
                    var newDate = new Date();
                    newDate.setTime(value);
                    return newDate.toLocaleDateString();
                }
            },
            //获取应付款列表
            getPayable() {
                let para = {
                    id: this.$route.query.id
                };
                this.listLoading = true;
                showcommission(para).then((res) => {
                    this.Payable = res.data.data;
                    this.listLoading = false;
                });
            },
            toDecimal(x) {
                var f = parseFloat(x);
                if (isNaN(f)) {
                    return false;
                }
                var f = Math.round(x * 100) / 100;
                var s = f.toString();
                var rs = s.indexOf('.');
                if (rs < 0) {
                    rs = s.length;
                    s += '.';
                }
                while (s.length <= rs + 2) {
                    s += '0';
                }
                return  s.split('').reverse().join('').replace(/(\d{3}(?=\d)(?!\d+\.|$))/g, '$1,').split('').reverse().join('');
            },
            handleAgis: function (index, row) {
                this.$confirm('确认通过审核吗？', '提示', {}).then(() => {
                    let para = {
                        id:row.tQdApplyId,
                    }
                    //console.log(para);
                    auditComm(para).then((res) => {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.getPayable();
                    });
                });
            },
            handleReject: function (index, row) {
                this.$confirm('确认驳回审核吗？', '提示', {}).then(() => {
                    let para = {
                        id:row.tQdApplyId,
                    }
                    //console.log(para);
                    auditComm(para).then((res) => {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.getPayable();
                    });
                });
            },

        },
        mounted() {
            this.getPayable();
        }
    }
</script>
