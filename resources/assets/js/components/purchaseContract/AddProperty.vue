<template>
    <div>
    <el-row class="container">
            <el-tabs v-model="editableTabsValue2" type="card" closable @tab-remove="removeTab">
                <el-button
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
                    <el-form :label-Weizhi="labelWeizhi" label-width="100px" :model="property.officeList[index]">
                        <el-col :span="24">
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="楼盘" >
                                        <el-select
                                                v-model="property.officeList[index].loupanOmcId"
                                                filterable
                                                remote
                                                placeholder="楼盘"
                                                :remote-method="remoteMethod1"
                                                :loading="loupanloading">
                                            <el-option
                                                    v-for="item in options1"
                                                    :key="item.value"
                                                    :label="property.officeList[index].loupanName=item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="楼栋" >
                                        <el-select
                                                v-model="property.officeList[index].loudongOmcId"
                                                filterable
                                                remote
                                                placeholder="楼栋"
                                                :remote-method="remoteMethod2"
                                                :loading="loupanloading">
                                            <el-option
                                                    v-for="item in options2"
                                                    :key="item.value"
                                                    :label="property.officeList[index].loudongName=item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="房间号" >
                                        <el-select
                                                v-model="property.officeList[index].fanghao"
                                                filterable
                                                remote
                                                placeholder="房间号"
                                                :remote-method="remoteMethod3"
                                                :loading="fanghaoloading">
                                            <el-option
                                                    v-for="item in options3"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-form-item label="位置" >
                                <el-input v-model="property.officeList[index].Weizhi"></el-input>
                            </el-form-item>
                            <el-form-item label="产权证编号" >
                                <el-input v-model="property.officeList[index].Chanquanzhenghao"></el-input>
                            </el-form-item>
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="承租面积" >
                                        <el-input v-model="property.officeList[index].Jianzhumianji"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="签约面积" >
                                        <el-input v-model="property.officeList[index].Qianyuemianji"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-form-item label="房屋类型">
                                <el-select v-model="property.officeList[index].Leixing" placeholder="请选择">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>

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
        data() {
            return {
                purchaseContract:{
                    type:0,
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
                //房间类型
                options: [
                    {
                        value: '1',
                        label: '公寓'
                    }, {
                        value: '2',
                        label: '写字楼'
                    }, {
                        value: '3',
                        label: '商铺'
                    }, {
                        value: '4',
                        label: '住宅'
                    }
                    ],
                labelWeizhi: 'right',
                //房源数据初始化
                property:{
                    officeList: [{
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
                        //hetongid:0
                    }],
                },
                editableTabsValue2: '1',
                editableTabs2: [{
                    title: '房间1',
                    name: '1',
                    content: 'Tab 1 content'
                }],
                tabIndex: 1
            }
        },
        methods: {
            //获取楼盘
            remoteMethod1(query) {
                let para = {
                    name: query
                };
                this.loupanloading = true;
                getLoupanList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[i]=res.data[i]
                    }
                    this.estate = arr;
                    this.loupanloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: index, label: item };
                    });
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
            },
            //获取楼栋
            remoteMethod2(query) {
                let para = {
                    name: query,
                    loupanOmcId:this.property[index].officeList
                };
                this.loupanloading = true;
                getLoupanList(para).then((res) => {
                    let arr = [];
                    for ( var i in res.data ){
                        arr.push(res.data[i])
                    }
                    this.building = arr;
                    this.loupanloading = false;
                    this.list2 = this.building.map(item => {
                        return { value: item, label: item };
                    });
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
            },
            //获取房号
            remoteMethod3(query) {
                let para = {
                    name: query
                };
                this.fanghaoloading = true;
                getFanghaoList(para).then((res) => {
                    let arr = [];
                    for ( var i in res.data ){
                        arr.push(res.data[i])
                    }
                    this.house = arr;
                    this.fanghaoloading = false;
                    this.list3 = this.house.map((item,index) => {
                        return { value: item, label: item };
                    });
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
                    Weizhi: '东区',
                    Chanquanzhenghao: '8345',
                    Jianzhumianji: '83.5',
                    Qianyuemianji: '83.5',
                    Leixing: '',
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
        mounted(){
            //楼盘数组
            this.list = this.estate.map(item => {
                return { value: item, label: item };
            });
        }
    }
</script>