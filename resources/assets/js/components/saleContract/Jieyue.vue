<template>
    <div>
        <div style="font-size:16px;font-weight:700;position:relative;left:30px;top:20px;">基本信息</div>
        <div style="font-size:14px;position:relative;left:30px;top:20px;">
            <span style="position:relative;left:30px;top:40px;">
                <span>楼盘名称：</span><span id="loupanName"></span>
            </span>
            <span style="position:relative;left:460px;top:40px;">
                <span>楼栋：</span><span id="loudongName"></span>
            </span>
            <span style="position:relative;left:880px;top:40px;">
                <span>房间号：</span><span id="fanghao"></span>
            </span>
            <div style="position:relative;left:15px;top:70px;">
                <span>原合同编号：</span><span id="biaohao"></span>
            </div>

                <div v-model="editableTabsValue2" type="card" closable @tab-remove="removeTab" style="position:relative;top:100px;">
                    <div
                            v-for="(item, index) in editableTabs2"
                            :key="item.name"
                            :label="item.title"
                            :name="item.name"
                    >
                        <el-form label-Weizhi="right" label-width="100px" :rules="jieyueRules" :model="property.officeList[index]">
                                <el-form-item label="新合同编号" prop="newbiaohao" required>
                                    <el-input v-model="property.officeList[index].xinbianhao" placeholder="请输入新合同编号"></el-input>
                                </el-form-item>
                                <el-form-item label="解约方式" prop="jiefangshi" required>
                                    <el-radio-group v-model="property.officeList[index].jieyuefangshi">
                                        <el-radio label="退租"></el-radio>
                                        <el-radio label="扩租"></el-radio>
                                        <el-radio label="缩租"></el-radio>
                                    </el-radio-group>
                                </el-form-item>
                                <el-row>
                                    <el-col :span="8">
                                        <el-form-item label="合同终止日期" prop="zhongzhidata" required>
                                            <el-date-picker type="date" placeholder="请选择合同终止日期" v-model="property.officeList[index].zhongzhidate" style="width: 100%;"></el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-form-item label="交房日期">
                                            <el-date-picker type="date" placeholder="请选择交房日期" v-model="property.officeList[index].jiaofangdate" style="width: 100%;"></el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-form-item label="工商营业执照迁出" prop="yingyezhizhao" required>
                                    <el-radio-group v-model="property.officeList[index].zhizhaoqianchu">
                                        <el-radio label="是"></el-radio>
                                        <el-radio label="否"></el-radio>
                                    </el-radio-group>
                                </el-form-item>

                                <el-row>
                                    <el-col :span="8">
                                        <el-form-item label="退还押金" prop="tuiyajin" required>
                                            <el-input v-model="property.officeList[index].tuihuanyajin" placeholder="请输入退还押金"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-form-item label="退还剩余房租" prop="tuihuanfangzu" required>
                                            <el-input v-model="property.officeList[index].tuihuanfangzu" placeholder="请输入退还剩余房租"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-col :span="8">
                                    <el-form-item label="应收杂费" prop="yingshouzafei" required>
                                        <el-input v-model="property.officeList[index].yingshouzafei" placeholder="请输入租户应交杂费"></el-input>
                                    </el-form-item>
                                </el-col>
                            <div style="margin-left:-50px;">
                                <el-button type="primary" v-show="!reviewVisible" @click="save" style="margin-top:100px;">保&nbsp;&nbsp;&nbsp;存</el-button>
                                <el-button v-if="btnShow" @click="review" style="margin-top:100px;">提&nbsp;&nbsp;&nbsp;交</el-button>
                                <el-button v-if="btnShow" type="warning" @click="cancel" style="margin-top:100px;">取&nbsp;&nbsp;&nbsp;消</el-button>
                            </div>
                        </el-form>
                    </div>
                </div>
            <!--</el-row>-->
        </div>
    </div>
</template>
<script>
    import {getLoupanList,getLoudongList,getFanghaoList,jieyueSaleContract,addSaleJieyueContractInfo,jieyuewanSaleContract} from '../../api/api';
    export default {
        components:{

        },
        data() {
            return {
                btnShow:true,
                /*purchaseContract:{
                    type:0,
                },*/
                jieyueRules : {
                    newbiaohao: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ], jiefangshi: [
                        {required: true, message: '不能为空'}
                    ], zhongzhidata: [
                        {required: true, message: '不能为空'}
                    ], yingyezhizhao: [
                        {required: true, message: '不能为空'},

                    ], tuiyajin: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ], tuihuanfangzu: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ], yingshouzafei: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ],
                },
                property:{
                    officeList: [{
                        /*omcId:null,
                        loupanOmcId:null,
                        loudongOmcId:null,*/
                        loupanName:null,
                        loudongName:null,
                        fanghao:null,
                        yuanhetongbiaohao: null,
                        jieyuefangshi:'退租',
                        zhongzhidate:'',
                        jiaofangdate:'',
                        zhizhaoqianchu:'',
                        tuihuanyajin:'',
                        tuihuanfangzu:'',
                        yingshouzafei:'',
                        xinbianhao: null,
                        hetongid:null,
                    }],
                },
                //楼盘数据
                /*options1:[],
                list1: [],
                loupanloading: false,
                estate: [],//服务器搜索的楼盘数据放入这个数组中
                // 楼栋数据
                options2:[],
                list2: [],
                loudongloading: false,
                building: [],//服务器搜索的楼盘数据放入这个数组中
                // 房间数据
                options3:[],
                list3: [],
                fanghaoloading: false,
                house: [],//服务器搜索的楼盘数据放入这个数组中
                houseData:[],*/
                //房间类型
                /*options: [
                    {
                        value: 0,
                        label: '请选择'
                    },{
                        value: 1,
                        label: '公寓'
                    }, {
                        value: 2,
                        label: '写字楼'
                    }, {
                        value: 3,
                        label: '商铺'
                    }, {
                        value: 4,
                        label: '住宅'
                    }
                ],*/
                //房源数据初始化

                editableTabsValue2: '1',
                editableTabs2: [{
                    title: '',
                    name: '1',
                    content: ''
                }],
                /*tabIndex: 1,*/
            }
        },
        methods: {
            save:function () {
                this.btnType = false;
                this.submsg  = '提交';
                var loupanName = document.getElementById("loupanName").innerHTML;
                var loudongName = document.getElementById("loudongName").innerHTML;
                var fanghao = document.getElementById("fanghao").innerHTML;
                var biaohao = document.getElementById("biaohao").innerHTML;

                var child_property = this.property;
                //var child_renter  = this.$refs.renter.renter;
                //var child_date = this.$refs.date.addDate;
                var id = {
                    id: this.id
                };
                /*var bianhao = {
                    bianhao: this.bianhao,
                };*/
                let para = Object.assign({}, child_property,loupanName,loudongName,fanghao,biaohao,id);
                alert(para);
                addSaleJieyueContractInfo(para).then((res) => {
                    if(res.data.code == 200)　{
                        this.fuzhi(res);
                        this.$message({
                            message: '保存成功',
                            type: 'success'
                        });
                    } else {
                        this.$message({
                            message: res.data.msg,
                            type: 'error'
                        })
                    }

                });
            },
            review(){
                //alert(111);
                //this.btnType = false;
                //this.submsg  = '提交';
                //var child_property = this.$refs.property.property;//
                //var child_owner  = this.$refs.owner.owner;//业主信息
                //alert(child_date);
                /*var tiaokuan = {
                    tiaoList:this.$refs.tiaokuan.tiaoList,
                };//条款*/
                var loupanName = document.getElementById("loupanName").innerHTML;
                var loudongName = document.getElementById("loudongName").innerHTML;
                var fanghao = document.getElementById("fanghao").innerHTML;
                var biaohao = document.getElementById("biaohao").innerHTML;
                var child_property = this.property;
                var id = {
                    id: this.id
                };
                alert(id);
                let para = Object.assign({}, child_property,loupanName,loudongName,fanghao,biaohao,id);
                /*jieyuewanSaleContract(para).then((res)=>{
                });*/
                jieyueSaleContractInfo(para).then((res) => {
                    if(res.data.code=='200'){
                        this.$route.push('/saleContract');
                    }
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
            fuzhi(res){
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
            },
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
                var textArea = document.getElementsByTagName('textarea');
                for (let i=0; i<allInputs.length; i++){
                    allInputs[i].disabled="true";
                    allInputs[i].parentNode.className += " is-disabled";
                }
                for (let i=0; i<textArea.length; i++){
                    textArea[i].disabled="true";
                    textArea[i].parentNode.className += " is-disabled";
                }

            },
        },
        mounted() {
            fuzhi(res);
            if(this.$route.query.id!=null){
                this.getJieyueSaleContract(this.$route.query);
            }
            //页面input禁用
            /*if(this.$route.path=='/saleContract/checkJieyue'){
                this.disabledInput();
                this.btnShow=false;
            }*/
        }

    }
</script>