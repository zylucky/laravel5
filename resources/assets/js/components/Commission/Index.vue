
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.contractNo" placeholder="合同编号"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.buildingname" placeholder="楼盘名称"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.buildname" placeholder="楼栋名称"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.roomname" placeholder="房间号"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-select v-model="filters.ZhuangTai" placeholder="状态">
                    <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>

            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getBrokerCompany">搜索</el-button>

            </el-form-item>
        </el-form>
        <el-table :data="brokerCompany"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="50">
            </el-table-column>

            <el-table-column prop="compayname" label="合同编号"  sortable>
            </el-table-column>
            <el-table-column prop="compaytest" label="楼盘"   sortable>
            </el-table-column>
            <el-table-column prop="yjzbSf" label="楼栋"  sortable>
            </el-table-column>
            <el-table-column prop="yjzbCf" label="房间号"  sortable>
            </el-table-column>
            <el-table-column prop="yjzbCf" label="月租金"   sortable>
            </el-table-column>
            <el-table-column prop="yjzbCf" label="出房佣金(月租金96%)" width="200" sortable>
            </el-table-column>
            <el-table-column prop="yjzbCf" label="实际佣金"   sortable>
            </el-table-column>
            <el-table-column prop="compayname" label="渠道公司" width="200" sortable>
            </el-table-column>
            <el-table-column prop="compayname" label="渠道人员"   sortable>
            </el-table-column>
            <el-table-column prop="compayname" label="申请人"   sortable>
            </el-table-column>
            <el-table-column prop="yjType" label="返佣状态"  :formatter="formatYJType" sortable>
            </el-table-column>

            <el-table-column label="操作" width="100">
                <template scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>

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
                    <el-input v-model="editForm.compayname" auto-complete="off"  ></el-input>
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
                    contractNo:'',
                    buildingname:'',
                    buildname:'',
                    roomname:'',
                    ZhuangTai:0,
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
                                    }
                                })
                            }
                        }, trigger:'blur'}
                    ],
                    yjzbSf: [
                        { required: true, message: '请输入收房佣金占比', trigger: 'blur' }
                    ],
                    yjzbCf: [
                        { required: true, message: '请输入出房佣金占比', trigger: 'blur' }
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
                        { required: true, message: '请输入收房佣金占比', trigger: 'blur' }
                    ],
                    yjzbCf: [
                        { required: true, message: '请输入出房佣金占比', trigger: 'blur' }
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
            //判断渠道公司名称是否重复
            changeCountAdd: function() {

            },
            //判断渠道公司名称是否重复
            changeCountEidt: function() {
                let para = {
                    name: this.editForm.compayname
                };
                if(this.editForm.compayname!=''){
                    checkbkNameList(para).then((res) => {
                        //alert( JSON.stringify(res));
                        if(res.data.code!='200')
                        {

                            this.$message({
                                message: "公司名称已存在",
                                type: 'error'
                            });
                        }
                    })
                }
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
