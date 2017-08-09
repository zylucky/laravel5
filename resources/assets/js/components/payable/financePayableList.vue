<template>
    <el-row>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="合同编号:">
                <el-input v-model="filters.contractNo" placeholder="请输入合同编号"></el-input>
            </el-form-item>
            <el-form-item label="项目名称:">
                <el-input v-model="filters.xm" placeholder="请输入项目名称"></el-input>
            </el-form-item>
            <el-form-item label="付款日期:">
                <el-date-picker type="date" placeholder="请选择开始日期" v-model="filters.startdate">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="至">
                <el-date-picker type="date" placeholder="请选择结束日期" v-model="filters.enddate">
                </el-date-picker>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search" v-on:click="getPayable">搜索</el-button>
            </el-form-item>
        </el-form>

        <el-tabs v-model="activeName2" type="border-card" @tab-click="handleClick">
            <el-tab-pane label="全部" name="first"></el-tab-pane>
            <el-tab-pane label="已付款" name="second"></el-tab-pane>
            <el-tab-pane label="未付款" name="third"></el-tab-pane>

            <el-table :data="Payable" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"
                      @selection-change="selsChange" style="width: 100%;">
                <el-table-column prop="hetongbianhao" label="合同编号">
                </el-table-column>
                <el-table-column prop="xiangmu" label="项目">
                </el-table-column>
                <el-table-column prop="fukuandate" label="付款日期" :formatter="changeFKDate">
                </el-table-column>
                <el-table-column prop="fukuantype" label="付款科目" >
                </el-table-column>
                <el-table-column prop="yingfumoney" label="应付金额">
                </el-table-column>
                <el-table-column prop="faqiren" label="发起人">
                </el-table-column>
                <el-table-column prop="shoukuanyinhangzhanghao" label="收款银行及账号" width="200"  >
                </el-table-column>
                <el-table-column prop="zhuangtai" label="状态" :formatter="formatState" width="100">
                </el-table-column>
                <el-table-column label="操作" width="120">
                    <template scope="scope">
                        <el-dropdown menu-align="start">
                            <el-button type="primary" size="normal" splitButton="true">
                                操作<i class="el-icon-caret-bottom el-icon--right"></i>
                            </el-button>
                            <el-dropdown-menu slot="dropdown">
                                <el-dropdown-item>
                                    <el-button @click="handleRokeBack(scope.$index, scope.row)">确认付款</el-button>
                                </el-dropdown-item>
                                <el-dropdown-item>
                                    <el-button @click="handleReject(scope.$index, scope.row)">驳回付款</el-button>
                                </el-dropdown-item>
                                <el-dropdown-item>
                                    <el-button @click="handleOpen(scope.$index, scope.row)">上传凭证</el-button>
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </template>
                </el-table-column>
            </el-table>
            <div style="margin-top:30px"></div>
            <!-- 分页-->
            <el-col :span="24" class="toolbar">

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
        </el-tabs>

    </el-row>
</template>
<script>

    import {
        getFinancePayableListPage,
        rejectPayable,
        confirmPayable,
    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                filters: {
                    contractNo: '',
                    buildingname: '',
                    buildname: '',
                    roomname: '',
                    startdate: '',
                    enddate: '',
                    zt:'',
                },
                options: [
                    {
                        value: 1,
                        label: '押金'
                    }, {
                        value: 2,
                        label: '房租'
                    },
                ],
                //分页类数据
                total: 0,
                currentPage: 0,
                pageSize: 10,
                pageSizes: [10, 20, 30, 40, 50, 100],
                Payable: [],
                listLoading: false,
                sels: [],//列表选中列
                activeName2: 'first',
                rokeBackFormVisible: false,//收款界面是否显示
                rokeBackLoading: false,
                rokeBackFormRules: {
                    skrq: [
                        {type: 'date', required: true, message: '请输入收款日期', trigger: 'change'}
                    ],
                    meoney: [
                        {required: true, message: '请输入收款金额', trigger: 'blur'}
                    ],
                    skType: [
                        {
                            required: true, validator: (rule, value, callback) => {
                            if (/^\d+$/.test(value) == false) {
                                callback(new Error("请输入收款类型"));
                            } else {
                                callback();
                            }
                        }, trigger: 'blur'
                        }
                    ],
                },
                //付款界面数据
                rokeBackForm: {
                    tQdCompayId: 0,
                    skType: 1,
                    meoney: '',
                    skrq: '',
                    memo: '',
                },
                //被选中的权限
                checked: [],
            }
        },
        methods: {
            formatFKType(row, column){
                let status = [];
                status[0] = '押金';
                status[1] = '租金';
                status[2] = '幼师补佣';
                status[3] = '佣金';
                status[4] = '华亮返佣';
                return status[row.fktype];
            },

            //时间戳转日期格式
            changeFKDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.fukuandate);
                return newDate.toLocaleDateString()
            },
            //佣金类型显示转换
            formatState: function (row, column) {
                let status = [];
                status[1] = '未付款';
                status[2] = '已付款';
                status[3] = '不支付';
                return status[row.zhuangtai];
            },

            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.fkdate);
                return newDate.toLocaleDateString()
            },
            //标签切换时
            handleClick(tab, event) {
                if (tab.index == 0) {
                    this.filters.zt = '';
                    this.getPayable();
                }else if(tab.index == 1) {
                    this.filters.zt = 2;
                    this.getPayable();
                }else if (tab.index == 2) {
                    this.filters.zt = 1;
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
                this.pageSize = val;
                this.getPayable();
            },
            //打开应付记录页面
            handleOpen: function () {
                window.open('#/paymentRecord');
            },
            handleOpenUp: function () {
                window.open('#/payableRecord');
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
                    zt:this.filters.zt,
                };
                this.listLoading = true;
                getFinancePayableListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.Payable = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示付款界面
            handleRokeBack: function (index, row) {
                this.$confirm('确认付款吗？', '提示', {}).then(() => {
                    let para = {
                        id: row.tCwFcCaiwuId,
                    };;
                    confirmPayable(para).then((res) => {
                        this.$message({
                            message: '确认成功',
                            type: 'success'
                        });
                        this.getPayable();
                    });
                });

            },
            //显示付款界面
            handleReject: function (index, row) {
                this.$confirm('确认驳回吗？', '提示', {}).then(() => {
                    let para = {
                        id: row.tCwFcCaiwuId,
                    };;
                    rejectPayable(para).then((res) => {
                        this.$message({
                            message: '驳回成功',
                            type: 'success'
                        });
                        this.getPayable();
                    });
                });

            },
            //显示编辑界面
            handleMoneyEdit: function (index, row) {

                this.editMoneyFormVisible = true;
                this.editMoneyForm = Object.assign({}, row);
                this.editMoneyForm = {
                    fkrq: '',
                    fkstaDate: '',
                    fkendDate: '',
                    fkje: '',
                    isFP: 1,
                };
            },
            //编辑
            editDateFormSubmit: function () {
                this.$refs.editDateForm.validate((valid) => {
                    if (editDateForm) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            let para = Object.assign({}, this.editForm);
                            para.fkrq = new Date(para.fkrq).toLocaleDateString();
                            para.fkstaDate = new Date(para.fkstaDate).toLocaleDateString();
                            para.fkendDate = new Date(para.fkendDate).toLocaleDateString();
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
                            para.fkrq = new Date(para.fkrq).toLocaleDateString();
                            para.fkstaDate = new Date(para.fkstaDate).toLocaleDateString();
                            para.fkendDate = new Date(para.fkendDate).toLocaleDateString();
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
                            para.skrq = new Date(para.skrq).toLocaleDateString();
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
            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page = 1;
            this.getPayable();

        }
    }
</script>
