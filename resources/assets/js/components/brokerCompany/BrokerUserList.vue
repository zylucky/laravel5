
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">

            <el-form-item label="业务区域：" >
                <el-select v-model="filters.yewuqvyvid" placeholder="请选择区域"   @change="remoteMethoddtqy">
                    <el-option
                            v-for="item in optionsywqy"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>

            <el-form-item label=""   >
                <el-select v-model="filters.yewupianqvid" placeholder="请选择地图区域">
                    <el-option
                            v-for="item in optionsdtqy"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>

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
                <el-button type="primary" icon="search"  v-on:click="getBrokerUser">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="handleAdd"> 新增</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="brokerUser" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="xingming" label="姓名"  >
            </el-table-column>
            <el-table-column prop="telList.0.dianhua" label="联系电话"  >
            </el-table-column>
            <el-table-column label="公司所属业务区域">
                <el-table-column prop="yewuqvyv"    >
                </el-table-column>
                <el-table-column prop="yewupianqv"    >
                </el-table-column>
            </el-table-column>
            <el-table-column prop="qvdaodengji" label="渠道等级"   >
            </el-table-column>
            <el-table-column prop="genjinDate" label="最后跟进日期"  :formatter="changeDate" >
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
                               <el-dropdown-item  >  <el-button   @click="handleEdit(scope.$index, scope.row)">跟进/编辑</el-button> </el-dropdown-item>
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
        getBrokerUserListPage,
        editBrokerCompanyUser,
        removeBrokerCompanyUser,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
        changeBrokerUserStatus,
        getYWQYDicList,
        getQDDJDicList,
       // getUserNameByID,


    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    bk_username:'',
                    startdate:'',
                    enddate:'',
                    buildingname:'',
                    qvdaodengji:'',
                    yewuqvyvid:'',
                    yewupianqvid:'',
                },
                options:[
                    {
                        value: 1,
                        label: '按月租金'
                    }, {
                        value: 2,
                        label: '按年租金'
                    },
                ],
                options2:[
                    {value: 1, label: '启用'},
                    {value: 2, label: '停用'},
                ],
                optionsdtqy:[
                ],
                optionsqddj:[  {
                    value: '',
                    label: '请选择'
                }],
                optionsywqy:[
                    {
                        value: '',
                        label: '请选择'
                    }
                ],

                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                brokerUser:[],
                estate: [],//服务器搜索的渠道公司数据放入这个数组中
                listLoading: false,
                sels: [],//列表选中列
                bkNameloading: false,
                options1:[],
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

            //更改自由经纪人人员状态
            changeStatus(row){
                let para ={
                    id:row.tQdZyPersonId.toString(),
                    status:row.zhuangtai==0?0:1,
                }

                changeBrokerUserStatus(para).then((res)=>{

                })
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getBrokerUser();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getBrokerUser();
            },


            //获取渠道公司列表
            getBrokerUser() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    username: this.filters.bk_username,
                    yewuqvyvid: this.filters.yewuqvyvid,
                    yewupianqvid: this.filters.yewupianqvid,
                    startdate: this.filters.startdate!=''?this.filters.startdate.toLocaleDateString():'' ,
                    enddate: this.filters.enddate!=''?new Date(this.filters.enddate).toLocaleDateString():'',
                    qvdaodengji: this.filters.qvdaodengji,
                };
                this.listLoading = true;
                getBrokerUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerUser = res.data.data;
                    this.listLoading = false;
                });
            },
            //获取公司业务区域
            remoteMethodywqy() {
                let para = {
                    parentid: 0,
                };
                //this.optionsywqy = [];
                getYWQYDicList(para).then((res) => {

                    if (res.status == '200') {
                        for (var item in res.data.data) {

                            this.optionsywqy.push({value: res.data.data[item].id, label: res.data.data[item].fdName});
                        }
                    } else {
                        this.$message({
                            message: '获取业务区域数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            //获取公司业务区域id获取地图区域列表
            remoteMethoddtqy() {
                let para = {
                    parentid: this.filters.yewuqvyvid,
                };
                this.optionsdtqy = [];
                this.filters.yewupianqvid = null;//清除地图区域的缓存
                getYWQYDicList(para).then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsdtqy.push({value: res.data.data[item].id, label: res.data.data[item].fdName});
                        }
                    } else {
                        this.$message({
                            message: '获取地图区域数据失败',
                            type: 'error'
                        });
                    }
                })
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
                            message: '获取公司属性数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.$router.push( {path: '/brokerUser/edit?id=' + row.tQdZyPersonId});
            },
            //显示新增界面
            handleAdd: function () {
                this.$router.push('/brokerUser/add');
            },
            //显示详情页面s
            handleView: function (index, row) {
                this.$router.push({path: '/brokerUser/view?id=' + row.tQdZyPersonId});
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;
            this.remoteMethodqddj();
            this.remoteMethodywqy();
            this.getBrokerUser();

        }
    }
</script>
