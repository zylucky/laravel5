<template>
    <div style="font-size: 12px;" class="summary">
        <p style="margin-left: 15%;font-size:17px;"> <u>
            <input type="checkbox" v-model="data.youshikeji">
            幼狮科技
            <input type="checkbox" v-model="data.huashuoshangmao">
            华溯商贸</u> 【    】级 </p>
        <p style="margin-left: 6%;"> <b>项目房间号</b> <u >{{data.xiangmufangjianhao}}</u> <b style="margin-left:10%;">面积</b> <u>{{data.mianji}}</u> </p>
        <div style="margin-left: 4%;float: left">
            租赁合同、经办人身份证复印件、公司营业执照复印件、法人身份证附件、委托书原件
            <br>
            <table  style="border-collapse: collapse;">
                <tr >
                    <th width="95" height="28" align="left">租户</th>
                    <td width="220" align="center">{{data.yezhu}}</td>
                    <th width="95" align="left">收款银行</th>
                    <td width="220" align="center">{{data.kaihuhang}}</td>
                    <td style="border:0 ">佣金：{{data.yongjin}}</td>
                </tr>
                <tr>
                    <th  height="28" align="left">联系方式</th>
                    <td  align="center">{{data.lianxifangshi}}</td>
                    <th  align="left">户名</th>
                    <td  align="center">{{data.shoukuanren}}</td>
                </tr>
                <tr>
                    <th  height="28" align="left"></th>
                    <td  align="center"></td>
                    <th  align="left"></th>
                    <td  align="center"></td>
                    <td style="border:0 ">销售：{{data.yewu}}</td>

                </tr>
                <tr>
                    <th  height="28" align="left">租期</th>
                    <td  align="center">{{data.weituoguanliqixian}}</td>
                    <th  align="left"  rowspan="2">免租期</th>
                    <td  align="center">{{data.zhaoshangzhuangxiuqi}}</td>
                </tr>
                <tr>
                    <th  height="28" align="left" rowspan="5">租金</th>
                    <td  align="center" height="28">{{data.zujins[0]}}</td>
                    <td  align="center"></td>
                </tr>
                <tr>
                    <td  align="center" height="28"></td>
                    <th  align="left">押金</th>
                    <td  align="center">{{toDecimal(data.baozhengjin)}}元</td>
                </tr>
                <tr>
                    <td  align="center" height="28"></td>
                    <th align="left">租金支付方式</th>
                    <td align="center">{{data.zujingzhifufangshi}}</td>
                </tr>
                <tr>
                    <td  align="center" height="28"></td>
                    <th  align="left" colspan="2">提前【{{data.tiqianfukuantian}}】天付款</th>
                    <td style="border:0 ">渠道公司：远行地产</td>
                </tr>
                <tr>
                    <td  align="center" height="28"></td>
                    <th  align="left" colspan="2">
                        <input type="checkbox" v-model="data.shifouhanwuye">是否含物业
                        <input type="checkbox" v-model="data.qvnuan">取暖
                        <input type="checkbox" v-model="data.zhileng">制冷
                        <input type="checkbox" v-model="data.fapiao">发票
                    </th>
                </tr>
                <tr>
                    <td  height="100" colspan="4" ></td>
                </tr>
            </table>
            <table   style="border-collapse: collapse;margin-left:-10px; ">
                <tr>
                    <td style="border:0 "></td>
                    <td width="75" height="28">付款日</td>
                    <td width="75">付款科目</td>
                    <td width="200">付款周期</td>
                    <td width="75">付款金额</td>
                    <td width="202">备注</td>
                    <td style="border:0 ">签约日:{{changeDate(data.qianyueri)}}</td>
                </tr>

                <tr v-for="(item,index) in data.yjProofs">
                    <td style="border:0 "></td>
                    <td height="28">{{changeDate(item.fukuanri)}}</td>
                    <td>{{item.fukuankemu}}</td>
                    <td>{{item.fukuanzhouqi}}</td>
                    <td>{{toDecimal(item.fukuanjine)}}元</td>
                    <td>{{item.beizhu}}</td>
                </tr>
                <tr>
                    <td style="border:0 "></td>

                    <td height="28"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr v-for="(item,index) in data.zjProofs">
                    <td style="border:0 ">{{index+1}}</td>
                    <td height="28">{{changeDate(item.fukuanri)}}</td>
                    <td>{{item.fukuankemu}}</td>
                    <td>{{item.fukuanzhouqi}}</td>
                    <td>{{toDecimal(item.fukuanjine)}}元</td>
                    <td>{{item.beizhu}}</td>
                </tr><tr>
                <td style="border:0 "></td>
                <td height="28"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr><tr>
                <td style="border:0 "></td>

                <td height="28"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr><tr>
                <td style="border:0 "></td>

                <td height="28"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr><tr>
                <td style="border:0 "></td>

                <td height="28"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </table>
        </div>
    </div>


</template>
<style>
    .summary table td{
        border: 1px solid;
    }
    .summary table th{
        border: 1px solid;
    }
</style>
<script>
    import {summaryPurchaseContract} from '../../api/api.js';
    export default {
        data(){
            return{
                data:{}
            }
        },
        methods:{
            yongtu(use){
                var apply=[];
                apply[1] = '公寓';
                apply[2] = '写字楼';
                apply[3] = '商铺';
                apply[4] = '住宅';
                return apply[use];
            },
            changeDate(riqi){
                var newDate = new Date();
                newDate.setTime(riqi);
                if(riqi!=null){
                    return newDate.toLocaleDateString()
                }
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
                return s;
            },
            getInfo(){
                let para ={
                    id:this.$route.query.id,
                    httype:1,
                }
                summaryPurchaseContract(para).then((res)=>{
                    this.data = res.data.data;
                    console.log(this.data)

                });
            }
        },
        mounted(){
            this.getInfo();
        }
    }
</script>