
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.bk_username" placeholder="渠道公司人员"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.bk_name" placeholder="渠道公司名称"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getBrokerCompanyUser">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="handleAdd"> 新增</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="brokerCompanyUser" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="qvDaoCompayXinxi.compayname" label="渠道公司名称"  sortable>
            </el-table-column>
            <el-table-column prop="qdPername" label="姓名"  sortable>
            </el-table-column>
            <el-table-column prop="qdPertel" label="电话"  sortable>
            </el-table-column>

            <el-table-column prop="yjzbSf" label="收房佣金占比"  sortable>
            </el-table-column>
            <el-table-column prop="yjzbCf" label="出房佣金占比"  sortable>
            </el-table-column>
            <el-table-column prop="yjType" label="佣金类型"  :formatter="formatYJType" sortable>
            </el-table-column>
            <!--    <el-table-column prop="tbPersonIdCreate" label="创建人"   sortable>
               </el-table-column>
               <el-table-column prop="createdate" label="创建时间" :formatter="changeDate" sortable>
               </el-table-column>-->
               <el-table-column label="操作" width="150">
                   <template scope="scope">
                       <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                       <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>
                   </template>
               </el-table-column>
           </el-table>
           <div style="margin-top:30px"></div>
           <!-- 分页-->
        <el-col :span="24" class="toolbar" >
            <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
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
            <el-form :model="editForm" label-width="120px" :rules="editFormRules" ref="editForm">
                <el-input type="hidden" prop="tQdCompayName"  auto-complete="off"></el-input>
                <el-form-item label="渠道公司名称" prop="tQdCompayId" >
                    <el-select
                            v-model="editForm.tQdCompayId"
                            filterable
                            remote
                            @change="change"
                            placeholder="渠道公司名称"
                            :remote-method="remoteMethod1"
                            :loading="bkNameloading">
                        <el-option
                                v-for="item in options1"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="姓名" prop="qdPername">
                    <el-input v-model="editForm.qdPername" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="电话" prop="qdPertel">
                    <el-input type="tel"  v-model="editForm.qdPertel" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="收房佣金占比" prop="yjzbSf">
                    <el-input  type="number"  v-model="editForm.yjzbSf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item   label="出房佣金占比" prop="yjzbCf">
                    <el-input type="number" v-model="editForm.yjzbCf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="佣金类型"    prop="yjType">
                    <el-select v-model="editForm.yjType" placeholder=""   >
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"

                        >
                        </el-option>
                    </el-select>
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

                    <el-form-item label="渠道公司名称"   prop="tQdCompayId"  >
                        <el-select
                                v-model="addForm.tQdCompayId"
                                filterable
                                remote
                                placeholder="渠道公司名称"
                                :remote-method="remoteMethod1"
                                :loading="bkNameloading">
                            <el-option
                                    v-for="item in options1"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>

                <el-form-item label="姓名" prop="qdPername">
                    <el-input v-model="addForm.qdPername" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="电话" prop="qdPertel">
                    <el-input type="tel" v-model="addForm.qdPertel"   auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item label="收房佣金占比" prop="yjzbSf">
                    <el-input type="number" v-model="addForm.yjzbSf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="出房佣金占比" prop="yjzbCf">
                    <el-input type="number" v-model="addForm.yjzbCf" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="佣金类型"    prop="yjType">
                    <el-select v-model="addForm.yjType" placeholder="">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
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
        getBrokerCompanyUserListPage,
        editBrokerCompanyUser,
        removeBrokerCompanyUser,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
       // getUserNameByID,


    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    bk_name:'',
                    bk_username:'',
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
                brokerCompanyUser:[],
                estate: [],//服务器搜索的渠道公司数据放入这个数组中
                listLoading: false,
                sels: [],//列表选中列
                bkNameloading: false,
                options1:[],



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
                        {  required: true, message: '请输入收房佣金占比', trigger: 'blur' }
                    ],
                    yjzbCf: [
                        {  required: true, message: '请输入出房佣金占比', trigger: 'blur' }
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
                        {   required: true, message: '请输入收房佣金占比', trigger: 'blur' }
                    ],
                    yjzbCf: [
                        {  required: true, message: '请输入出房佣金占比', trigger: 'blur' }
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
            //编辑选择渠道公司将id赋值给隐藏字段
            change(){
                //alert(this.editForm.tQdCompayId);
                if(!isNaN(this.editForm.tQdCompayId)){

                this.editForm.tQdCompayName= this.editForm.tQdCompayId;
                }
            },

            //获取渠道公司列表
            getBrokerCompanyUser() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name,
                    username: this.filters.bk_username,
                };
                this.listLoading = true;
                getBrokerCompanyUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompanyUser = res.data.data;
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
                        this.getBrokerCompanyUser();
                    });
                }).catch(() => {

                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                // Console.log(row);
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
               // this.editForm.yjType= row.yjType == 1 ? '按月租金' : row.yjType == 2 ? '按年租金' : '未知';
                this.editForm.tQdCompayId= row.qvDaoCompayXinxi.compayname;
                this.editForm.tQdCompayName= row.qvDaoCompayXinxi.tQdCompayId;
                this.editForm.yjzbCf= row.yjzbCf.toString();
                this.editForm.yjzbSf= row.yjzbSf.toString();
                // alert(this.editForm.tQdCompayName);
            },
            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
                this.addForm = {
                    tQdCompayId: '',
                    qdPername:'',
                    qdPertel:'',
                    yjzbSf:'',
                    yjzbCf:'',
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
                           // para.yjType= this.editForm.yjType == '按月租金' ?1 : this.editForm.yjType =='按年租金' ?2 : this.editForm.yjType;
                            para.tQdCompayId=this.editForm.tQdCompayName;

                            //console.log(para);
                            editBrokerCompanyUser(para).then((res) => {
                                this.editLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getBrokerCompanyUser();
                            });
                        });
                    }
                });
            },
            //新增
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                  //  alert(this.addForm.tQdCompayId);

                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.addForm);
                            //para.yjType= this.addForm.yjType == '按月租金' ? 1 : 2;
                            //para.birth = (!para.birth || para.birth == '') ? '' : util.formatDate.format(new Date(para.birth), 'yyyy-MM-dd');
                            addBrokerCompanyUser(para).then((res) => {
                                this.addLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['addForm'].resetFields();
                                this.addFormVisible = false;
                                this.getBrokerCompanyUser();
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
                var ids = this.sels.map(item => item.tQdPersonId).toString();
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { ids: ids };
                    batchRemoveBrokerCompanyUser(para).then((res) => {
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
                                message: res,
                                type: 'error'
                            });
                        }
                        this.getBrokerCompanyUser();
                    });
                }).catch(() => {

                });
            }
        },
        mounted() {
            this.page=1;
            this.getBrokerCompanyUser();

        }
    }
</script>
