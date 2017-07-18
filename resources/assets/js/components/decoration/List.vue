
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.name" placeholder="请输入工长姓名1"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-select v-model="status" placeholder="请选择合同状态">
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
            <el-table-column prop="qianyuedate" label="签约日"  sortable>
            </el-table-column>
               <el-table-column label="操作" width="150">
                    <template scope="scope">
                       <el-button size="small" @click="handleEdit(scope.$index, scope.row)"><i class="el-icon-edit"></i></el-button>
                        <el-button type="small" size="small" @click="handleSet(scope.$index, scope.row)"><i class="el-icon-view"></i></el-button>
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
                    <el-date-picker type = "date" placeholder="结束时间" v-model="editForm.qianyuedate" >
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
                    <el-date-picker v-model="addForm.qianyuedate" type = "date" placeholder="结束时间"  >
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
                },
                options:[
                    {
                        value: 1,
                        label: '等待打印'
                    }, {
                        value: 2,
                        label: '正在确认'
                    },
                    {
                        value: 3,
                        label: '已确认'
                    },
                ],
                status:null,
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
                status[1] = '等待打印';
                status[2] = '正在确认';
                status[3] = '已确认';
                return status[row.zhuangtai];
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.qianyuedate);
                return newDate.toLocaleDateString()
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
                };
                this.listLoading = true;
                getDecorationList(para).then((res) => {
                    this.total = res.data.total;
                    this.decoration = res.data.data;
                    this.listLoading = false;
                });
            },
            //删除
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { id: row.tQdPersonId  };
                    removeBrokerCompanyUser(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        if(res.data.code=='200')
                        {
                            this.$message({
                                message: '删除成功',
                                type: 'success'
                            });
                        }else{
                            this.$message({
                                message: res.data.msg,
                                type: 'error'
                            });
                        }
                        this.getDecoration();
                    });
                }).catch(() => {

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
                            console.log(para)
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
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.getDecoration();
        }
    }
</script>
