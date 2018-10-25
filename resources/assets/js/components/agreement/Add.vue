<template>
    <el-form ref="form" :model="agreement" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="协议类型">
                    <el-radio-group v-model="agreement.type">
                        <el-radio label="1">三方</el-radio>
                        <el-radio label="2">两方</el-radio>
                    </el-radio-group>
                </el-form-item>
            </el-col>


        </el-row>
        <el-row>
            <el-col :span="8">
                <el-form-item label="楼盘" required prop="loupanName">
                    <el-select
                            v-model="property.loupanName"
                            filterable
                            default-first-option
                            remote
                            placeholder="楼盘"
                            :remote-method="remoteMethod1"
                            :loading="loupanloading"
                            @change="change1"
                    >
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
                <el-form-item required label="楼栋" prop="loudongName" >
                    <el-select
                            v-model="property.loudongName"
                            filterable
                            default-first-option
                            remote
                            placeholder="楼栋"
                            :remote-method="remoteMethod2"
                            :loading="loupanloading"
                            @change="change2"
                    >
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
                <el-form-item required label="房间号" prop="fanghao">
                    <el-select
                            v-model="property.fanghao"
                            filterable
                            allow-create
                            default-first-option
                            remote
                            :remote-method="remoteMethod3"
                            :loading="loupanloading"
                            @change="change3"
                    >
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

    </el-form>
</template>
<style>

</style>
<script>
    import {getLoupanList,getLoudongList,getFanghaoList,createFanghao,getLoudongRules} from '../../api/api';
    export default{
        data(){
            return {
                agreement:{
                    type:1,
                },
                loupanloading:false,
                property:{
                    loupanName:'',
                    loudongName:'',
                    fanghao:'',
                    loupanOmcId:'',
                    loudongOmcId:'',
                    omcId:'',
                },
                options1:[],
                options2:[],
                options3:[],
                estate:[],
                building:[],
                house:[],
                list:[],
                list2:[],
                list3:[],
            }
        },
        methods:{
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
                        this.options1 = this.list.filter(item => {
                            return item.label.toLowerCase()
                                    .indexOf(query.toLowerCase()) > -1;
                        });
                    } else {
                        this.options1 = [];
                    }
                });

            },
            //获取楼栋
            remoteMethod2(query) {
                let para = {
                    loupanOmcId:this.property.loupanOmcId,
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
                        this.options2 = this.list2.filter(item => {
                            return item.label.toLowerCase()
                                    .indexOf(query.toLowerCase()) > -1;
                        });
                    } else {
                        this.options2 = [];
                    }
                });

            },
            //获取房号
            remoteMethod3(query) {
                let para = {
                    lpid: this.property.loupanOmcId,
                    zdid: this.property.loudongOmcId,
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
                        this.options3 = this.list3.filter(item => {
                            return item.label.toLowerCase()
                                    .indexOf(query.toLowerCase()) > -1;
                        });
                    } else {
                        this.options3 = [];
                    }
                });


            },
            //得到房间号以后，提取OMC的对应信息
            change1(){
                //楼盘
                for (var x in this.options1){
                    if(this.options1[x].label==this.property.loupanName){
                        this.property.loupanOmcId=this.options1[x].value;
                        this.property.loudongName=null;//清除楼栋和房号的缓存
                        this.property.loudongOmcId=null;//清除楼栋和房号的缓存
                        this.property.fanghao=null;//清除楼栋和房号的缓存
                        this.property.omcId=null;//清除楼栋和房号的缓存
                    }
                }
            },
            change2(){
                //楼栋
                for (var x in this.options2){
                    if(this.options2[x].label==this.property.loudongName){
                        this.property.loudongOmcId=this.options2[x].value;
                        this.property.fanghao=null;//清除楼栋和房号的缓存
                        this.property.omcId=null;//清除楼栋和房号的缓存
                    }
                }
            },
            change3(){
                if(this.$route.path=='/purchaseContract/add') {
                    this.property.omcId=null;
                }
                //房号
                for (var x in this.options3){
                    if(this.options3[x].label==this.property.fanghao){
                        this.property.omcId=this.options3[x].value;
                    }
                }
            },
        }
    }
</script>