
<template>
    <el-row >
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="付款银行:">
                <el-input v-model="filters.fkyh" placeholder="请输入付款银行"></el-input>
            </el-form-item>
            <el-form-item label="付款账号:">
                <el-input v-model="filters.fkzh" placeholder="请输入付款账号"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getReceivable">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"    @click="handleAdd">新增</el-button>
            </el-form-item>
        </el-form>
        <el-table height="500" :data="financeReceivable" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"   style="width: 100%;">
            <el-table-column prop="shoukuandate" label="收款日期" :formatter="changeDate1" >
            </el-table-column>
            <el-table-column prop="shoukuanmoney" label="收款金额" >
            </el-table-column>
            <el-table-column prop="fukuanzhanghu" label="付款方户名"  >
            </el-table-column>
            <el-table-column  label="付款银行及账号"   :formatter="formatskyh">
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态"  :formatter="formatState"  >
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
        <el-dialog title="应收款列表" v-model="rokeBackFormVisible" :close-on-click-modal="false" size="large">
            <el-form :inline="true" :model="filters" class="demo-form-inline">
                <el-form-item label="合同编号:">
                    <el-input v-model="filters.contractNo" placeholder="请输入付款银行"></el-input>
                </el-form-item>
                <el-form-item label="项目名称:">
                    <el-input v-model="filters.xm" placeholder="请输入付款账号"></el-input>
                </el-form-item>
                <el-form-item label="租户名称:">
                    <el-input v-model="filters.yz" placeholder="请输入租户名称"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" icon="search"  v-on:click="getReceivableJS">搜索</el-button>
                </el-form-item>
            </el-form>
            <el-table height="500" :data="ReceivableJS" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                <el-table-column type="selection" width="55">
                </el-table-column>
                <el-table-column prop="htbianhao" label="合同编号" width="200">
                </el-table-column>
                <el-table-column prop="xiangmu" label="项目" width="200">
                </el-table-column>
                <el-table-column prop="zuhu" label="租户" >
                </el-table-column>
                <el-table-column prop="skfangshi" label="付款方式"  width="100" >
                </el-table-column>
                <el-table-column prop="monthmoney" label="月租金"  >
                </el-table-column>
                <el-table-column prop="skdate" label="收款日期" :formatter="changeDate2" width="100">
                </el-table-column>
                <el-table-column prop="sktype" label="收款科目"    :formatter="formatFKType" width="100">
                </el-table-column>
                <el-table-column prop="skmoney" label="应收房租" width="100">
                </el-table-column>
                <el-table-column prop="tijiaomoney" label="提交金额"  width="100">
                </el-table-column>
                <el-table-column prop="shishoumoney" label="实收金额"  width="100">
                </el-table-column>
                <el-table-column prop="xiugaizhuangtai" label="修改状态"   width="100">
                </el-table-column>
                <el-table-column prop="srstate" label="支付状态"  :formatter="formatState"  width="100">
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

            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click.native="rokeBackSubmit"  >认领</el-button>
                <el-button @click.native="rokeBackFormVisible = false">取消</el-button>
            </div>
        </el-dialog>
        <el-dialog title="新增收款" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="120px" :rules="addFormRules" ref="addForm"  >
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="收款金额：" prop="shoukuanmoney">
                            <el-input    v-model.number="addForm.shoukuanmoney" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="收款时间：" prop="shoukuandate">
                            <el-date-picker type = "date" v-model="addForm.shoukuandate" auto-complete="off">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="付款方户名：" prop="fukuanzhanghu">
                            <el-input    v-model="addForm.fukuanzhanghu" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="16">
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
        getReceiveList,
        getReceivableListPage,
        editReceivable,
        financeSaveShouKuan,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                Receivable:[],//应收列表
                filters:{
                    fkyh: '',
                    fkzh:'',
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
                financeReceivable:[],
                ReceivableJS:[],
                JSlistLoading:false,
                listLoading: false,
                sels: [],//列表选中列
                rokeBackFormVisible: false,//收款界面是否显示
                rokeBackLoading: false,
                addFormVisible: false,//收款界面是否显示
                addFormLoading: false,
                addFormRules: {
                    shoukuanmoney:[
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}
                    ],
                    shoukuandate: [
                        {required: true, message: '不能为空'},
                    ],
                    fukuanzhanghu: [
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
                    beizhu:'',
                    fukuanyinhang:'',
                    fukuanzhanghao:'',
                    fukuanzhanghu:'',
                    shoukuandate:'',
                    shoukuanmoney:'',
                    zhuangtai:'',
                },
                totaljs:0,
                currentPagejs:0,
                pageSizejs:10,
            }
        },
        methods:{
            handleRokeBack(){
                this.rokeBackFormVisible = true;
                this.getReceivableJS();
            },
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
                return status[row.zhuangtai];
            },
            //佣金类型显示转换
            formatskyh: function (row, column) {
                return  row.fukuanyinhang+'\r账号'+row.fukuanzhanghao;
            },
            //时间戳转日期格式
            changeDate1(value){
                var newDate = new Date();
                newDate.setTime(value.shoukuandate);
                return newDate.toLocaleDateString()
            },
            //时间戳转日期格式
            changeDate2(row, column){
                var newDate = new Date();
                newDate.setTime(row.skdate);
                return newDate.toLocaleDateString()
            },
            //标签切换时
            handleClick(tab, event) {
             if(tab.index==0){
                 this.page = 2;
                 this.getReceivable();
             }
             else{
                 this.page = 1;
                 this.getReceivable();
             }
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getReceivable();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getReceivable();
            },
            //页面跳转后
            handleCurrentChangejs(val) {
                this.pagejs = val;
                this.getReceivableJS();
            },
            //更改每页显示数据
            handleSizeChangejs(val){
                this.pageSizejs =val;
                this.getReceivableJS();
            },
            //获取实收款列表
            getReceivable() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    fkyh: this.filters.fkyh,
                    fkzh: this.filters.fkzh,
                };
                this.listLoading = true;
                getReceiveList(para).then((res) => {
                    this.total = res.data.total;
                    this.financeReceivable = res.data.data;
                    this.listLoading = false;
                });
            },
            //获取应付款列表
            getReceivableJS() {
                let para = {
                    page: this.pagejs,
                    pageSize: this.pageSizejs,
                    contractNo: this.filters.contractNo,
                    xm: this.filters.xm,
                    yz: this.filters.yz,
                };
                this.JSlistLoading = true;
                getReceivableListPage(para).then((res) => {
                    this.totaljs = res.data.total;
                    this.ReceivableJS = res.data.data;
                    this.JSlistLoading = false;
                });
            },
            //新增实收页面
            handleAdd: function (index, row) {
                this.addFormVisible = true;
            },
            //提交数据
            addFormSubmit(){
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            let para = Object.assign({}, this.addForm);
                            financeSaveShouKuan(para).then((res) => {
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['rokeBackForm'].resetFields();
                                this.getReceivable();
                            });
                        });
                    }
                });
            },
            //认领提交
            rokeBackSubmit: function () {
                console.log()

            },
            selsChange: function (sels,row) {
                this.$refs.multipleTable.clearSelection();
                this.$refs.multipleTable.toggleRowSelection(row);
            },
        },
        mounted() {
            this.page=1;
            this.getReceivable();

        }
    }
</script>
