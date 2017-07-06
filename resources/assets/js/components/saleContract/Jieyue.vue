<template>
    <div>
        <div style="font-size:16px;font-weight:700;position:relative;left:30px;top:20px;">基本信息</div>
        <div style="font-size:14px;position:relative;left:30px;top:20px;">
            <span style="position:relative;left:30px;top:40px;">
                <span>楼盘名称：</span><span>111111</span>
            </span>
            <span style="position:relative;left:460px;top:40px;">
                <span>楼栋：</span><span>22222</span>
            </span>
            <span style="position:relative;left:880px;top:40px;">
                <span>房间号：</span><span>333333</span>
            </span>
            <div style="position:relative;left:15px;top:70px;">
                <span>原合同编号：</span><span>444444</span>
            </div>

                <div v-model="editableTabsValue2" type="card" closable @tab-remove="removeTab" style="position:relative;top:100px;">
                    <div
                            v-for="(item, index) in editableTabs2"
                            :key="item.name"
                            :label="item.title"
                            :name="item.name"
                    >
                        <el-form label-Weizhi="right" label-width="100px" :model="property.officeList[index]">
                                <el-form-item label="新合同编号" >
                                    <el-input v-model="property.officeList[index].newhetongbiaohao" placeholder="请输入新合同编号"></el-input>
                                </el-form-item>
                                <el-form-item label="解约方式">
                                    <el-radio-group v-model="property.officeList[index].jieyuefangshi">
                                        <el-radio label="退租"></el-radio>
                                        <el-radio label="扩租"></el-radio>
                                        <el-radio label="缩租"></el-radio>
                                    </el-radio-group>
                                </el-form-item>
                                <el-row>
                                    <el-col :span="8">
                                        <el-form-item label="合同终止日期">
                                            <el-date-picker type="date" placeholder="请选择合同终止日期" v-model="property.officeList[index].hetongzhongzhiDate" style="width: 100%;"></el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-form-item label="交房日期">
                                            <el-date-picker type="date" placeholder="请选择交房日期" v-model="property.officeList[index].jiaofangDate" style="width: 100%;"></el-date-picker>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-form-item label="工商营业执照迁出">
                                    <el-radio-group v-model="property.officeList[index].zhizhaoqianchu">
                                        <el-radio label="是"></el-radio>
                                        <el-radio label="否"></el-radio>
                                    </el-radio-group>
                                </el-form-item>

                                <el-row>
                                    <el-col :span="8">
                                        <el-form-item label="退还押金">
                                            <el-input v-model="property.officeList[index].tuihuanyajin" placeholder="请输入退还押金"></el-input>
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-form-item label="退还剩余房租">
                                            <el-input v-model="property.officeList[index].tuihuangzujing" placeholder="请输入退还剩余房租"></el-input>
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                <el-col :span="8">
                                    <el-form-item label="应收杂费">
                                        <el-input v-model="property.officeList[index].yingjiaozafei" placeholder="请输入租户应交杂费"></el-input>
                                    </el-form-item>
                                </el-col>
                            <div style="margin-left:-50px;">
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
    import {getLoupanList,getLoudongList,getFanghaoList,jieyueSaleContractInfo,getJieyueSaleContractInfo} from '../../api/api';
    export default {
        components:{

        },
        data() {
            return {
                btnShow:true,
                /*purchaseContract:{
                    type:0,
                },*/
                property:{
                    officeList: [{
                        omcId:null,
                        loupanOmcId:null,
                        loudongOmcId:null,
                        loupanName:null,
                        loudongName:null,
                        fanghao:null,
                        yuanhetongbiaohao: null,
                        jieyuefangshi:'退租',
                        hetongzhongzhiDate:'',
                        jiaofangDate:'',
                        zhizhaoqianchu:'',
                        tuihuanyajin:'',
                        tuihuangzujing:'',
                        yingjiaozafei:'',
                        newhetongbiaohao: null,
                        hetongid:null,
                    }],
                },
                //楼盘数据
                options1:[],
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
                houseData:[],
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
            //获取楼盘
            remoteMethod1(query) {
                let para = {
                    str: query
                };
                this.loupanloading = true;
                getLoupanList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[i]=res.data [i];
                    }
                    this.estate = arr;
                    this.loupanloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: index, label: item };
                    });
                    if (query !== '') {
                        this.loupanloading = true;
                        setTimeout(() => {
                            this.loupanloading = false;
                            this.options1 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options1 = [];
                    }
                });

            },
            //获取楼栋
            remoteMethod2(query) {
                let para = {
                    loupanOmcId:this.property.officeList[this.tabIndex-1].loupanOmcId,
                };
                this.loupanloading = true;
                getLoudongList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[i]=res.data [i];
                    }
                    this.building = arr;
                    this.loupanloading = false;
                    this.list2 = this.building.map((item,index) => {
                        return { value: index, label: item };
                    });
                    if (query !== '') {
                        this.loupanloading = true;
                        setTimeout(() => {
                            this.loupanloading = false;
                            this.options2 = this.list2.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options2 = [];
                    }
                });

            },
            //获取房号
            remoteMethod3(query) {
                let para = {
                    lpid: this.property.officeList[this.tabIndex-1].loupanOmcId,
                    zdid: this.property.officeList[this.tabIndex-1].loudongOmcId,
                };
                this.fanghaoloading = true;
                getFanghaoList(para).then((res) => {
                    this.houseData = res.data;
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[res.data[i].id]=res.data[i].fybh;
                    }
                    this.house = arr;
                    this.fanghaoloading = false;
                    this.list3 = this.house.map((item,index) => {
                        return { value: index, label: item };
                    });
                    if (query !== '') {
                        this.fanghaoloading = true;
                        setTimeout(() => {
                            this.fanghaoloading = false;
                            this.options3 = this.list3.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options3 = [];
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
                var child_date = this.property.officeList;//日期
                var id = {
                    id: this.id
                };
                let para = Object.assign({},child_date,id);
                jieyueSaleContractInfo(para).then((res) => {
                    if(res.data.code == 200)　{
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                });
            },
            //根据url得到的合同ID，来获取数据
            getJieyueSaleContract(id){
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
            },
            cancel(){
                /*window.open('/#/saleContract/dump?id='+row.id)
                window.location.href="./Index.vue";*/
                window.history.back(-1);
            },
            fuzhi(res){
                this.id = res.data.data.id;
                this.property.officeList = res.data.data.officeList;
                //给条款的每一条数据都添加一个属性字段show
                /*for (let x in res.data.data.tiaoList){
                    res.data.data.tiaoList[x].show = false;
                    for (let y in res.data.data.tiaoList[x].kuanList){
                        res.data.data.tiaoList[x].kuanList[y].show = false;
                        for (let z in res.data.data.tiaoList[x].kuanList[y].xiangList){
                            res.data.data.tiaoList[x].kuanList[y].xiangList[z].show = false;
                        }
                    }
                }
                this.tiaoList = res.data.data.tiaoList;*/
            },
            //得到房间号以后，提取OMC的对应信息
            /*change1(){
                //楼盘
                for (var x in this.options1){
                    if(this.options1[x].label==this.property.officeList[this.tabIndex-1].loupanName){
                        this.property.officeList[this.tabIndex-1].loupanOmcId=this.options1[x].value;
                    }
                }
            },*/
            /*change2(){
                //楼栋
                for (var x in this.options2){
                    if(this.options2[x].value==this.property.officeList[this.tabIndex-1].loudongName){
                        this.property.officeList[this.tabIndex-1].loudongOmcId=this.options2[x].value;
                    }
                }
            },*/
            /*change3(){
                //房号
                for (var x in this.options3){
                    if(this.options3[x].label==this.property.officeList[this.tabIndex-1].fanghao){
                        this.property.officeList[this.tabIndex-1].omcId=this.options3[x].value;
                    }
                }
                for (var x in this.houseData){
                    if(this.houseData[x].id==this.property.officeList[this.tabIndex-1].omcId){
                        this.property.officeList[this.tabIndex-1].Jianzhumianji=this.houseData[x].fjmj;
                        this.property.officeList[this.tabIndex-1].Qianyuemianji=this.houseData[x].fjmj;
                    }
                }
//                console.log(
//                    '楼盘'+this.property.officeList[this.tabIndex-1].loupanOmcId
//                    +'楼栋'+this.property.officeList[this.tabIndex-1].loudongOmcId
//                    +'房号'+this.property.officeList[this.tabIndex-1].omcId
//                )
            },*/
            /*addTab(targetName) {
                let newTabName = ++this.tabIndex + '';
                this.editableTabs2.push({
                    title: '房间',
                    name: newTabName,
                    content: 'New Tab content'
                });
                this.property.officeList.push({
                    omcId:null,
                    loupanOmcId:null,
                    loudongOmcId:null,
                    loupanName:'',
                    loudongName: '',
                    fanghao: '',
                    Weizhi: '东区',
                    Chanquanzhenghao: '8345',
                    Jianzhumianji: '83.5',
                    Qianyuemianji: '83.5',
                    Leixing: '',
                });
                this.editableTabsValue2 = newTabName;
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
            /*if(this.$route.query.id!=null){
                this.getJieyueSaleContract(this.$route.query);
            }*/
            //审核页面input禁用
            if(this.$route.path=='/saleContract/checkJieyue'){
                this.disabledInput();
                this.btnShow=false;
            }
        }

    }
</script>