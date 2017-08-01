
<template>
    <el-row >
        <el-form :inline="true" :model="filters" class="demo-form-inline">

            <el-form-item label="公司名称：">
                <el-input v-model="filters.bk_name" placeholder="请输入公司名称"></el-input>
            </el-form-item>
            <el-form-item label="所在楼盘："   >
                <el-input v-model="filters.buildingname" placeholder="请输入所在楼盘"></el-input>
            </el-form-item>
            <el-form-item label="渠道等级："    >
                <el-select v-model="filters.qvdaodengji" placeholder="请选择渠道等级"  >
                    <el-option
                            v-for="item in optionsqddj"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <br/>
            <el-form-item label="最后跟进日期：">
            <el-date-picker type="date" placeholder="最后跟进日期" v-model="filters.startdate">
            </el-date-picker>
            <el-date-picker type="date" placeholder="至" v-model="filters.enddate">
            </el-date-picker>
            </el-form-item>
            <el-form-item label="渠道姓名：">
                <el-input v-model="filters.bk_username" placeholder="请输入渠道人员姓名"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getBrokerCompanyUser">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="handleAdd"> 新增</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="brokerCompanyUser" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="qdPername" label="姓名"  >
            </el-table-column>
            <el-table-column prop="zhiwu" label="职务"  >
            </el-table-column>
            <el-table-column prop="telList.0.dianhua" label="联系电话"  >
            </el-table-column>
            <el-table-column prop="qvDaoCompayXinxi.compayname" label="公司名称"  >
            </el-table-column>
            <el-table-column prop="qvDaoCompayXinxi.gsLoupan" label="公司所在楼盘"  >
            </el-table-column>
            <el-table-column prop="qvdaodengji" label="渠道等级"   >
            </el-table-column>
            <el-table-column prop="genjinDate" label="最后跟进日期"  :formatter="changeDate">
            </el-table-column>
            <el-table-column prop="wanchengdu" label="信息完整度"  >
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态"  >
                <template scope="scope">
                    <el-switch
                            v-model="scope.row.zhuangtai"
                            on-color="#13ce66"
                            off-color="#ff4949"
                            :on-value=1
                            :off-value=0
                            @change="changeStatus(scope.row)"
                    >
                    </el-switch>
                </template>
            </el-table-column>
               <el-table-column label="操作" width="150">
                   <template scope="scope">
                       <el-dropdown   menu-align="start">
                           <el-button type="primary" size="normal" splitButton="true">
                               操作<i class="el-icon-caret-bottom el-icon--right"></i>
                           </el-button>
                           <el-dropdown-menu slot="dropdown" >
                               <el-dropdown-item  >  <el-button v-if="scope.row.zhuangtai==1"   @click="handleEdit(scope.$index, scope.row)">跟进/编辑</el-button> </el-dropdown-item>
                               <el-dropdown-item  >  <el-button   @click="handleView(scope.$index, scope.row)">详&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;情</el-button> </el-dropdown-item>
                           </el-dropdown-menu>
                       </el-dropdown>

                   </template>
               </el-table-column>
           </el-table>
           <div style="margin-top:30px"></div>
           <!-- 分页-->
        <el-col :span="24" class="toolbar" >

            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-size="10"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right"
            >
            </el-pagination>
        </el-col>


    </el-row>
</template>
<script>

    import {
        getBrokerCompanyUserListPage,
        editBrokerCompanyUser,
        removeBrokerCompanyUser,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
        changeBrokerCompanyUserStatus,
        getQDDJDicList,
       // getUserNameByID,


    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    bk_name:this.$route.query.name!=null?this.$route.query.name:'',
                    bk_username:'',
                    startdate:'',
                    enddate:'',
                    buildingname:'',
                    qvdaodengji:''
                },


                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                brokerCompanyUser:[],
                estate: [],//服务器搜索的渠道公司数据放入这个数组中
                listLoading: false,
                sels: [],//列表选中列
                bkNameloading: false,
                options1:[],
                optionsqddj:[  ],


                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    tQdCompayId:[
                        { required: true,validator:(rule,value,callback)=>{
                            if(value==''){
                               callback(new Error('输入渠道公司名称' ));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    qdPername: [
                        { required: true, message: '请输入渠道公司人员姓名', trigger: 'blur' }
                    ],
                    qdPertel: [
                        { required: true, message: '请输入人员电话', trigger: 'blur' }
                    ],
                    yjzbSf: [
                        { type: 'number', message: '收房佣金占比不能为空且必须为数字',trigger: 'blur' },
                        {required: true,validator:(rule,value,callback)=>{
                            if(value>1||value<0){
                                callback(new Error("收房佣金占比只能是0到1之间的数"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    yjzbCf: [
                        { type: 'number', message: '出房佣金占比不能为空且必须为数字',trigger: 'blur'},
                        {required: true,validator:(rule,value,callback)=>{
                            if(value>1||value<0){
                                callback(new Error("出房佣金占比只能是0到1之间的数"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    yjType: [
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error("请输入佣金类型"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                },
                //编辑界面数据
                editForm: {
                    //compayname: '',
                    tQdCompayId:'',
                    qdPername:'',
                    qdPertel:'',
                    yjzbSf:'',
                    yjzbCf:'',
                    yjType:'',
                },
                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    tQdCompayId:[
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error('请输入渠道公司名称'));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    qdPername: [
                        { required: true, message: '请输入渠道公司人员姓名', trigger: 'blur' }
                    ],
                    qdPertel: [
                        { required: true, message: '请输入人员电话', trigger: 'blur' }
                    ],
                    yjzbSf: [
                        { type: 'number', message: '收房佣金占比不能为空且必须为数字',trigger: 'blur' },
                        {required: true,validator:(rule,value,callback)=>{
                            if(value>1||value<0){
                                callback(new Error("收房佣金占比只能是0到1之间的数"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    yjzbCf: [
                        { type: 'number', message: '出房佣金占比不能为空且必须为数字',trigger: 'blur'},
                        {required: true,validator:(rule,value,callback)=>{
                            if(value>1||value<0){
                                callback(new Error("出房佣金占比只能是0到1之间的数"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    yjType: [
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error("请输入佣金类型"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                },
                //新增界面数据
                addForm: {
                    tQdCompayId: '',
                    qdPername:'',
                    qdPertel:'',
                    yjzbSf:'',
                    yjzbCf:'',
                    yjType:1,

                },

                bk_id:0,
                bk_name:'',
                //被选中的权限
                checked:[],
            }
        },
        methods:{

            //时间戳转日期格式
            changeDate(row, column){
                if(row.genjinDate!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.genjinDate);
                    return newDate.toLocaleDateString()
                }
            },
           //获取渠道公司名称
            remoteMethod1(query) {

                let para = {
                    name: query
                };
                this.bkNameloading = true;
                getbkNameList(para).then((res) => {

                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[i]=res.data[i]
                    }
                    this.estate = arr;
                    this.bkNameloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: index, label: item };
                    });
                    if (query !== '') {
                        this.bkNameloading = true;
                        setTimeout(() => {

                            this.bkNameloading = false;
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
            //获取渠道等级
            remoteMethodqddj() {

                getQDDJDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsqddj.push({
                                value: res.data.data[item].enumValue,
                                label: res.data.data[item].enumKey
                            });
                        }

                    } else {
                        this.$message({
                            message: '获取协议等级数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            //更改渠道人员状态
            changeStatus(row){

                let para ={
                    id:row.tQdPersonId.toString(),
                    status:row.zhuangtai==0?0:1,
                }

                changeBrokerCompanyUserStatus(para).then((res)=>{
                    if (res.data.code == 200) {
                        this.$message({
                            message:row.zhuangtai==0? '停用成功': '启用成功',
                            type: 'success'
                        });
                    } else {
                        this.$message({
                            message: res.data.msg,
                            type: 'error'
                        });

                    }
                })
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getBrokerCompanyUser();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getBrokerCompanyUser();
            },
            //获取渠道公司列表
            getBrokerCompanyUser() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name,
                    username: this.filters.bk_username,
                    startdate: this.filters.startdate!=''?this.filters.startdate.toLocaleDateString():'' ,
                    enddate: this.filters.enddate!=''?new Date(this.filters.enddate).toLocaleDateString():'',
                    buildingname: this.filters.buildingname,
                    qvdaodengji: this.filters.qvdaodengji,
                    id:this.$route.query.id!=null?this.$route.query.id:'',
                };
                this.listLoading = true;
                getBrokerCompanyUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompanyUser = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.$router.push( {path: '/brokerCompanyUserList/edit?id=' + row.tQdPersonId });
            },
            //显示新增界面
            handleAdd: function () {
                this.$router.push('/brokerCompanyUserList/add');
            },
            //显示详情页面s
            handleView: function (index, row) {
                this.$router.push({path: '/brokerCompanyUserList/view?id=' + row.tQdPersonId });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;
            this.remoteMethodqddj();
            this.getBrokerCompanyUser();

        }
    }
</script>
