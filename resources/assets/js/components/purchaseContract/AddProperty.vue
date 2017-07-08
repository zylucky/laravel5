<template>
    <div>
    <el-row class="container">
            <el-tabs v-model="editableTabsValue2" type="card" closable @tab-remove="removeTab">
                <el-button v-show="editVisible"
                        size="small"
                        @click="addTab(editableTabsValue2)"
                >
                    添加房源
                </el-button>
                <el-tab-pane
                        v-for="(item, index) in editableTabs2"
                        :key="item.name"
                        :label="item.title"
                        :name="item.name"
                >
                    <el-form label-Weizhi="right" :rules="editFormRules" label-width="100px" :model="property.officeList[index]">
                        <el-col :span="24">
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="楼盘" prop="loupanName">
                                        <el-select
                                                v-model="property.officeList[index].loupanName"
                                                filterable
                                                default-first-option
                                                remote
                                                @change="change1"
                                                placeholder="楼盘"
                                                :remote-method="remoteMethod1"
                                                :loading="loupanloading">
                                            <el-option
                                                    v-for="item in options1"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.label">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="楼栋" prop="loudongName" >
                                        <el-select
                                                v-model="property.officeList[index].loudongName"
                                                filterable
                                                default-first-option
                                                remote
                                                @change="change2"
                                                placeholder="楼栋"
                                                :remote-method="remoteMethod2"
                                                :loading="loupanloading">
                                            <el-option
                                                    v-for="item in options2"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.label">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="房间号" prop="fanghao">
                                        <el-select
                                                v-model="property.officeList[index].fanghao"
                                                filterable
                                                default-first-option
                                                remote
                                                @change="change3"
                                                placeholder="房间号"
                                                :remote-method="remoteMethod3"
                                                :loading="fanghaoloading">
                                            <el-option
                                                    v-for="item in options3"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.label">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="区域" prop="quyu">
                                        <el-input v-model="property.officeList[index].quyu"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="16">
                                    <el-form-item label="位置" prop="weizhi" :span="10">
                                        <el-input v-model="property.officeList[index].weizhi"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>

                            <el-form-item label="产权证编号" prop="chanquanzhenghao">
                                <el-input v-model="property.officeList[index].chanquanzhenghao"></el-input>
                            </el-form-item>
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="承租面积" prop="jianzhumianji" >
                                        <el-input v-model="property.officeList[index].jianzhumianji"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="签约面积" prop="qianyuemianji">
                                        <el-input v-model="property.officeList[index].qianyuemianji"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="房屋类型" prop="leixing">
                                        <el-select v-model="property.officeList[index].leixing" clearable placeholder="请选择">
                                            <el-option
                                                    v-for="item in options"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="抵押权人">
                                        <el-radio-group v-model="property.officeList[index].isdiya">
                                            <el-radio :label="1">是</el-radio>
                                            <el-radio :label="2">否</el-radio>
                                        </el-radio-group>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="抵押权人" prop="diyaquanren">
                                        <el-input v-model="property.officeList[index].diyaren"></el-input>
                                    </el-form-item>
                                </el-col>

                            </el-row>


                        </el-col>
                    </el-form>

                </el-tab-pane>
            </el-tabs>
    </el-row>
    </div>

</template>
<script>
    import {getLoupanList,getLoudongList,getFanghaoList} from '../../api/api';
    export default {
        components:{

        },
        props:['property'],
        data() {
            return {
                purchaseContract:{
                    type:0,
                },
                editVisible:true,
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
                options: [
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
                    ],
                //房源数据初始化

                editableTabsValue2: '1',
                editableTabs2: [{
                    title: '房间1',
                    name: '1',
                    content: 'Tab 1 content'
                }],
                tabIndex: 1,
                editFormRules: {
                    loupanName: [
                        { required: true, message: '请输入姓名', trigger: 'blur' }
                    ],
                    loudongName:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    fanghao:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    quyu:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    weizhi:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    chanquanzhenghao:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    jianzhumianji:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    leixing:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ],
                    qianyuemianji:[
                        { required: true, message:'不能为空',trigger:'blur' }
                    ]
                },
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
            //得到房间号以后，提取OMC的对应信息
            change1(){
                //楼盘
                for (var x in this.options1){
                    if(this.options1[x].label==this.property.officeList[this.tabIndex-1].loupanName){
                        this.property.officeList[this.tabIndex-1].loupanOmcId=this.options1[x].value;
                    }
                }
            },
            change2(){
                //楼栋
                for (var x in this.options2){
                    if(this.options2[x].label==this.property.officeList[this.tabIndex-1].loudongName){
                        this.property.officeList[this.tabIndex-1].loudongOmcId=this.options2[x].value;
                    }
                }
            },
            change3(){
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
            },
            addTab(targetName) {
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
                    weizhi: '东区',
                    chanquanzhenghao: '8345',
                    jianzhumianji: '83.5',
                    qianyuemianji: '83.5',
                    leixing: 0,
                    quyu:'',
                    isdiya:0,
                    diyaren:'',
                });
                this.editableTabsValue2 = newTabName;
            },
            removeTab(targetName) {
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
            }
        },
        mounted() {
            //审核页面input禁用
            if(this.$route.path=='/purchaseContract/review'){
                this.editVisible   =false;
            }
            if(this.$route.path=='/purchaseContract/view'){
                this.editVisible   =false;
            }
        }

    }
</script>