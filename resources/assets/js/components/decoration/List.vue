
<template>
    <el-row >
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.name" placeholder="请输入工长姓名"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-select v-model="filters.status" placeholder="请选择合同状态">
                    <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getDecoration">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="handleAdd"> 新增</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="decoration" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="bianhao" label="编号"  sortable>
            </el-table-column>
            <el-table-column prop="gongzhangname" label="工长姓名"  sortable>
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态"  :formatter="formatStatus" sortable>
            </el-table-column>
            <el-table-column prop="qianyuedate" label="签约日" :formatter="changeDate"  sortable>
            </el-table-column>
               <el-table-column label="操作" width="140">
                    <template scope="scope">
                        <el-dropdown   menu-align="start">
                            <el-button type="primary" size="normal" splitButton="true">
                                操作<i class="el-icon-caret-bottom el-icon--right"></i>
                            </el-button>
                            <el-dropdown-menu slot="dropdown" >
                                <el-dropdown-item  v-if="ztin(scope.row,[0])" ><el-button @click="handleEdit(scope.$index, scope.row)">编辑</el-button></el-dropdown-item>
                                <el-dropdown-item  v-if="ztin(scope.row,[0,2])" ><el-button @click="handleDump(scope.$index, scope.row)">打印</el-button></el-dropdown-item>
                                <el-dropdown-item  v-if="ztin(scope.row,[1])" ><el-button @click="handleConfirm(scope.$index, scope.row)">签约完成</el-button></el-dropdown-item>
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
        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="120px" :rules="addFormRules" ref="editForm">
                <el-form-item label="工长姓名" prop="gongzhangname">
                    <el-input v-model="editForm.gongzhangname" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="签约日期" prop="qianyuedate">
                    <el-date-picker type = "date" placeholder="结束时间"  v-model="editForm.qianyuedate" >
                    </el-date-picker>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="120px" :rules="addFormRules" ref="addForm">
                <el-form-item label="姓名" prop="gongzhangname">
                    <el-input v-model="addForm.gongzhangname" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="签约日期" prop="qianyuedate">
                    <el-date-picker v-model="addForm.qianyuedate"  type = "date" placeholder="结束时间"  >
                    </el-date-picker>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
            </div>
        </el-dialog>

    </el-row>
</template>
<script>

    import {
        statusDecoration,//改变状态接口
        getDecorationList,//列表
        getDecorationDetail,//详情
        submitDecoration,//提交
        storeDecoration,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    name:'',
                    status:'',
                },
                options:[
                    {
                        value: 0,
                        label: '等待打印'
                    }, {
                        value: 1,
                        label: '正在确认'
                    },
                    {
                        value: 2,
                        label: '已确认'
                    },
                ],
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                decoration:[],
                listLoading: false,
                sels: [],//列表选中列
                bkNameloading: false,
                options1:[],
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                addFormRules: {

                },
                //编辑界面数据
                editForm: {
                    gongzhangname:'',
                    qianyuedate:'',
                },
                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                //新增界面数据
                addForm: {
                    gongzhangname:'',
                    qianyuedate:'',
                },
                //被选中的权限
                checked:[],
            }
        },
        methods:{
            //佣金类型显示转换
            formatStatus: function (row, column) {
                let status = [];
                status[0] = '等待打印';
                status[1] = '正在确认';
                status[2] = '已签约';
                return status[row.zhuangtai];
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.qianyuedate);
                if(row.qianyuedate!=null){
                    return newDate.toLocaleDateString()
                }
            },
            ztin(row,arr){
                var status = arr.indexOf(row.zhuangtai);
                if(status>-1){
                    return true;
                }else{
                    return false;
                }
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getDecoration();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getDecoration();
            },
            //获取合同列表
            getDecoration() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    name: this.filters.name,
                    status:this.filters.status,
                };
                this.listLoading = true;
                getDecorationList(para).then((res) => {
                    this.total = res.data.total;
                    this.decoration = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
                this.editForm.gongzhangname= row.gongzhangname;
                this.editForm.id= row.id;
                this.editForm.qianyuedate= row.qianyuedate.toString();
            },
            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            let para = Object.assign({}, this.editForm);
                            para.id = this.editForm.id;
                            submitDecoration(para).then((res) => {
                                this.editLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getDecoration();
                            });
                        });
                    }
                });
            },
            //新增
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            let para = Object.assign({}, this.addForm);
                            storeDecoration(para).then((res) => {
                                this.addLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['addForm'].resetFields();
                                this.addFormVisible = false;
                                this.getDecoration();
                            });
                        });
                    }
                });
            },
            //打印
            handleDump(index,row){
                let para = {
                    id:row.id,
                    status:1,
                }
                statusDecoration(para).then((res)=>{
                    if(res.data.code=="200"){
                        this.getDecoration();
                        window.open('/#/purchaseContract/dump?id='+row.id)
                    }
                });
            },
            handleConfirm(index,row){
                let para = {
                    id:row.id,
                    status:2,
                }
                this.$confirm('合同状态将更为签约完成?', '提示', {
                    type: 'warning'
                }).then(() => {
                    statusDecoration(para).then((res)=>{
                        if(res.data.code=="200"){
                            this.getDecoration();
                        }
                    });
                });
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.getDecoration();
        }
    }
</script>
