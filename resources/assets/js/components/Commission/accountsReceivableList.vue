
<template>
    <el-row >
        <div style="margin-top:30px"></div>

        <el-table :data="AccountsReceivable" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="compayname" label="收款日"  >
            </el-table-column>
            <el-table-column prop="compayname" label="收款周期"  >
            </el-table-column>
            <el-table-column prop="compaytest" label="收款项目"   >
            </el-table-column>
            <el-table-column prop="yjzbSf" label="收款金额" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="月租金（元）" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="是否需要发票" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="是否收款" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="是否已开发票" >
            </el-table-column>
            <el-table-column label="操作" width="200">
                   <template scope="scope">
                       <el-button    size="small"  @click="handleRokeBack(scope.$index, scope.row)">收款</el-button>
                       <el-button    size="small"  @click="handleRokeBack(scope.$index, scope.row)">收款记录</el-button>
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
        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="120px" :rules="editFormRules" ref="editForm"  >
                <el-input type="hidden" prop="tQdCompayId"  auto-complete="off"></el-input>
                <el-form-item label="付款日期" prop="fkrq">
                    <el-date-picker type = "date" v-model="editForm.fkrq" auto-complete="off">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="付款周期" required>
                    <el-col :span="8">
                        <el-form-item   prop="fkstaDate" >
                            <el-date-picker type = "date" v-model="editForm.fkstaDate" auto-complete="off">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col class="line" :span="2">至</el-col>
                    <el-col :span="8">
                        <el-form-item   prop="fkendDate" >
                            <el-date-picker type = "date" v-model="editForm.fkendDate" auto-complete="off">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-form-item>
                <el-form-item label="付款金额" prop="fkje">
                    <el-input  type="number"  v-model="editForm.fkje" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item   label="是否需要发票" prop="isFP">
                    <el-radio-group v-model="editForm.isFP">
                        <el-radio class="radio" label=1>是</el-radio>
                        <el-radio class="radio" label=2>否</el-radio>
                    </el-radio-group>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="120px" :rules="addFormRules" ref="addForm"  >
                <el-input type="hidden" prop="tQdCompayId"  auto-complete="off"></el-input>
                <el-form-item label="付款日期" prop="fkrq">
                    <el-date-picker type = "date" v-model="addForm.fkrq" auto-complete="off">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="付款周期" required>
                    <el-col :span="8">
                        <el-form-item   prop="fkstaDate" >
                        <el-date-picker type = "date" v-model="addForm.fkstaDate" auto-complete="off">
                        </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col class="line" :span="2">至</el-col>
                    <el-col :span="8">
                        <el-form-item   prop="fkendDate" >
                        <el-date-picker type = "date" v-model="addForm.fkendDate" auto-complete="off">
                        </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-form-item>
                <el-form-item label="付款金额" prop="fkje">
                    <el-input  type="number"  v-model="addForm.fkje" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item   label="是否需要发票" prop="isFP">
                    <el-radio-group v-model="addForm.isFP">
                        <el-radio class="radio" label=1>是</el-radio>
                        <el-radio class="radio" label=2>否</el-radio>
                    </el-radio-group>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
            </div>
        </el-dialog>
        <el-dialog title="收款" v-model="rokeBackFormVisible" :close-on-click-modal="false">
            <el-form :model="rokeBackForm" label-width="120px" :rules="rokeBackFormRules" ref="rokeBackForm"  >
                <el-input type="hidden" prop="tQdCompayId"  auto-complete="off"></el-input>

                <el-form-item label="收款类型"    prop="skType">
                    <el-select v-model="rokeBackForm.skType" placeholder=""   >
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </el-form-item>
                    <el-form-item label="金额" prop="meoney">
                        <el-input type="number"  v-model="rokeBackForm.meoney" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="收款日期" prop="skrq">
                        <el-date-picker type = "date" v-model="rokeBackForm.skrq" auto-complete="off">
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item   label="备注" prop="test">
                        <el-input type="textarea" v-model="rokeBackForm.memo" auto-complete="off"></el-input>
                    </el-form-item>
            </el-form>
                    <div slot="footer" class="dialog-footer">
                        <el-button @click.native="rokeBackFormVisible = false">取消</el-button>
                        <el-button type="primary" @click.native="rokeBackSubmit" :loading="rokeBackLoading">保存</el-button>
                    </div>
        </el-dialog>
    </el-row>
</template>
<script>

    import {
        getAccountsReceivableListPage,
        editReceivable,
        saveShouKuan,
        removeReceivable,
        addReceivable,

    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
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
                AccountsReceivable:[],
                listLoading: false,
                sels: [],//列表选中列

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
                //收款界面数据
                rokeBackForm: {
                    tQdCompayId:0,
                    skType:1,
                    meoney:'',
                    skrq:'',
                    memo:'',
                },
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    fkrq: [
                        { type: 'date', required: true, message: '请输入付款日期', trigger: 'change' }
                    ],
                    fkstaDate: [
                        { type: 'date', required: true, message: '请输入付款周期', trigger: 'change' }
                    ],
                    fkendDate: [
                        { type: 'date', required: true, message: '请输入付款周期', trigger: 'change' },
                        {  required: true,validator:(rule,value,callback)=>{
                            var d1= new Date( this.editForm.fkstaDate);
                            var d2= new Date(value);
                            if(d2<d1){
                                callback(new Error("付款周期的结束日期不能小于开始日期"));
                            }else{
                                callback();
                            }
                        }, trigger:'change'}
                    ],
                    fkje: [
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error("请输入付款金额"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    isFP: [
                        { required: true, message: '请选择是否需要发票', trigger: 'blur' }
                    ],
                },
                //编辑界面数据
                editForm: {
                    tQdCompayId:0,
                    fkrq:'',
                    fkstaDate:'',
                    fkendDate:'',
                    fkje:'',
                    isFP:1,
                },

                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    fkrq: [
                        { type: 'date', required: true, message: '请输入付款日期', trigger: 'change' }
                    ],
                    fkstaDate: [
                        { type: 'date', required: true, message: '请输入付款周期', trigger: 'change' }
                    ],
                    fkendDate: [
                        { type: 'date', required: true, message: '请输入付款周期', trigger: 'change' },
                        {  required: true,validator:(rule,value,callback)=>{
                            var d1= new Date( this.editForm.fkstaDate);
                            var d2= new Date(value);
                            if(d2<d1){
                                callback(new Error("付款周期的结束日期不能小于开始日期"));
                            }else{
                                callback();
                            }
                        }, trigger:'change'}
                    ],
                    fkje: [
                        {required: true,validator:(rule,value,callback)=>{
                            if(/^\d+$/.test(value) == false){
                                callback(new Error("请输入付款金额"));
                            }else{
                                callback();
                            }
                        }, trigger:'blur'}
                    ],
                    isFP: [
                        { required: true, message: '请选择是否需要发票', trigger: 'blur' }
                    ],
                },
                //新增界面数据
                addForm: {
                    tQdCompayId:0,
                    fkrq:'',
                    fkstaDate:'',
                    fkendDate:'',
                    fkje:'',
                    isFP:1,
                },
                //被选中的权限
                checked:[],
            }
        },
        methods:{
            //佣金类型显示转换
            formatYJType: function (row, column) {
                return row.yjType == 1 ? '押金' : row.yjType == 2 ? '房租' : '未知';
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
                this.getAccountsReceivable();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getAccountsReceivable();
            },

            //获取应收款记录列表
            getAccountsReceivable() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                };
                this.listLoading = true;
                getAccountsReceivableListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.AccountsReceivable = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示收款界面
            handleRokeBack: function (index, row) {
                this.rokeBackFormVisible = true;
                this.rokeBackForm  = Object.assign({}, row);
                this.rokeBackForm = {
                    tQdCompayId:row.tQdCompayId,
                    skType:1,
                    meoney:'',
                    skrq:'',
                    memo:'',
                };
            },
            //显示新增界面
            handleAdd: function () {
                this.addFormVisible = true;
                this.addForm = {
                    fkrq:'',
                    fkstaDate:'',
                    fkendDate:'',
                    fkje:'',
                    isFP:1,
                };
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
                this.editForm = {
                    tQdCompayId:row.tQdCompayId,
                    fkrq:'',
                    fkstaDate:'',
                    fkendDate:'',
                    fkje:'',
                    isFP:2,
                };
            },

            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
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
                                this.getAccountsReceivable();
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
                                this.getAccountsReceivable();
                            });
                        });
                    }
                });
            },
            //新增
            addSubmit: function () {
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.addForm);
                            para.fkrq = new Date(para.fkrq).toLocaleDateString() ;
                            para.fkstaDate = new Date(para.fkstaDate).toLocaleDateString() ;
                            para.fkendDate = new Date(para.fkendDate).toLocaleDateString() ;
                            addReceivable(para).then((res) => {
                                this.addLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['addForm'].resetFields();
                                this.addFormVisible = false;
                                this.getAccountsReceivable();
                            });
                        });
                    }
                });
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            //删除
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { id: row.tQdCompayId  };
                    removeReceivable(para).then((res) => {
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
                        this.getAccountsReceivable();
                    });
                }).catch(() => {

                });
            },
        },
        mounted() {
            this.page=1;
            this.getAccountsReceivable();

        }
    }
</script>
