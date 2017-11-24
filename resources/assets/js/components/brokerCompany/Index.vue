<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.bk_name" placeholder="公司名称"></el-input>
                </el-form-item>
                <el-form-item>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getBrokerCompany">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <!--列表页-->
        <el-table :data="brokerCompany" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="compayname" label="公司名称"  >
            </el-table-column>
            <el-table-column prop="createdate" :formatter="changeDate" label="创建时间"  >
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态"  >
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
            <el-table-column label="操作" width="260">
                <template slot-scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)"><i class="el-icon-edit"></i></el-button>
                </template>
            </el-table-column>
        </el-table>
        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="公司名称" prop="compayname">
                    <el-input v-model="editForm.compayname" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="80px" :rules="addFormRules" ref="addForm">
                <el-form-item label="公司名称" prop="compayname">
                    <el-input v-model="addForm.compayname" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
            </div>
        </el-dialog>
        <!-- 分页-->
        <el-col :span="24" class="toolbar">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="pageSizes"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right">
            </el-pagination>
        </el-col>

    </section>
</template>
<style>

</style>
<script>
    import { getBrokerCompanyListPage,addBrokerCompany,editBrokerCompany,changeBrokerCompanyStatus} from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    bk_name:'',
                },
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                brokerCompany:[],
                listLoading: false,
                sels: [],//列表选中列
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    compayname: [
                        { required: true, message: '请输入公司名称', trigger: 'blur' }
                    ],
                },
                //编辑界面数据
                editForm: {
                    id: 0,
                    compayname: '',
                },
                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    compayname: [
                        { required: true, message: '请输入公司名称', trigger: 'blur' }
                    ],
                },
                //新增界面数据
                addForm: {
                    compayname: '',
                    parentid:0,
                },
            }
        },
        methods:{
            roleSubmit: function () {
                this.$confirm('确认提交吗？', '提示', {}).then(() => {
                    this.roleLoading = true;
                    let para = {
                        id:this.userId,
                        value:this.Roles,
                    }
                    setRoleList(para).then((res)=>{
                        this.roleLoading = false;
                        this.$message({
                            message: '保存成功',
                            type: 'success'
                        });
                        this.dialogRoleVisible = false;
                    });
                });
            },
            handleSet(index,row){
                this.userId = row.id;
                this.getTotalRoles();
                this.getRoles();
                this.dialogRoleVisible = true;
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getBrokerCompany();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getBrokerCompany();
            },
            //获取渠道公司列表
            getBrokerCompany() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name,
                    parentid:0,
                    xm:this.filters.xm,
                };
                this.listLoading = true;
                getBrokerCompanyListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompany = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
            },
            //时间戳转日期格式
            changeDate(row, column){
                if(row.createdate!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.createdate);
                    return newDate.toLocaleDateString()
                }
            },
            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
                this.addForm = {
                    compayname: '',
                    parentid: 0,
                };
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.editForm);
                            //para.birth = (!para.birth || para.birth == '') ? '' : util.formatDate.format(new Date(para.birth), 'yyyy-MM-dd');
                            editBrokerCompany(para).then((res) => {
                                this.editLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getBrokerCompany();
                            });
                        });
                    }
                });
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
            //新增
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.addForm);
                            console.log(para)
                            //para.birth = (!para.birth || para.birth == '') ? '' : util.formatDate.format(new Date(para.birth), 'yyyy-MM-dd');
                            addBrokerCompany(para).then((res) => {
                                this.addLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['addForm'].resetFields();
                                this.addFormVisible = false;
                                this.getBrokerCompany();
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
            this.page=1;
            this.getBrokerCompany();
        }
    }
</script>