
<template>
    <el-row >
        <el-form   :inline="true" :model="filters"  class="demo-form-inline">
            <el-row>
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
            <el-form-item label="经营属性："    >
                    <el-select v-model="filters.gongsijingyingshuxing" placeholder="请选择经营属性">
                        <el-option
                                v-for="item in optionsgssx"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
            </el-form-item>
            <el-form-item label="协议等级："   >
                    <el-select v-model="filters.hezuoxieyidengji" placeholder="请选择协议等级">
                        <el-option
                                v-for="item in optionsxydj"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-row>
            <el-row>


            <el-form-item label="公司名称：">
                <el-input v-model="filters.pname" placeholder="请输入公司名称"></el-input>
            </el-form-item>
            <el-form-item label="门店名称：">
                <el-input v-model="filters.bk_name" placeholder="请输入公司名称"></el-input>
            </el-form-item>
            <el-form-item label="项目名称：">
                <el-input v-model="filters.xm" placeholder="请输入项目名称"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getBrokerCompany">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" v-if="fun('brokerCompanyAdd')"    @click="handleAdd"    > 新增</el-button>
                <el-button type="primary" class="el-icon-plus" v-if="fun('brokerCompanyExport')"    @click="handleExport"    > 导出</el-button>
            </el-form-item>
        </el-row>
        </el-form>
        <el-table :data="brokerCompany"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="compayname" label="门店名称"  >
            </el-table-column>
            <el-table-column label="公司所属业务区域"  :formatter="changeywqy" width="200px">
            </el-table-column>
            <el-table-column prop="zhuzuoqvyv" label="主做区域"  :formatter="formatZZQY"  >
            </el-table-column>
            <el-table-column prop="hezuoxieyidengji" label="渠道等级"    >
            </el-table-column>
            <el-table-column prop="fuzeren" label="负责人姓名"     >
            </el-table-column>
            <el-table-column prop="yslianxiren1" label="幼狮对接人"    >
            </el-table-column>
            <el-table-column prop="shifouhezuoxieyi" label="是否签署协议"   :formatter="formatSFQSXY"  >
            </el-table-column>
            <el-table-column prop="genjinDate" label="最后跟进日期"  :formatter="changeDate"   >
            </el-table-column>
            <el-table-column prop="wanchengdu" label="信息完整度"  >
            </el-table-column>
            <el-table-column prop="zhuangtai" label="渠道状态"  >
                <template slot-scope="scope">
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
                <template slot-scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item v-if="fun('brokerCompanyEdit')" >  <el-button   @click="handleEdit(scope.$index, scope.row)">跟进/编辑</el-button> </el-dropdown-item>
                            <el-dropdown-item v-if="fun('brokerCompanyView')">  <el-button   @click="handleView(scope.$index, scope.row)">详&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;情</el-button> </el-dropdown-item>
                            <el-dropdown-item v-if="fun('queryUser')">  <el-button    @click="handleUser(scope.$index, scope.row)">查看渠道人员</el-button> </el-dropdown-item>
                            
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
                    :page-sizes="pageSizes"
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
        getBrokerCompanyListPage,
        editBrokerCompany,
        removeBrokerCompany,
        addBrokerCompany,
        checkbkNameList,
        changeBrokerCompanyStatus,
        getGSSXDicList,
        getYWQYDicList,
        getXYDJDicList,
        exportBrokerCompany
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";

    export default{

        components: {ElRow},
        data(){

            return {
                filters:{
                    bk_name:'',
                    yewuqvyvid:0,
                    yewupianqvid:0,
                    gongsijingyingshuxing:'',
                    hezuoxieyidengji:'',
                    xm:'',
                    pname:'',
                    parentid:-1,
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
                optionsdtqy:[{
                    value: 0,
                    label: '请选择'
                },
                ],
                optionsgssx:[
                    {
                        value:'',
                        label: '请选择'
                    },
                ],
                optionsywqy:[
                    {
                        value: 0,
                        label: '请选择'
                    },
                ],
                optionsxydj:[
                    {
                        value: '',
                        label: '请选择'
                    },
                ],
                value1: null,
                //分页类数据
                total:0,
                currentPage:0,
                dialogImageUrl: '',
                dialogVisible: false,

                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                brokerCompany:[],
                listLoading: false,
                sels: [],//列表选中列

                tQdCompayId:0,
                bk_name:'',
                //被选中的权限
                checked:[],
            }
        },
        methods:{
            //佣金类型显示转换
            formatSFQSXY: function (row, column) {
               return row.shifouhezuoxieyi == true ? '是' :  '否' ;
            },
            changeywqy(row, column){
                if(row.yewuqvyv!=null) {
                    return  row.yewuqvyv + '-' + row.yewupianqv ;
                }
            },
            //时间戳转日期格式
            changeDate(row, column){
                if(row.genjinDate!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.genjinDate);
                    return newDate.toLocaleDateString()
                }
            },
            formatZZQY(row, column){
                if(row.zhuzuoqvyv!=null&&row.zhuzuoqvyv!='') {
                    return row.zhuzuoqvyv.substring(row.zhuzuoqvyv.length - 1) == ',' ? row.zhuzuoqvyv.substring(0, row.zhuzuoqvyv.length - 1) : row.zhuzuoqvyv;
                }
            },
            handleView: function (index, row) {
                this.$router.push('/brokerCompany/view?id=' + row.tQdCompayId);
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
               // console.log(`当前页: ${val}`);
               this.getBrokerCompany();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                //console.log(`每页 ${val} 条`);

                this.getBrokerCompany();
            },
            //更改渠道公司状态
            changeStatus(row){
                let para ={
                    id:row.tQdCompayId.toString(),
                    status:row.zhuangtai,
                }
                console.log(para);
                changeBrokerCompanyStatus(para).then((res)=>{
                    console.log(para);
                    if (res.data.code == 200) {
                        var msg ='';
                        if(row.zhuangtai==1){
                            msg='启用成功';
                        }else{
                            msg='停用成功';
                        }
                        this.$message({
                            message:msg,
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
            //获取公司属性
            remoteMethodgssx() {
                getGSSXDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsgssx.push({
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
                this.optionsdtqy = [{
                    value: 0,
                    label: '请选择'
                },];
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
            //获取协议等级
            remoteMethodXYDJ() {
                //this.optionsxydj = [];
               // this.filters.hezuoxieyidengji = null;//清除街道的缓存
                getXYDJDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsxydj.push({
                                value: res.data.data[item].enumValue,
                                label: res.data.data[item].enumKey,
                                yjvalue: parseFloat(res.data.data[item].enumValues)
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
            //获取渠道公司列表
            getBrokerCompany() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name,
                    yewuqvyvid: this.filters.yewuqvyvid,
                    yewupianqvid: this.filters.yewupianqvid,
                    gongsijingyingshuxing: this.filters.gongsijingyingshuxing.toString(),
                    hezuoxieyidengji: this.filters.hezuoxieyidengji,
                    xm:this.filters.xm,
                    parentid:-1,
                    pname:this.filters.pname,
                };
                this.listLoading = true;
                getBrokerCompanyListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompany = res.data.data;
                    this.listLoading = false;
                });
            },
            //查看渠道人员
            handleUser: function (index, row) {
                this.$router.push('/brokerCompanyUserList?id=' + row.tQdCompayId+'&name='+row.compayname);
            },
            //上传协议
            handleUpload: function (index, row) {
                this.$router.push('/brokerCompany/edit?id=' + row.tQdCompayId);
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.$router.push('/brokerCompany/edit?id=' + row.tQdCompayId);
            },
            //显示新增界面
            handleAdd: function () {
                this.$router.push('/brokerCompany/add');
            },
            handleExport: function () {
                window.open("/brokerCompany/ExportExcel?bk_name="+this.filters.bk_name  +"&yewuqvyvid="+this.filters.yewuqvyvid+"&yewupianqvid="+this.filters.yewupianqvid
                    +"&gongsijingyingshuxing="+this.filters.gongsijingyingshuxing+"&xm="+this.filters.xm+"&hezuoxieyidengji="+this.filters.hezuoxieyidengji);
            },
            selsChange: function (sels) {
                this.sels = sels;
            },

            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            }
        },


        mounted() {
            this.remoteMethodgssx();
            this.remoteMethodywqy();
            this.remoteMethodXYDJ();
            this.page=1;
            this.getBrokerCompany();

        }
    }
</script>
