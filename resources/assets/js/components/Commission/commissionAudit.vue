<template>
    <el-row>

        <table   border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;width:1280px" >
            <tbody>
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
        <table  width="1280px" border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;margin-top:30px" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 发票信息</td></tr>

            </tbody>
        </table>
        <el-upload  style="margin-top:30px"
                    action=""
                    list-type="picture-card"
                    disabled="true"
                    :on-preview="handlePictureCardPreview"
                    :file-list="fapiao"
        >

        </el-upload>
        <el-dialog v-model="dialogVisible" size="large">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
        <table  width="1280px" border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;margin-top:30px" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 审批进度</td></tr>
            <tr style=" text-align:left; height: 40px"><td colspan="6">
                <!--<div style="margin-left:20px;margin-top:30px;width: 100%;height: 130px"  >-->

                    <!--<el-steps :active=shenpijindu align-center >
                        <el-step v-for="(item, index) in options" :title="item.value" :key="index" :description="item.label"></el-step>

                    </el-steps>-->
                <!--</div>-->
                <ul class="plan_box">
		        	<li v-for="(item, index) in options">
		        		<p :class="item.shenpi==1 && !item.isfock?'zt':(item.shenpi!=1 && item.shenpi!=2 && item.isfock?'zt spz':(item.shenpi==2?'zt ybh':'zt dsp'))">
		        			<span :class="item.shenpi==1 && !item.isfock?'xh':(item.shenpi!=1 && item.shenpi!=2 && item.isfock?'xh xh3':(item.shenpi==2?'xh xh2':'xh xh1'))">{{index + 1}}</span>
		        			<span>
								<i v-if='item.shenpi==1 && !item.isfock'>{{item.shenpi==1 && !item.isfock?"已通过":"待审批"}}</i>
								<i v-if='item.shenpi==null && !item.isfock'>{{item.shenpi==null && !item.isfock?"待审批":''}}</i>
								<i v-if='item.shenpi!=1 && item.shenpi!=2 && item.isfock'>审批中</i>
								<i v-if='item.shenpi==2'>{{item.shenpi==2?"已驳回":"已审批"}}</i>
							</span>
		        			<span :class="item.shenpi==1 && !item.isfock?'tiao':(item.shenpi!=1 && item.shenpi!=2 && item.isfock?'tiao jb1':(item.shenpi==2?'tiao jb2':(item.shenpi==null && !item.isfock?'tiao jb3':'tiao jb')))"></span>
		        		</p>
		        		<p class="name">{{item.value}}</p>
		        		<p class="date">{{item.label}}</p>
		        		
		        	</li>
		        </ul>
            </td></tr>
            </tbody>
        </table>

        <table  width="1280px" border="1" bordercolor="#DFE6EC"  style="border-collapse:collapse!important;text-align:center;margin-top:30px" >
            <tbody>
            <tr style=" text-align:left;background-color:#EEF1F6;height: 40px"><td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 审批意见</td></tr>

            </tbody>
        </table>
        <el-input type="textarea"  auto-complete="off"
                  placeholder="请输入意见"   v-model="shuoming" style="width:1280px"></el-input>
        <div style="text-align:center;margin-top:30px;width:1280px" > <el-button @click.native="save">通过</el-button>
            <el-button @click.native="bohui">驳回</el-button></div>
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
	.el-upload--picture-card{
		display: none !important;
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
                options: [
                ],
                shenpijindu:1,
                shuoming:'',
                fapiao:[],
                dialogVisible: false,
                dialogImageUrl: '',
            }
        },
        methods: {
            //时间戳转日期格式
            changeDate(value){
                if (value != '' && value != null) {
                    console.log(value)
                    var newDate = new Date();
                    newDate.setTime(value);
                    var hour = newDate.getHours();
				    var minute = newDate.getMinutes();
				    var second = newDate.getSeconds();
				    if(hour<10){hour = '0' + hour;}
				    if(minute<10){minute = '0' + minute;}
				    if(second<10){second = '0' + second;}
                    return newDate.toLocaleDateString() + ' ' + hour + ':' + minute + ':' + second;
                }
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            //获取应付款列表
            getPayable() {
                let para = {
                    id: this.$route.query.id
                };
                this.listLoading = true;
                showcommission(para).then((res) => {
                    this.Payable = res.data.data;
                    this.fapiao=res.data.imgs;
                    this.listLoading = false;
                    for (var item in res.data.shenPi) {
                        if(res.data.shenPi[item].isfock==true){
                            this.shenpijindu=parseInt(item);
                        }

                        this.options.push({
                            value: res.data.shenPi[item].person,
                            label: this.changeDate(res.data.shenPi[item].shenpitime ),
                            shenpi: res.data.shenPi[item].shenpi,
                            isfock: res.data.shenPi[item].isfock,
                        });
                    }
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
            save(){
                this.$confirm('确认通过吗？', '提示', {}).then(() => {
                    let para = {
                        id: this.$route.query.id,
                        shenpi:1,
                        shuoming:this.shuoming,
                    };
                    auditComm(para).then((res) => {
                        if(res.data.code==200){
                            this.$message({
                                message: '提交成功',
                                type: 'success'
                            });
                            if(this.fun("commissionAuditList"))
                            {
                                this.$router.push('/commissionAuditList');
                            }else{
                                this.$router.push('/commissionBalanceList');
                            }

                        }else{
                            this.$message({
                                message: res.data.msg,
                                type: 'error'
                            });

                        };
                    });
                });
            },
            bohui(){
                this.$confirm('确认驳回吗？', '提示', {}).then(() => {
                    let para = {
                        id: this.$route.query.id,
                        shenpi:2,
                        shuoming:this.shuoming,
                    };
                    auditComm(para).then((res) => {
                        if(res.data.code==200){
                            this.$message({
                                message: '提交成功',
                                type: 'success'
                            });
                            if(this.fun("commissionAuditList"))
                            {
                                this.$router.push('/commissionAuditList');
                            }else{
                                this.$router.push('/commissionBalanceList');
                            }
                        }else{
                            this.$message({
                                message: res.data.msg,
                                type: 'error'
                            });

                        };
                    });
                });
            },
        },
        mounted() {
            this.getPayable();
        }
    }
</script>
<style scoped>
	ul,li,dl,dd{
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.plan_box{
		display: flex;
		min-height: 50px;
		height: auto;
		font-size: 16px;
		margin: 30px;
	}
	.plan_box p{
		margin: 0;
		padding: 0;
		text-align: center;
	}
	.plan_box li{
		display: flex;
		flex-direction: column;
		align-items: center;
		width: 120px;
		margin-right: 35px;
	}
	.zt{
		position: relative;
		width: 120px;
		height: 34px;
		line-height: 34px;
		background: #1fa0fc;
		color: #fff;
		font-size: 16px;
		text-align: center;
		border-radius: 34px;
		margin-bottom: 10px !important;
	}
	.zt .xh{
		display: inline-block;
		width: 20px;
		height: 20px;
		line-height: 20px;
		border-radius: 50%;
		background: #fff;
		color: #1fa0fc;
		text-align: center;
	}
	.zt i{
		font-style: normal;
	}
	.name,.date{
		color: #646464;
	}
	.tiao{
		position: absolute;
		left: -37.5px;
		top: 50%;
		margin-top: -1px;
		display: inline-block;
		width: 40px;
		height: 2px;
		background: #1fa0fc;
	}
	.plan_box li:first-child .tiao{
		display: none;
	}
	.dsp{
		/*待审批样式*/
		background: #bbbbbb;
	}
	.xh1{
		/*待审批文字颜色*/
		color: #bbbbbb!important;
	}
	.ybh{
		/*驳回样式*/
		background: #ff7271;
	}
	.xh2{
		/*驳回文字颜色*/
		color: #ff7271!important;
	}
	.spz{
		/*审批中*/
		background: #fea843;
	}
	.xh3{
		/*审批中文字颜色*/
		color: #fea843!important;
	}
	.jb{
		/*条渐变审批中到待审批*/
		background: -webkit-linear-gradient(left,#fea843,#bbbbbb);
	}
	.jb1{
		/*条渐变已通过到审批中*/
		background: -webkit-linear-gradient(left,#20a1ff,#fea843);
	}
	.jb2{
		/*条渐变已通过到已驳回*/
		background: -webkit-linear-gradient(left,#20a1ff,#ff7271);
	}
	.jb3{
		background: #bbbbbb;
	}
</style>