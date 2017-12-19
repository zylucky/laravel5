<template>
    <el-row>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.buildingname" placeholder="楼盘名称"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.buildname" placeholder="楼栋名称"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.roomname" placeholder="房间号"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search" v-on:click="getChuFangCommission">搜索</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="ChuFang" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"
                  @selection-change="selsChange" style="width: 100%;">

            <el-table-column prop="htqiandingdate" label="合同签订日期" :formatter="changeDate" sortable>
            </el-table-column>
            <el-table-column prop="loupanname" label="楼盘" >
            </el-table-column>
            <el-table-column prop="loudongname" label="楼栋" >
            </el-table-column>
            <el-table-column prop="houseno" label="房间号" >
            </el-table-column>
            <el-table-column prop="htzujin" label="合同月租金" >
            </el-table-column>
            <el-table-column prop="htyongjin" label="佣金金额" width="200" >
            </el-table-column>
            <el-table-column prop="shijiyongjin" label="渠道公司" width="100" >
            </el-table-column>
            <el-table-column prop="shijiyongjin" label="渠道人员" width="100" >
            </el-table-column>
            <el-table-column prop="fukuanriqi" label="提交日期" :formatter="changeJSDate">
            </el-table-column>
            <el-table-column prop="yjstate" label="状态" :formatter="formatYJType">
            </el-table-column>
            <el-table-column prop="htyezhushifuyj" label="备注" width="100" >
            </el-table-column>
            <el-table-column label="操作" width="140">
                <template slot-scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item  > <el-button   v-if="scope.row.yjstate<3" @click="handleFinish(scope.$index, scope.row)">审批</el-button> </el-dropdown-item>
                            <el-dropdown-item  > <el-button  v-if="scope.row.yjstate<3" @click="handleFinish(scope.$index, scope.row)">付款</el-button> </el-dropdown-item>
                            <el-dropdown-item  > <el-button  v-if="scope.row.yjstate<3" @click="handleRokeBack(scope.$index, scope.row)">查看</el-button> </el-dropdown-item>
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
        getChuFangCommissionListPage,
        editChuFangCommission,
        finishFK,


    } from '../../api/api';

    export default{

        data(){

            return {
                filters: {
                    contractNo: '',
                    buildingname: '',
                    buildname: '',
                    roomname: '',
                    ZhuangTai: '',
                    compayname:'',
                    startdate: '',
                    enddate: '',
                    yjstartdate: '',
                    yjenddate: '',

                },
                options: [
                    {
                        value: 1,
                        label: '未付款'
                    }, 
                    {
                        value: 2,
                        label: '已付款'
                    }, {
                        value: 3,
                        label: '已完成'

                    },
                ],
                //分页类数据
                total: 0,
                currentPage: 0,
                pageSize: 10,
                pageSizes: [10, 20, 30, 40, 50, 100],
                ChuFang: [],
                listLoading: false,
                sels: [],//列表选中列
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                },
                //编辑界面数据
                editForm: {
                },
                showed: false,
                rokeBackFormVisible: false,//返佣界面是否显示
                rokeBackLoading: false,
                rokeBackFormRules: {
                    empmoney:[{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],

                    skdate: [
                        { type: 'date', required: true, message: '请输入付款日期', trigger: 'change' }
                    ],

                },
                //确认付款界面数据
                rokeBackForm: {
                    tQdApplyId: '',
                    empmoney: '',
                    skdate:''
                },
                bk_name: '',
                //被选中的权限
                checked: [],
            }
        },
        methods: {
            //状态显示转换
            formatYJType: function (row, column) {
                let status = [];
                status[1] = '未付款';
                status[2] = '已付款';
                status[3] = '已完成';
                return status[row.yjstate];
            },
            //状态显示转换
            formatState: function (yjstate) {
                let status = [];
                status[1] = '未付款';
                status[2] = '已付款';
                status[3] = '已完成';
                return status[yjstate];
            },

            //时间戳转日期格式
            changeXQDate(dt){
                if(dt!=null){
                    var newDate = new Date();
                    newDate.setTime(dt);
                    return newDate.toLocaleDateString();
                }
            },
            //时间戳转日期格式
            changeJSDate(row, column){
                if(row.fukuanriqi!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.fukuanriqi);
                    return newDate.toLocaleDateString();
                }
            },
            //时间戳转日期格式
            changeDate(row, column){
                if(row.htqiandingdate!=null){
                    var newDate = new Date();
                    newDate.setTime(row.htqiandingdate);
                    return newDate.toLocaleDateString();
                }
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                // console.log(`当前页: ${val}`);
                this.getChuFangCommission();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize = val;
                //console.log(`每页 ${val} 条`);

                this.getChuFangCommission();
            },

            //获取出房佣金列表

            getChuFangCommission() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    contractNo: this.filters.contractNo,
                    buildingname: this.filters.buildingname,
                    buildname: this.filters.buildname,
                    roomname: this.filters.roomname,
                    ZhuangTai: this.filters.ZhuangTai,
                    startdate: this.filters.startdate,
                    enddate: this.filters.enddate,
                    yjstartdate: this.filters.yjstartdate,
                    yjenddate: this.filters.yjenddate,
                    compayname:this.filters.compayname,

                };
                this.listLoading = true;
                getChuFangCommissionListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.ChuFang = res.data.data;
                    this.listLoading = false;
                });
            },

            //显示编辑界面
            handleEdit: function (index, row) {
                this.$router.push('/commissionView?id=' + row.tQdCompayId);
            },
            //显示新增界面
            handleAdd: function () {
                this.$router.push('/commissionView?id=');
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            //完成按钮
            handleFinish: function (index, row) {
                this.$confirm('确认提交完成付款吗？', '提示', {}).then(() => {
                    let para = {
                        id:row.tQdApplyId,
                    }
                    //console.log(para);
                    finishFK(para).then((res) => {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.getChuFangCommission();
                    });
                });
            },
            //确认收款按钮
            RokeBackSubmit: function () {
                this.$refs.rokeBackForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.rokeBackLoading = true;
                            let para = Object.assign({}, this.rokeBackForm);
                            // para.tQdApplyId = this.editForm.tQdApplyId;
                            editChuFangCommission(para).then((res) => {
                                this.rokeBackLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['rokeBackForm'].resetFields();
                                this.rokeBackFormVisible = false;
                                this.getChuFangCommission();
                            });
                        });
                    }
                });
            },
            //显示确认收款界面
            handleRokeBack: function (index, row) {
                this.rokeBackFormVisible = true;
                // this.rokeBackForm = Object.assign({}, row);
                this.rokeBackForm= {
                    tQdApplyId: row.tQdApplyId,
                    empmoney: '',
                    skdate:''

                }
            },
        },

        mounted() {
            this.page = 1;
            this.getChuFangCommission();

        }
    }
</script>
