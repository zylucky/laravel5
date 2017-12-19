<template>
    <el-row>

        <table   border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 基本信息</td></tr>
            <tr class="tr1" >
                <td   class="td1"> 楼盘：
                </td>
                <td  class="td2">12331</td>
                <td  class="td1" >
                    座栋：
                </td>
                <td  class="td2">
                    sdsdfwseffd
                </td>
                <td   class="td1">
                    房间号：
                </td>
                <td  class="td2" >
                    xcdsfs
                </td>
            </tr>
            <tr class="tr1">
                <td  > 签单人：
                </td>
                <td>12331</td>
                <td  >
                    联系电话：
                </td>
                <td  >
                    sdsdfwseffd
                </td>
                <td  >
                    申领金额：
                </td>
                <td  >
                    xcdsfs
                </td>
            </tr>
            <tr class="tr1">
                <td  > 渠道门店：
                </td>
                <td>12331</td>
                <td  >
                     渠道人员：
                </td>
                <td  >
                   sdsdfwseffd
                </td>
                <td  >
                    联系电话：
                </td>
                <td >
                    xcdsfs
                </td>
            </tr>
            <tr class="tr1">
                <td  > 收款方户名：
                </td>
                <td>12331</td>
                <td  >
                    开户行：
                </td>
                <td  >
                    sdsdfwseffd
                </td>
                <td  >
                    银行账号：
                </td>
                <td >
                    xcdsfs
                </td>
            </tr>
            </tbody>
        </table>
        <div >
        <el-steps :active="3" align-center>
            <el-step title="发起申请" description="张三  2017-12-15"></el-step>
            <el-step title="佣金确认" description="李四  2017-12-15"></el-step>
            <el-step title="领导审批" description="赵五  2017-12-15"></el-step>
            <el-step title="财务审批" description="刘六  2017-12-15"></el-step>
        </el-steps>
        </div>
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
        getPayOrder,
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
            daxie(money) {
                if (money == null) {
                    return '';
                }
                //汉字的数字
                var cnNums = new Array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
                //基本单位
                var cnIntRadice = new Array('', '拾', '佰', '仟');
                //对应整数部分扩展单位
                var cnIntUnits = new Array('', '万', '亿', '兆');
                //对应小数部分单位
                var cnDecUnits = new Array('角', '分', '毫', '厘');
                //整数金额时后面跟的字符
                var cnInteger = '整';
                //整型完以后的单位
                var cnIntLast = '元';
                //最大处理的数字
                var maxNum = 999999999999999.9999;
                //金额整数部分
                var integerNum;
                //金额小数部分
                var decimalNum;
                //输出的中文金额字符串
                var chineseStr = '';
                //分离金额后用的数组，预定义
                var parts;
                if (money == '') {
                    return '';
                }
                money = parseFloat(money);
                if (money >= maxNum) {
                    //超出最大处理数字
                    return '';
                }
                if (money == 0) {
                    chineseStr = cnNums[0] + cnIntLast + cnInteger;
                    return chineseStr;
                }
                //转换为字符串
                money = money.toString();
                if (money.indexOf('.') == -1) {
                    integerNum = money;
                    decimalNum = '';
                } else {
                    parts = money.split('.');
                    integerNum = parts[0];
                    decimalNum = parts[1].substr(0, 4);
                }
                //获取整型部分转换
                if (parseInt(integerNum, 10) > 0) {
                    var zeroCount = 0;
                    var IntLen = integerNum.length;
                    for (var i = 0; i < IntLen; i++) {
                        var n = integerNum.substr(i, 1);
                        var p = IntLen - i - 1;
                        var q = p / 4;
                        var m = p % 4;
                        if (n == '0') {
                            zeroCount++;
                        } else {
                            if (zeroCount > 0) {
                                chineseStr += cnNums[0];
                            }
                            //归零
                            zeroCount = 0;
                            chineseStr += cnNums[parseInt(n)] + cnIntRadice[m];
                        }
                        if (m == 0 && zeroCount < 4) {
                            chineseStr += cnIntUnits[q];
                        }
                    }
                    chineseStr += cnIntLast;
                }
                //小数部分
                if (decimalNum != '') {
                    var decLen = decimalNum.length;
                    for (var i = 0; i < decLen; i++) {
                        var n = decimalNum.substr(i, 1);
                        if (n != '0') {
                            chineseStr += cnNums[Number(n)] + cnDecUnits[i];
                        }
                    }
                }
                if (chineseStr == '') {
                    chineseStr += cnNums[0] + cnIntLast + cnInteger;
                } else if (decimalNum == '') {
                    chineseStr += cnInteger;
                }
                return chineseStr;
            },

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
                getPayOrder(para).then((res) => {
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


        },
        mounted() {
            this.getPayable();
        }
    }
</script>
