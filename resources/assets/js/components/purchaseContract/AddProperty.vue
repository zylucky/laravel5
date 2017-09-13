<template>
    <div>
    <el-row class="container">
            <el-tabs v-model="editableTabsValue2" type="card" :editable="editflag" addable @edit="addTab" @tab-remove="removeTab">
                <el-tab-pane
                        v-for="(item, index) in property.editableTabs2"
                        :key="item.name"
                        :label="item.title"
                        :name="item.name"
                >
                    <el-form label-Weizhi="right" ref="propertyForm" :rules="editPropertyRules" label-width="100px" :model="property.officeList[index]">
                        <el-col :span="24">
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="楼盘" required prop="loupanName">
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
                                    <el-form-item required label="楼栋" prop="loudongName" >
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
                                    <el-form-item required label="房间号" prop="fanghao">
                                        <el-select
                                                v-model="property.officeList[index].fanghao"
                                                filterable
                                                allow-create
                                                default-first-option
                                                remote
                                                @change="change3"
                                                :placeholder="gzys"
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
                                    <el-form-item  label="区域" prop="quyu">
                                        <el-input v-model="property.officeList[index].quyu"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="16">
                                    <el-form-item  label="位置" prop="weizhi" :span="10">
                                        <el-input v-model="property.officeList[index].weizhi"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>

                            <el-form-item  label="产权证编号" prop="chanquanzhenghao">
                                <el-input v-model="property.officeList[index].chanquanzhenghao"></el-input>
                            </el-form-item>
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item  label="建筑面积" prop="jianzhumianji"  >
                                        <el-input   v-model.number="property.officeList[index].jianzhumianji"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item  label="承租面积" prop="qianyuemianji">
                                        <el-input  v-model.number="property.officeList[index].qianyuemianji"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item  label="房屋类型" prop="leixing">
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
    import {getLoupanList,getLoudongList,getFanghaoList,createFanghao,getLoudongRules} from '../../api/api';
    export default {
        components:{

        },
        props:['property'],
        data() {
            var checkRule = (rule, value, callback) => {
                    if (!value) {
                        return callback(new Error('年龄不能为空'));
                    }
            };
            return {
                purchaseContract:{
                    type:0,
                },
                gzys:'',
                flag: false,
                editflag: false,
                editPropertyRules :{
                    loupanName: [
                        { required: true, message: '不能为空'}
                    ],
                    loudongName:[
                        { required: true, message:'不能为空'}
                    ],
                    fanghao:[
                        { required: true, message:'不能为空'}
                    ],
//                    quyu:[
//                        { required: true, message:'不能为空'}
//                    ],
//                    weizhi:[
//                        { required: true, message:'不能为空'}
//                    ],
//                    chanquanzhenghao:[
//                        { required: true, message:'不能为空'}
//                    ],
//                    jianzhumianji:[
//                        { required: true, message: '不能为空'},
//                        { type: 'number', message: '必须为数字'},
//                    ],
//                    leixing:[
//                        { required: true, message:'不能为空'}
//                    ],
//                    qianyuemianji:[
//                        { required: true, message:'不能为空'},
//                        { type: 'number', message: '必须为数字'},
//                    ]
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

            }
        },
        methods: {
            valid(){
                var flag  = true;
                var flag1 = true;
                var property =  this.$refs.propertyForm;

                for (let i=0;i<property.length;i++){
                    property[i].validate((valid) => {
                        flag = valid;
                        if(flag==false){
                            flag1 = false;
                        }
                        this.property.flag = flag1;
                    })
                }
            },
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
                    loupanOmcId:this.property.officeList[this.property.tabIndex-1].loupanOmcId,
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
                    lpid: this.property.officeList[this.property.tabIndex-1].loupanOmcId,
                    zdid: this.property.officeList[this.property.tabIndex-1].loudongOmcId,
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
                    if(this.options1[x].label==this.property.officeList[this.property.tabIndex-1].loupanName){
                        this.property.officeList[this.property.tabIndex-1].loupanOmcId=this.options1[x].value;
                        this.property.officeList[this.property.tabIndex-1].loudongName=null;//清除楼栋和房号的缓存
                        this.property.officeList[this.property.tabIndex-1].loudongOmcId=null;//清除楼栋和房号的缓存
                        this.property.officeList[this.property.tabIndex-1].fanghao=null;//清除楼栋和房号的缓存
                        this.property.officeList[this.property.tabIndex-1].omcId=null;//清除楼栋和房号的缓存
                    }
                }
            },
            change2(){
                //楼栋
                for (var x in this.options2){
                    if(this.options2[x].label==this.property.officeList[this.property.tabIndex-1].loudongName){
                        this.property.officeList[this.property.tabIndex-1].loudongOmcId=this.options2[x].value;
                        this.property.officeList[this.property.tabIndex-1].fanghao=null;//清除楼栋和房号的缓存
                        this.property.officeList[this.property.tabIndex-1].omcId=null;//清除楼栋和房号的缓存
                    }
                }
                //get rules of building
                let para ={
                    loudongOmcId:this.property.officeList[this.property.tabIndex-1].loudongOmcId,
                }
                getLoudongRules(para).then((res)=>{
                    this.$notify({
                        title: '提示',
                        message: '创建房间号的规则为'+res.data.data.gzys+'(0代表数字，A代表字母)',
                        duration: 0
                    });
                    this.gzys = res.data.data.gzys;
                })
            },
            change3(){
                if(this.$route.path=='/purchaseContract/add') {
                    this.property.officeList[this.property.tabIndex-1].omcId=null;
                }
                //房号
                for (var x in this.options3){
                    if(this.options3[x].label==this.property.officeList[this.property.tabIndex-1].fanghao){
                        this.property.officeList[this.property.tabIndex-1].omcId=this.options3[x].value;
                    }
                }

                //1.第一步把放号分割，判断每一位是否符合规则
                function checknumber(String){
                    var Letters = "1234567890";
                    var i;
                    var c;
                    for( i = 0; i < String.length; i ++ )   {   //Letters.length() ->>>>取字符长度
                        c = String.charAt( i );
                        if (Letters.indexOf( c ) ==-1)   { //在"Letters"中找不到"c"   见下面的此函数的返回值
                            return true;
                        }
                    }
                    return false;
                }
                function checkString(String){
                    var Letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
                    var i;
                    var c;
                    for( i = 0; i < String.length; i ++ )   {   //Letters.length() ->>>>取字符长度
                        c = String.charAt( i );
                        if (Letters.indexOf( c ) ==-1)   { //在"Letters"中找不到"c"   见下面的此函数的返回值
                            return true;
                        }
                    }
                    return false;
                }
                var fanghao = this.property.officeList[this.property.tabIndex-1].fanghao.split('');
                var house_no = this.property.officeList[this.property.tabIndex-1].fanghao;
                var flag = true;
                this.gzys2 = this.gzys.split('');
                if(this.gzys.length!=0&&this.gzys.length!=house_no.length){
                    flag =false;
                }
                this.gzys2.forEach((property,index)=>{
                    if(property=='A'){
                        if(checkString(house_no[index])){
                            flag = false;
                        }
                    }else if(property=='0') {
                        if(checknumber((house_no[index]))){
                            flag = false;
                        }
                    } else if(property=='-') {
                        if(house_no[index]!='-'){
                            flag = false;
                        }
                    }else if(property=='/') {
                        if(house_no[index]!='/'){
                            flag = false;
                        }
                    }

                })
                if(flag){
                    if(this.property.officeList[this.property.tabIndex-1].omcId==null){

                        let  para = {
                            loupanOmcId:this.property.officeList[this.property.tabIndex-1].loupanOmcId,
                            loudongOmcId:this.property.officeList[this.property.tabIndex-1].loudongOmcId,
                            fanghao:this.property.officeList[this.property.tabIndex-1].fanghao,
                        }
                        createFanghao(para).then((res=>{
                            this.property.officeList[this.property.tabIndex-1].omcId = res.data.data;
                            this.$message({
                                message: '楼盘字典中不存在该房源，已自动创建',
                                type: 'success'
                            });
                        }))
                    }
                    for (var x in this.houseData){
                        if(this.houseData[x].id==this.property.officeList[this.property.tabIndex-1].omcId){
                            this.property.officeList[this.property.tabIndex-1].jianzhumianji=this.houseData[x].fjmj;
                            this.property.officeList[this.property.tabIndex-1].qianyuemianji=this.houseData[x].fjmj;
                        }
                    }
                }else{
                    this.$message({
                        message: '房间号不符合规则！',
                        type: 'error'
                    });
                    //this.property.officeList[this.property.tabIndex-1].fanghao=null;
                }
            },
            addTab(targetName, action) {
                if(action === 'add'){
                let newTabName = ++this.property.tabIndex + '';
                this.property.editableTabs2.push({
                    title: '房间'+this.property.tabIndex,
                    name: newTabName,
                    content: 'New Tab content'
                });

                this.property.officeList.push({
                    omcId:null,
                    loupanOmcId:null,
                    loudongOmcId:null,
                    loupanName:null,
                    loudongName: null,
                    fanghao: null,
                    weizhi: '',
                    chanquanzhenghao: '',
                    jianzhumianji: '',
                    qianyuemianji: '',
                    leixing: 0,
                    quyu:'',
                    isdiya:0,
                    diyaren:'',
                });
                this.editableTabsValue2 = newTabName;
                    if(this.property.editableTabs2.length > 1){
                        this.editflag = true;
                    }
                }
            },
            removeTab(targetName) {
                this.property.officeList.pop();
                let tabs = this.property.editableTabs2;
                /*
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
                */
                let propertys = this.property.officeList ;
                propertys.forEach((property,index)=>{

                })
                tabs = tabs.filter(tab => tab.name !== targetName);
                this.property.editableTabs2 = tabs.map((tab, idx)=>{
                    tab.name = (idx + 1) + '';
                    tab.title = '房间'+ (idx + 1);
                    return tab;
                });
                --this.property.tabIndex;
                if(parseInt(this.editableTabsValue2) > this.property.tabIndex - 1){
                    this.editableTabsValue2 = this.property.editableTabs2[this.property.tabIndex-1].name;
                }

                if(this.property.editableTabs2.length < 2){
                    this.flag = false;
                }
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
            var _this =this;
            function hello() {
                if(_this.property.editableTabs2.length > 1){
                    _this.editflag = true;
                }
            }
            setTimeout(hello,500);


        }

    }
</script>
