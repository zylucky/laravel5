<template>
    <el-row>
        <div style="margin-top:30px"></div>
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.companyname" placeholder="公司"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-input v-model="filters.depname" placeholder="部门"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-input v-model="filters.sondepname" placeholder="子部门"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-input v-model="filters.jobname" placeholder="职位"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-input v-model="filters.name" placeholder="姓名"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-input v-model="filters.username" placeholder="账号"></el-input>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" v-on:click="getUsers">查询</el-button>
                </el-form-item>

            </el-form>
        </el-col>
        <!--列表页-->
        <el-table :data="users" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="name" label="姓名"   sortable>
            </el-table-column>
            <el-table-column prop="namepinyin" label="账号"   sortable>
            </el-table-column>
            <el-table-column prop="companyname" label="公司"  sortable>
            </el-table-column>
            <el-table-column prop="deptname" label="部门"  sortable>
            </el-table-column>
            <el-table-column prop="sondeptname" label="子部门"   sortable>
            </el-table-column>
            <el-table-column prop="jobname" label="职位"   sortable>
            </el-table-column>
            <el-table-column prop="phone" label="联系电话"  sortable>
            </el-table-column>
            <el-table-column prop="created_at" label="最后登陆时间"   sortable>
            </el-table-column>
            <el-table-column prop="addr" label="角色"   sortable>
            </el-table-column>
            <el-table-column label="操作" width="200">
                <template scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)"><i class="el-icon-edit"></i></el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)"><i class="el-icon-delete"></i></el-button>
                    <el-button type="small" size="small" @click="handleSet(scope.$index, scope.row)"><i class="el-icon-setting"></i></el-button>
                </template>
            </el-table-column>
        </el-table>

        <!-- 分页-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="pageSizes"
                    :page-size="10"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right">
            </el-pagination>
        </el-col>
        <!--设置角色-->
        <el-dialog title="设置" :visible.sync="dialogRoleVisible">
                <el-select
                        v-model="Roles"
                        multiple
                        filterable
                        remote
                        placeholder="请输入关键词"
                        :remote-method="remoteMethod"
                        :loading="roleLoading">
                    <el-option
                            v-for="item in options4"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="dialogRoleVisible = false">取消</el-button>
                <el-button type="primary" @click.native="roleSubmit" :loading="roleLoading">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>
<script>
    import { getUserListPage, getTotalRoleList,getRoleList,setRoleList} from '../../api/api';

    export default{
        data(){
            return {
                filters:{
                    name:'',
                    companyname:'',
                    depname:'',
                    sondepname:'',
                    jobname:'',
                    username:'',
                },
                //分页类数据
                total:15,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                users:[],
                listLoading: false,
                sels: [],//列表选中列


                //角色参数
                userId:0,
                dialogRoleVisible:false,//设置角色的框是否显示
                Roles:[],//选中后的角色
                options4:[],
                roleLoading:false,
                states: [],
                list: [],
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
            remoteMethod(query) {
                let para = {
                    name: query
                };
                this.roleLoading = true;
                getTotalRoleList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[i]=res.data[i]
                    }
                    this.states = arr;
                    this.roleLoading = false;
                    this.list = this.states.map((item,index) => {
                        return { value: index, label: item };
                    });
                    if (query !== '') {
                        this.roleLoading = true;
                        setTimeout(() => {

                            this.roleLoading = false;
                            this.options4 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options4 = [];
                    }
                });

            },
            handleSet(index,row){
                this.userId = row.id;
                //this.getTotalRoles();
                this.getRoles();
                this.dialogRoleVisible = true;
            },
            //获取当前用户的所有角色
            getRoles() {
                let para = {
                    id:this.userId
                };
                getRoleList(para).then((res) => {
                    let arr = [];
                    for ( var i in res.data ){
                        arr.push(res.data[i])
                    }
                    this.Roles = arr;
                });
            },
            
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getUsers();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getUsers();
            },
            //获取用户列表
            getUsers() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    name: this.filters.name,
                    companyname: this.filters.companyname,
                    depname: this.filters.depname,
                    sondepname: this.filters.sondepname,
                    jobname: this.filters.jobname,
                    username: this.filters.username,
                };
                this.listLoading = true;
                getUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.users = res.data.data;
                    this.listLoading = false;
                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page = 1;
            this.getUsers();
        }
    }
</script>