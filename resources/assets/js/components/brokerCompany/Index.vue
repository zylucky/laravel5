
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.bk_name" placeholder="渠道公司名称"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getBrokerCompany">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"    @click="handleAdd"    > 新增</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="brokerCompany"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="compayname" label="渠道公司名称"  sortable>
            </el-table-column>
            <el-table-column prop="compaytest" label="渠道公司说明"  sortable>
            </el-table-column>
            <el-table-column prop="yjzbSf" label="收房佣金占比"  sortable>
            </el-table-column>
            <el-table-column prop="yjzbCf" label="出房佣金占比"  sortable>
            </el-table-column>
            <el-table-column prop="yjType" label="佣金类型"  :formatter="formatYJType" sortable>
            </el-table-column>
            <el-table-column prop="tbPersonIdCreate" label="创建人"     sortable>
            </el-table-column>
            <el-table-column prop="createdate" label="创建时间" :formatter="changeDate" sortable>
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item  >  <el-button   @click="handleEdit(scope.$index, scope.row)">编&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;辑</el-button> </el-dropdown-item>
                                <el-dropdown-item  >  <el-button   @click="handleDel(scope.$index, scope.row)">删&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;除</el-button> </el-dropdown-item>
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
        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="120px" :rules="editFormRules" ref="editForm">
                <el-form-item label="渠道公司名称" prop="compayname">
                    <el-input v-model="editForm.compayname" auto-complete="off"   disabled=""></el-input>
                </el-form-item>
                <el-form-item label="收房佣金占比" prop="yjzbSf">
                    <el-input type="number" v-model="editForm.yjzbSf" value="" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="出房佣金占比" prop="yjzbCf">
                    <el-input type="number" v-model="editForm.yjzbCf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="佣金类型"   prop="yjType">
                    <el-select v-model="editForm.yjType" placeholder="">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="渠道公司说明" prop="compaytest">
                    <el-input v-model="editForm.compaytest" auto-complete="off"></el-input>
                </el-form-item>
                <el-input type="hidden" prop="tbPersonIdCreate" v-model="editForm.tbPersonIdCreate" auto-complete="off"></el-input>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="120px" :rules="addFormRules" ref="addForm">
                <el-form-item label="渠道公司名称" prop="compayname">
                    <el-input v-model="addForm.compayname" auto-complete="off"   ></el-input>
                </el-form-item>
                <el-form-item label="收房佣金占比" prop="yjzbSf">
                    <el-input   v-model="addForm.yjzbSf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="出房佣金占比" prop="yjzbCf">
                    <el-input  v-model="addForm.yjzbCf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="佣金类型"    prop="yjType">
                    <el-select type="number"  v-model="addForm.yjType" placeholder="">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="渠道公司说明" prop="compaytest">
                    <el-input v-model="addForm.compaytest" auto-complete="off"></el-input>
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
        getBrokerCompanyListPage,
        editBrokerCompany,
        removeBrokerCompany,
        addBrokerCompany,
        batchRemoveBrokerCompany,
        checkbkNameList,


    } from '../../api/api';

    export default{

        data(){

            return {
                filters:{
                    bk_name:'',
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
                        { required: true, message: '请输入渠道公司名称', trigger: 'blur' },
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
                    tQdCompayId: 0,
                    compayname: '',
                    yjzbSf: '',
                    yjzbCf: '',
                    compaytest:'',
                    yjType:1,
                },
                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    compayname: [
                        { required: true, message: '请输入渠道公司名称', trigger: 'blur'  },
                        {validator:(rule,value,callback)=>{
                            let para = {
                                name: value
                            };
                            if(value!=''){
                                checkbkNameList(para).then((res) => {
                                    //alert( JSON.stringify(res));
                                    if(res.data.code!='200')
                                    {
                                        callback(new Error(res.data.msg));
                                    }else{
                                        callback();
                                    }
                                })
                            }
                        }, trigger:'blur'}
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
                    compayname: '',
                    yjzbSf:'',
                    yjzbCf:'',
                    compaytest:'',
                    yjType:1,
                },

                tQdCompayId:0,
                bk_name:'',
                //被选中的权限
                checked:[],
            }
        },
        methods:{
            //佣金类型显示转换
            formatYJType: function (row, column) {
               return row.yjType == 1 ? '按月租金' : row.yjType == 2 ? '按年租金' : '未知';
            },

            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createdate);
                return newDate.toLocaleDateString()
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
            //获取渠道公司列表
            getBrokerCompany() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name
                };
                this.listLoading = true;
                getBrokerCompanyListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompany = res.data.data;
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
                    let para = { id: row.tQdCompayId };
                   // alert(row.tQdCompayId);
                    removeBrokerCompany(para).then((res) => {
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

                        this.getBrokerCompany();
                    });
                }).catch(() => {

                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
              //  this.editForm.yjType= row.yjType == 1 ? '按月租金' : row.yjType == 2 ? '按年租金' : '未知';
                this.editForm.yjzbCf= row.yjzbCf.toString();
                this.editForm.yjzbSf= row.yjzbSf.toString();

            },
            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
                this.addForm = {
                    compayname: '',
                    yjzbSf:'',
                    yjzbCf:'',
                    compaytest:'',
                    yjType:1,

                };
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            let para = Object.assign({}, this.editForm);
                          //  para.yjType= this.editForm.yjType == '按月租金' ?1 : this.editForm.yjType =='按年租金' ?2 : this.editForm.yjType;

                            editBrokerCompany(para).then((res) => {
                                this.editLoading = false;
                                //alert(JSON.stringify(res));
                                if(res.data.code=='200')
                                {
                                    //alert(0);
                                    this.$message({
                                        message: '提交成功' ,
                                        type:'success'
                                    });
                                }else{
                                    this.$message({
                                        message: res.data.msg ,
                                        type:'error'
                                    });
                                }

                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getBrokerCompany();
                            });
                        });
                    }
                });
            },
            //新增
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                  // alert(valid);
                   // alert(this.addForm.compayname.lazy);
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.addForm);
                           // para.yjType= this.addForm.yjType == '按月租金' ? 1 : 2;
                            //para.birth = (!para.birth || para.birth == '') ? '' : util.formatDate.format(new Date(para.birth), 'yyyy-MM-dd');
                            addBrokerCompany(para).then((res) => {
                                this.addLoading = false;
                                //NProgress.done();
                                if(res.data.code=='200')
                                {
                                    //alert(0);
                                    this.$message({
                                        message: '提交成功' ,
                                        type:'success'
                                    });
                                }else{
                                    this.$message({
                                        message: res.data.msg ,
                                        type:'error'
                                    });
                                }
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
            //批量删除
            batchRemove: function () {
                var ids = this.sels.map(item => item.tQdCompayId).toString();
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { ids: ids };
                   // alert(ids);
                    batchRemoveBrokerCompany(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        if(res=='200')
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
                        this.getBrokerCompany();

                    });
                }).catch(() => {

                });
            }
        },


        mounted() {
            this.page=1;
            this.getBrokerCompany();

        }
    }
</script>
