
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="合同编号:">
                <el-input v-model="filters.contractNo" placeholder="请输入合同编号"></el-input>
            </el-form-item>
            <el-form-item label="项目名称:">
                <el-input v-model="filters.xm" placeholder="请输入项目名称"></el-input>
            </el-form-item>
            <el-form-item label="租户名称:">
                <el-input v-model="filters.yz" placeholder="请输入租户名称"></el-input>
            </el-form-item><br/>
            <el-form-item label="付款日期:">
                <el-date-picker type = "date" placeholder="请选择开始日期" v-model="filters.startdate">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="至">
                <el-date-picker type = "date" placeholder="请选择结束日期" v-model="filters.enddate">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="状态:">
                <el-select v-model="filters.zt" placeholder="请选择状态">
                    <el-option
                            v-for="item in optionszt"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>

            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getReceivable">搜索</el-button>
            </el-form-item>
        </el-form>

        <span style="color:red;">
注：红色日期表示付款已延期，请尽快处理
</span>
        <el-table :data="Receivable" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="htbianhao" label="合同编号"     >
            </el-table-column>
            <el-table-column prop="xm" label="项目"   :formatter="formatxm">
            </el-table-column>
            <el-table-column prop="zuhu" label="租户" >
            </el-table-column>
            <el-table-column prop="fkfangshi" label="付款方式"   >
            </el-table-column>
            <el-table-column prop="monthmoney" label="月租金"  >
            </el-table-column>
            <el-table-column prop="skdate" label="收款日期" :formatter="changeDate" >
            </el-table-column>
            <el-table-column prop="fktype" label="收款科目"    :formatter="formatFKType">
            </el-table-column>
            <el-table-column prop="skmoney" label="应收房租" >
            </el-table-column>
            <el-table-column prop="tijiaomoney" label="提交金额"  >
            </el-table-column>
            <el-table-column prop="shifumoney" label="实收金额"  >
            </el-table-column>
            <el-table-column prop="skyinhang" label="付款银行及账号"   width="200" :formatter="formatskyh"  >
            </el-table-column>
            <el-table-column prop="xiugaizhuangtai" label="修改状态"  :formatter="formatUpdateState"  width="100">
            </el-table-column>
            <el-table-column prop="fkstate" label="支付状态"  :formatter="formatState"  width="100">
            </el-table-column>
            <el-table-column label="操作" width="180">
                   <template scope="scope">
                       <el-dropdown   menu-align="start">
                           <el-button type="primary" size="normal" splitButton="true">
                               操作<i class="el-icon-caret-bottom el-icon--right"></i>
                           </el-button>
                           <el-dropdown-menu slot="dropdown" >
                               <el-dropdown-item  ><el-button   @click="handleRokeBack(scope.$index, scope.row)">提交付款</el-button></el-dropdown-item>
                               <el-dropdown-item  > <el-button  @click="handleOpen(scope.$index, scope.row)">查看详情</el-button> </el-dropdown-item>
                               <el-dropdown-item  > <el-button  @click="handleOpenUp(scope.$index, scope.row)">提交记录</el-button> </el-dropdown-item>
                               <el-dropdown-item  ><el-button   @click="handleEdit(scope.$index, scope.row)">编辑付款日期</el-button></el-dropdown-item>
                               <el-dropdown-item  ><el-button   @click="handleMoneyEdit(scope.$index, scope.row)">编辑付款金额</el-button></el-dropdown-item>
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
            <el-form :model="rokeBackForm" label-width="120px" :rules="rokeBackFormRules" ref="rokeBackForm"  >
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="付款金额：" prop="tijiaomoney">
                            <el-input    v-model.number="rokeBackForm.tijiaomoney" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="付款时间：" prop="fukuandate">
                            <el-date-picker type = "date" v-model="rokeBackForm.fukuandate" auto-complete="off">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="付款方户名：" prop="huming">
                            <el-input    v-model="rokeBackForm.huming" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="付款银行：" prop="fukuanyinhang">
                            <el-input   v-model="rokeBackForm.fukuanyinhang" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item label="付款账号：" prop="fukuanzhanghao">
                    <el-input    v-model="rokeBackForm.fukuanzhanghao" auto-complete="off"></el-input>
                </el-form-item>

                <el-form-item   label="备注：" prop="beizhu">
                    <el-input type="textarea" v-model="rokeBackForm.beizhu" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="rokeBackFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="rokeBackSubmit" :loading="rokeBackLoading">保存</el-button>
            </div>
        </el-dialog>


        <el-dialog title="编辑付款日期" v-model="editDateFormVisible" :close-on-click-modal="false">
            <el-form :model="editDateForm" label-width="120px" :rules="editDateFormRules" ref="editDateForm"  >
                <el-row>
                    <el-col :span="10">
                        <el-form-item label="提前付款：" prop="tiQianDays">
                            <el-input    v-model.number="editDateForm.tiQianDays" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>

                    <el-col :span="1"> <el-form-item label="天" >
                    </el-form-item>
                    </el-col>

                    <el-col :span="8">
                        <el-form-item label="" prop="isBenQi">
                            <el-radio-group v-model="editDateForm.isBenQi">
                                <el-radio class="radio" label=true>本期</el-radio>
                                <el-radio class="radio" label=false>所有</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editDateFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editDateFormSubmit" :loading="editDateFormLoading">保存</el-button>
            </div>
        </el-dialog>

        <el-dialog title="编辑付款金额" v-model="editMoneyFormVisible" :close-on-click-modal="false">
            <el-form :model="editMoneyForm" label-width="120px" :rules="editMoneyFormRules" ref="editMoneyForm"  >
                <el-row>
                    <el-col :span="16">
                        <el-form-item label="本期付款金额：" prop="shouKuanMoney">
                            <el-input   v-model.number="editMoneyForm.shouKuanMoney" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>

                </el-row>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editMoneyFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editMoneyFormSubmit" :loading="editMoneyFormLoading">保存</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>
<script>

    import {
        getReceivableListPage,
        editReceivable,
        saveShouKuan,
        skeditMoney,
        skeditDate,
    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                filters:{
                    contractNo: '',
                    yz:'',
                    xm:'',
                    zt:'',
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
                optionszt:[
                    {
                        value: 0,
                        label: '未提交'
                    }, {
                        value: 1,
                        label: '已提交'
                    },
                    {
                        value: 2,
                        label: '部分已付'
                    }, {
                        value: 3,
                        label: '已完成'
                    },
                    {
                        value: 4,
                        label: '已驳回'
                    }
                ],
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                Receivable:[],
                DataSum:[],
                listLoading: false,
                sels: [],//列表选中列

                rokeBackFormVisible: false,//收款界面是否显示
                rokeBackLoading: false,
                rokeBackFormRules: {
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

                editDateFormVisible: false,//编辑界面是否显示
                editDateFormLoading: false,
                editDateFormRules: {
                    tiQianDays: [
                        {required: true, message: '不能为空'},
                    ],
                    isBenQi: [
                        {required: true, message: '不能为空'},
                    ],
                },
                //编辑界面数据
                editDateForm: {
                    tiQianDays:'',
                    isBenQi:'',
                    tCwSrId:'',
                    hetongId:'',
                },
                editMoneyFormVisible: false,//编辑界面是否显示
                editMoneyFormLoading: false,
                editMoneyFormRules: {
                    shouKuanMoney: [{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                },
                //编辑界面数据
                editMoneyForm: {
                    shouKuanMoney:'',
                    yuanMoney:'',
                    tCwSrId:'',
                    hetongId:'',

                },
                //付款界面数据
                rokeBackForm: {
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


                //被选中的权限
                checked:[],
            }
        },
        methods:{
            formatFKType(row, column){
                let status = [];
                status[0] = '押金';
                status[1] = '房租';
                return status[row.fktype];
            },
            //修改状态显示转换
            formatUpdateState: function (row, column) {
                let status = [];
                status[0] = '正常';
                status[1] = '已修改';
                return status[row.xiugaizhuangtai];
            },
            //状态显示转换
            formatState: function (row, column) {
                let status = [];
                status[0] = '未提交';
                status[1] = '已提交';
                status[2] = '部分已付';
                status[3] = '已完成';
                status[4] = '已驳回';
                return status[row.fkstate];
            },
            //收款账号显示转换
            formatskyh: function (row, column) {
                return  row.skyinhang==null?'':row.skyinhang+"\r账号:"+row.skzhanhu==null?'': row.skzhanhu;

            },
            formatxm: function (row, column) {
                return  row.loupanName==null?'':row.loupanName+row.loudongName==null?'': row.loudongName+row.houseno==null?'': row.houseno;
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.skdate);
                return newDate.toLocaleDateString()
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

            //获取应收款列表
            getReceivable() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    page: this.page,
                    pageSize: this.pageSize,
                    contractNo: this.filters.contractNo,
                    xm: this.filters.xm,
                    yz: this.filters.yz,
                    zt: this.filters.zt,
                    startdate: this.filters.startdate,
                    enddate: this.filters.enddate,
                };
                this.listLoading = true;
                getReceivableListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.Receivable = res.data.data;
                    this.DataSum=res.data.dataSum;
                    this.listLoading = false;
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {

                this.editDateFormVisible = true;
                this.editDateForm = Object.assign({}, row);
                this.editDateForm = {
                    tiQianDays:'',
                    isBenQi:'',
                    tCwSrId:row.tCwSrId,
                    hetongId:row.hetongid,
                };
            },
            //显示编辑界面
            handleMoneyEdit: function (index, row) {

                this.editMoneyFormVisible = true;
                this.editMoneyForm = Object.assign({}, row);
                this.editMoneyForm = {
                    shouKuanMoney:'',
                    yuanMoney:'',
                    tCwSrId:row.tCwSrId,
                    hetongId:row.hetongid,
                };
            },
            //显示付款界面
            handleRokeBack: function (index, row) {
                this.rokeBackFormVisible = true;
                this.rokeBackForm  = Object.assign({}, row);
                this.rokeBackForm = {
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
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editDateFormLoading = true;
                            let para = Object.assign({}, this.editDateForm);
                            skeditDate(para).then((res) => {
                                this.editDateFormLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editDateForm'].resetFields();
                                this.editDateFormVisible = false;
                                this.getReceivable();
                            });
                        });
                    }
                });
            },
            editMoneyFormSubmit: function () {
                this.$refs.editMoneyForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editMoneyFormLoading = true;
                            let para = Object.assign({}, this.editMoneyForm);
                            skeditMoney(para).then((res) => {
                                this.editMoneyFormLoading = false;
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editMoneyForm'].resetFields();
                                this.editMoneyFormVisible = false;
                                this.getReceivable();
                            });
                        });
                    }
                });
            },
            //收款
            rokeBackSubmit: function () {
                this.$refs.rokeBackForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.rokeBackLoading = true;
                            let para = Object.assign({}, this.rokeBackForm);
                            saveShouKuan(para).then((res) => {
                                this.rokeBackLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['rokeBackForm'].resetFields();
                                this.rokeBackFormVisible = false;
                                this.getReceivable();
                            });
                        });
                    }
                });
            },
            //打开应付记录页面
            handleOpen: function (index, row)  {
                window.open('#/accountsReceivable?id=' + row.tCwSrId);
            },
            handleOpenUp: function (index, row) {
                window.open('#/receivableRecord?id=' + row.tCwSrId);
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;
            this.getReceivable();

        }
    }
</script>
