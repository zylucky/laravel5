
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="付款银行:">
                <el-input v-model="filters.contractNo" placeholder="请输入付款银行"></el-input>
            </el-form-item>
            <el-form-item label="付款账号:">
                <el-input v-model="filters.buildingname" placeholder="请输入付款账号"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getPayable">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"    @click="handleAdd"    > 新增</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="Payable" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"   style="width: 100%;">
            <el-table-column prop="fkdate" label="收款日期" :formatter="changeDate" >
            </el-table-column>
            <el-table-column prop="fkmoney" label="收款金额" >
            </el-table-column>
            <el-table-column prop="houseno" label="付款方户名"  >
            </el-table-column>
            <el-table-column prop="skyinhang" label="付款银行及账号"   :formatter="formatskyh">
            </el-table-column>
            <el-table-column prop="fkstate" label="状态"  :formatter="formatState"  >
            </el-table-column>
            <el-table-column label="操作" width="120">
                   <template scope="scope">
                       <el-dropdown   menu-align="start">
                           <el-button type="primary" size="normal" splitButton="true">
                               操作<i class="el-icon-caret-bottom el-icon--right"></i>
                           </el-button>
                           <el-dropdown-menu slot="dropdown" >
                               <el-dropdown-item  ><el-button   @click="handleRokeBack(scope.$index, scope.row)">认领</el-button></el-dropdown-item>
                               <el-dropdown-item  > <el-button  @click="handleOpen(scope.$index, scope.row)">上传凭证</el-button> </el-dropdown-item>
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
        <el-dialog title="提交付款" v-model="rokeBackFormVisible" :close-on-click-modal="false">
            <el-table :data="PayableJS" highlight-current-row v-loading="JSlistLoading" ref="multipleTable" element-loading-text="拼命加载中"   @select="selsChange">
                <el-table-column type="selection"  width="55">
                </el-table-column>
                <el-table-column prop="fkdate" label="收款日期" :formatter="changeDate" >
                </el-table-column>
                <el-table-column prop="fkmoney" label="收款金额" >
                </el-table-column>
                <el-table-column prop="houseno" label="付款方户名"   >
                </el-table-column>
                <el-table-column prop="skyinhang" label="付款银行及账号"     :formatter="formatskyh">
                </el-table-column>
                <el-table-column prop="fkstate" label="状态"  :formatter="formatState"   >
                </el-table-column>
            </el-table>
            <el-col :span="24" class="toolbar" >

                <el-pagination
                        @size-change="handleSizeChangejs"
                        @current-change="handleCurrentChangejs"
                        :current-page="currentPagejs"
                        :page-size="10"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total=totaljs
                        style="float:right"
                >
                </el-pagination>
            </el-col>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click.native="rokeBackSubmit"  >认领</el-button>
                <el-button @click.native="rokeBackFormVisible = false">取消</el-button>
            </div>
        </el-dialog>
        <el-dialog title="新增收款记录" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="120px" :rules="addFormRules" ref="addForm"  >
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="付款金额：" prop="tijiaomoney">
                            <el-input    v-model.number="addForm.tijiaomoney" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="付款时间：" prop="fukuandate">
                            <el-date-picker type = "date" v-model="addForm.fukuandate" auto-complete="off">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="付款方户名：" prop="huming">
                            <el-input    v-model="addForm.huming" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="付款银行：" prop="fukuanyinhang">
                            <el-input   v-model="addForm.fukuanyinhang" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item label="付款账号：" prop="fukuanzhanghao">
                    <el-input    v-model="addForm.fukuanzhanghao" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item   label="备注：" prop="beizhu">
                    <el-input type="textarea" v-model="addForm.beizhu" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="addFormSubmit" :loading="addFormLoading">保存</el-button>
            </div>
        </el-dialog>

    </el-row>
</template>
<script>

    import {
        getPayableListPage,
        editReceivable,
        saveShouKuan,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                filters:{
                    contractNo: '',
                    buildingname:'',
                    buildname:'',
                    roomname:'',
                    startdate:'',
                    enddate:'',

                },
                options:[
                    {
                        value: 1,
                        label: '押金'
                    }, {
                        value: 2,
                        label: '房租'
                    },
                ],
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                Payable:[],
                PayableJS:[],
                JSlistLoading:false,
                listLoading: false,
                sels: [],//列表选中列
                activeName2: 'first',
                rokeBackFormVisible: false,//收款界面是否显示
                rokeBackLoading: false,
                rokeBackFormRules: {
                    skrq: [
                        { type: 'date', required: true, message: '请输入收款日期', trigger: 'change' }
                    ],
                    meoney: [
                        { required: true, message: '请输入收款金额', trigger: 'blur' }
                    ],
                    skType:[
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error("请输入收款类型"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                },
                //付款界面数据
                rokeBackForm: {
                    tQdCompayId:0,
                    skType:1,
                    meoney:'',
                    skrq:'',
                    memo:'',
                },
                addFormVisible: false,//收款界面是否显示
                addFormLoading: false,
                addFormRules: {
                    tijiaomoney:[{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                    fukuandate: [
                        {required: true, message: '不能为空'},
                    ],
                    huming: [
                        {required: true, message: '不能为空'},
                    ],
                    fukuanyinhang: [
                        {required: true, message: '不能为空'},
                    ],
                    fukuanzhanghao: [
                        {required: true, message: '不能为空'},
                    ],
                },
                //付款界面数据
                addForm: {
                    tCwSrId:'',
                    hetongbianhao:'',
                    xiangmu:'',
                    fukuankemu:'',
                    tijiaomoney:'',
                    fukuandate:'',
                    beizhu:'',
                    fukuanyinhang:'',
                    fukuanzhanghao:'',
                },
                totaljs:0,
                currentPagejs:0,
                pageSizejs:10,
            }
        },
        methods:{
            formatFKType(row, column){
                let status = [];
                status[0] = '押金';
                status[1] = '租金';
                status[2] = '幼师补佣';
                status[3] = '佣金';
                status[4] = '华亮返佣';
                return status[row.fktype];
            },

            //佣金类型显示转换
            formatState: function (row, column) {
                let status = [];
                status[0] = '未付';
                status[1] = '已付';
                return status[row.fkstate];
            },
            //佣金类型显示转换

            formatskyh: function (row, column) {

                return  row.skyinhang==null?'':row.skyinhang+"\r账号:"+row.skzhanhu==null?'': row.skzhanhu;
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.fkdate);
                return newDate.toLocaleDateString()
            },
            //标签切换时
            handleClick(tab, event) {
             if(tab.index==0){
                 this.page = 2;
                 this.getPayable();
             }
             else{
                 this.page = 1;
                 this.getPayable();
             }
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getPayable();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getPayable();
            },
            //页面跳转后
            handleCurrentChangejs(val) {
                this.pagejs = val;
                this.getPayableJS();
            },
            //更改每页显示数据
            handleSizeChangejs(val){
                this.pageSizejs =val;
                this.getPayableJS();
            },

            //获取应付款列表
            getPayable() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    contractNo: this.filters.contractNo,
                    buildingname: this.filters.buildingname,
                    buildname: this.filters.buildname,
                    roomname: this.filters.roomname,
                    startdate: this.filters.startdate,
                    enddate: this.filters.enddate,
                };
                this.listLoading = true;
                getPayableListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.Payable = res.data.data;
                    this.listLoading = false;
                });
            },
            //获取应付款列表
            getPayableJS() {
                let para = {
                    page: this.pagejs,
                    pageSize: this.pageSizejs,
                    contractNo: this.filters.contractNo,
                    buildingname: this.filters.buildingname,
                    buildname: this.filters.buildname,
                    roomname: this.filters.roomname,
                    startdate: this.filters.startdate,
                    enddate: this.filters.enddate,
                };
                this.JSlistLoading = true;
                getPayableListPage(para).then((res) => {
                    this.totaljs = res.data.total;
                    this.PayableJS = res.data.data;
                    this.JSlistLoading = false;
                });
            },
            //显示付款界面
            handleRokeBack: function (index, row) {
                this.rokeBackFormVisible = true;
                this.pagejs=1;
                this.getPayableJS();
            },
            //显示付款界面
            handleAdd: function (index, row) {
                this.addFormVisible = true;
                this.addForm  = Object.assign({}, row);
                this.addForm = {
                    tCwSrId:row.tCwSrId,
                    hetongbianhao:row.htbianhao,
                    xiangmu: row.loupanName==null?'':row.loupanName+row.loudongName==null?'': row.loudongName+row.houseno==null?'': row.houseno,
                    fukuankemu:row.fktype,
                    tijiaomoney:'',
                    fukuandate:'',
                    huming:'彭亮',
                    beizhu:'',
                    fukuanyinhang:'',
                    fukuanzhanghao:'',
                };
            },
            //编辑
            editDateFormSubmit: function () {
                this.$refs.editDateForm.validate((valid) => {
                    if (editDateForm) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            let para = Object.assign({}, this.editForm);
                            para.fkrq = new Date(para.fkrq).toLocaleDateString() ;
                            para.fkstaDate = new Date(para.fkstaDate).toLocaleDateString() ;
                            para.fkendDate = new Date(para.fkendDate).toLocaleDateString() ;
                            editReceivable(para).then((res) => {
                                this.editLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getPayable();
                            });
                        });
                    }
                });
            },
            editMoneyFormSubmit: function () {
                this.$refs.editMoneyForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            let para = Object.assign({}, this.editForm);
                            para.fkrq = new Date(para.fkrq).toLocaleDateString() ;
                            para.fkstaDate = new Date(para.fkstaDate).toLocaleDateString() ;
                            para.fkendDate = new Date(para.fkendDate).toLocaleDateString() ;
                            editReceivable(para).then((res) => {
                                this.editLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getPayable();
                            });
                        });
                    }
                });
            },
            //付款
            rokeBackSubmit: function () {
                this.$refs.rokeBackForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.rokeBackLoading = true;
                            let para = Object.assign({}, this.rokeBackForm);
                            para.skrq = new Date(para.skrq).toLocaleDateString() ;
                            saveShouKuan(para).then((res) => {
                                this.rokeBackLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['rokeBackForm'].resetFields();
                                this.rokeBackFormVisible = false;
                                this.getPayable();
                            });
                        });
                    }
                });
            },


            selsChange: function (sels,row) {
                this.$refs.multipleTable.clearSelection();
                this.$refs.multipleTable.toggleRowSelection(row);

            },

        },
        mounted() {
            this.page=1;
            this.getPayable();

        }
    }
</script>
