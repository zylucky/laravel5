<template>
    <el-row class="">
        <ol style="list-style:none;">
            <li v-for="xsOffice in xsOffice" >
                <el-row>
                    <el-col :span="8">
                        <span >楼盘：{{xsOffice.loupanName}}</span>
                    </el-col>
                    <el-col :span="8">
                        <span >楼栋：{{xsOffice.loudongName}}</span>
                    </el-col>
                    <el-col :span="8">
                        <span>房间号： {{xsOffice.fanghao}}</span>
                    </el-col>
                </el-row>
            </li>
        </ol>
        <el-row :gutter="20" style="margin-bottom:30px;">
            <el-col :span="8"> <span >原合同编号：{{bianhao}}</span> </el-col>
        </el-row>
        <el-form :model="jieyueXieyi"  label-Weizhi="right" label-width="100px" :rules="jieyueRules">
            <el-row>
                <el-col :span="8">
                    <el-form-item label="新合同编号" prop="xinbianhao" required>
                        <el-input v-model="jieyueXieyi.xinbianhao" placeholder="请输入新合同编号"  ></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="解约方式" prop="jieyuefangshi" required>
                <el-radio-group v-model="jieyueXieyi.jieyuefangshi">
                    <el-radio :label="1">退租</el-radio>
                    <el-radio :label="2">扩租</el-radio>
                    <el-radio :label="3">缩租</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-row>
                <el-col :span="8">
                    <el-form-item label="合同终止日期" prop="zhongzhidate" required>
                        <el-date-picker type="date" placeholder="请选择合同终止日期" v-model="jieyueXieyi.zhongzhidate" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="交房日期" prop="jiaofangdate">
                        <el-date-picker type="date" placeholder="请选择交房日期" v-model="jieyueXieyi.jiaofangdate" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="工商营业执照迁出" prop="zhizhaoqianchu" required>
                <el-radio-group v-model="jieyueXieyi.zhizhaoqianchu">
                    <el-radio :label="1">是</el-radio>
                    <el-radio :label="0">否</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-row>
                <el-col :span="8">
                    <el-form-item label="退还押金" prop="tuihuanyajin" required>
                        <el-input v-model.number="jieyueXieyi.tuihuanyajin" placeholder="请输入退还押金"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="退还剩余房租" prop="tuihuanfangzu" required>
                        <el-input v-model.number="jieyueXieyi.tuihuanfangzu" placeholder="请输入退还剩余房租"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8" style="display: none;">
                    <el-form-item label="合同的id">
                        <el-input v-model="hetongid" placeholder="请输入退还剩余房租"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-col :span="8">
                <el-form-item label="应收杂费" prop="yingshouzafei" required>
                    <el-input v-model.number="jieyueXieyi.yingshouzafei" placeholder="请输入租户应交杂费"></el-input>
                </el-form-item>
            </el-col>
            <div style="margin-left:-50px;">
                <el-button type="primary" v-show="!reviewVisible" @click="save" style="margin-top:100px;">保&nbsp;&nbsp;&nbsp;存</el-button>
                <el-button type="primary" v-show="!reviewVisible" :disabled="btnType" @click="submit"  style="margin-top:100px;">{{submsg}}</el-button>
                <el-button v-if="btnShow" type="warning" @click="cancel" style="margin-top:100px;">取&nbsp;&nbsp;&nbsp;消</el-button>
            </div>
        </el-form>

    </el-row>
</template>

<script>
    import {getSaleContractList,getSaleContractInfo,getLoupanList,getLoudongList,getFanghaoList,jieyueSaleContract,addSaleJieyueContractInfo,jieyuewanSaleContract,getJieyueSaleContract,getjieyueSaleContractInfo,jieyueSaleContractInfo} from '../../api/api';
    export default {
        components:{

        },
        data() {
            return {
                btnType:true,
                submsg:'提交',
                id:'',
                btnShow:true,
                reviewVisible:false,//审核显示
                xsOffice:[{
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                bianhao: null,
                jieyueXieyi:{
                    jieyuefangshi:null,
                    zhongzhidate:'',
                    jiaofangdate:'',
                    zhizhaoqianchu:'',
                    tuihuanyajin:'',
                    tuihuanfangzu:'',
                    yingshouzafei:'',
                    xinbianhao: null,
                },
                hetongid:null,
                jieyueRules : {
                    xinbianhao: [
                        {required: true, message: '不能为空'}
                    ],
                    jieyuefangshi: [
                        {required: true, message: '不能为空'}
                    ],
                    zhongzhidate: [
                        {required: true, message: '不能为空'}
                    ],
                    zhizhaoqianchu: [
                        {required: true, message: '不能为空'}
                    ],
                    tuihuanyajin: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ],
                    tuihuanfangzu: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ],
                    yingshouzafei: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ],
                },
            }
        },
        methods: {
            //根据url得到的合同ID，来获取数据
            getSaleContract(id){
                getSaleContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //console.log(res.data.data)
                        //把数据分别赋值给三个组件的变量
                        this.fuzhi(res);
                    }else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },

            save:function () {
                this.btnType = false;
                this.submsg  = '提交';
                /*var xinbianhao = this.xinbianhao;
                var jieyuefangshi = this.jieyuefangshi;
                var zhongzhidate = this.zhongzhidate;
                var jiaofangdate = this.jiaofangdate;
                var zhizhaoqianchu = this.zhizhaoqianchu;
                var tuihuanyajin = this.tuihuanyajin;
                var tuihuanfangzu = this.tuihuanfangzu;
                var yingshouzafei = this.yingshouzafei;*/
                //var child_renter  = this.$refs.renter.renter;
                //var child_date = this.$refs.date.addDate;
                /*var bianhao = {
                    bianhao: this.bianhao,
                };*/
                //alert(11);
                //let para = Object.assign({}, xinbianhao,jieyuefangshi,zhongzhidate,jiaofangdate,zhizhaoqianchu,tuihuanyajin,tuihuanfangzu,yingshouzafei,id);

                var hetongid = {
                    hetongid: this.hetongid,
                };
                let para = Object.assign({}, hetongid,this.jieyueXieyi);
                console.log(para);
                //alert(111);
                addSaleJieyueContractInfo(para).then((res) => {
                    if(res.data.code == 200)　{
                        //alert(333);
                        this.fuzhi(res);
                        /*getSaleContractList(hetongid).then((res) => {*/
                            //alert(444);
                            /*if(res.data.code == 200)
                            {*/
                                //alert(5555);
                                //console.log(res);
                               //this.fuzhi3(res);
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });
                        /*}else{
                                this.$message({
                                    message: res.data.msg,
                                    type: 'error'
                                })
                            }*/
                        //});
                    } else {
                        this.$message({
                            message: res.data.msg,
                            type: 'error'
                        })
                    }

                });
            },

            submit(){
                var hetongid = {
                    hetongid: this.hetongid,
                };
                let para = Object.assign({}, hetongid,this.jieyueXieyi);
               /* let para ={
                    hetongid: this.hetongid,
                    /!*xinbianhao:this.xinbianhao,
                    jieyuefangshi:this.jieyuefangshi,
                    zhongzhidate: this.zhongzhidate,
                    jiaofangdate: this.jiaofangdate,
                    zhizhaoqianchu: this.zhizhaoqianchu,
                    tuihuanyajin: this.tuihuanyajin,
                    tuihuanfangzu: this.tuihuanfangzu,
                    yingshouzafei: this.yingshouzafei,*!/
                    jieyueXieyi: this.jieyueXieyi,
                };*/
                //alert(111);
                //this.btnType = false;
                //this.submsg  = '提交';
                //var child_property = this.$refs.property.property;//
                //var child_owner  = this.$refs.owner.owner;//业主信息
                //alert(child_date);
                /*var tiaokuan = {
                    tiaoList:this.$refs.tiaokuan.tiaoList,
                };//条款*/
                /*jieyuewanSaleContract(para).then((res)=>{
                });*/
                console.log(para);
                jieyueSaleContractInfo(para).then((res) => {
                    if(res.data.code == 200){
                        history.go(-1);
                        this.$message({//这是Vue中从后台返回来的数据的格式
                         message:'提交成功',
                         type:'success'
                         });
                        this.btnType = true;
                        this.submsg  = '已提交';
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                    /*if(res.data.code=='200'){
                        this.$route.push('/saleContract');
                    }*/
                });
            },
            //根据url得到的合同ID，来获取数据
           /* getJieyueSaleContract(id){
                getJieyueSaleContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //把数据分别赋值给三个组件的变量
                        this.fuzhi(res);
                    }else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },*/
            cancel(){
                /*window.open('/#/saleContract/dump?id='+row.id)
                window.location.href="./Index.vue";*/
                window.history.back(-1);
            },
            /*fuzhi(res){
                var loupanName = document.getElementById("loupanName").innerHTML;
                var loudongName = document.getElementById("loudongName").innerHTML;
                var fanghao = document.getElementById("fanghao").innerHTML;
                var biaohao = document.getElementById("biaohao").innerHTML;
                //this.property.officeList = res.data.data.officeList;
                this.id = res.data.data.id;
                loupanName = res.data.data.officeList.loupanName;
                loudongName = res.data.data.officeList.loudongName;
                fanghao = res.data.data.officeList.fanghao;
                biaohao = res.data.data.bianhao;
            },*/
            /*removeTab(targetName) {
                this.property.officeList.pop();//删除
                let tabs = this.editableTabs2;
                let activeName = this.editableTabsValue2;
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1];
                            if (nextTab) {
                                activeName = nextTab.name;
                            }
                        }
                    });
                }

                this.editableTabsValue2 = activeName;
                this.editableTabs2 = tabs.filter(tab => tab.name !== targetName);
            }*/
            disabledInput(){
                this.reviewVisible =true;
                var allInputs = document.getElementsByTagName('input');
                //var textArea = document.getElementsByTagName('textarea');
                for (let i=0; i<allInputs.length; i++){
                    allInputs[i].disabled="true";
                    allInputs[i].parentNode.className += " is-disabled";
                }
                /*for (let i=0; i<textArea.length; i++){
                    textArea[i].disabled="true";
                    textArea[i].parentNode.className += " is-disabled";
                }*/

            },
            fuzhi(res){
                //console.log(res.data.data);
                this.hetongid = res.data.data.id;
                this.xsOffice = res.data.data.xsOffice;
                //console.log(this.xsOffice);
                this.jieyueXieyi = res.data.data.jieyueXieyi[0];
                this.bianhao = res.data.data.bianhao;
                /* this.xinbianhao = res.data.data.xinbianhao;
                this.jieyuefangshi = res.data.data.jieyuefangshi;
                this.zhongzhidate = res.data.data.zhongzhidate;
                this.jiaofangdate = res.data.data.jiaofangdate;
                this.zhizhaoqianchu = res.data.data.zhizhaoqianchu;
                this.tuihuanyajin = res.data.data.tuihuanyajin;
                this.tuihuanfangzu = res.data.data.tuihuanfangzu;
                this.yingshouzafei = res.data.data.yingshouzafei;*/
                //console.log(this.jieyueXieyi);
            },
            /*fuzhi2(res){
                //console.log(res.data.data);
                //this.hetongid = res.data.data.id;
                //this.xsOffice = res.data.data.xsOffice;
                //console.log(this.xsOffice);
                //this.bianhao = res.data.data.bianhao;
                this.xinbianhao = res.data.data.xinbianhao;
                this.jieyuefangshi = res.data.data.jieyuefangshi;
                this.zhongzhidate = res.data.data.zhongzhidate;
                this.jiaofangdate = res.data.data.jiaofangdate;
                this.zhizhaoqianchu = res.data.data.zhizhaoqianchu;
                this.tuihuanyajin = res.data.data.tuihuanyajin;
                this.tuihuanfangzu = res.data.data.tuihuanfangzu;
                this.yingshouzafei = res.data.data.yingshouzafei;
            },
            fuzhi1(res){
                this.hetongid = res.data.data.id;
                this.xsOffice = res.data.data.xsOffice;
                this.bianhao = res.data.data.bianhao;
            },
            fuzhi3(res){
                this.xsOffice = res.data.data.xsOffice;
                this.bianhao = res.data.data.bianhao;
            },*/
        },
        mounted() {
            //根据url得到的合同ID，来获取数据
            if(this.$route.query.id!=null){
                this.getSaleContract(this.$route.query);
            }
            if(this.$route.path=='/saleContract/checkJieyue'){
                this.disabledInput();
                this.btnShow=false;
            }
        }

    }
</script>