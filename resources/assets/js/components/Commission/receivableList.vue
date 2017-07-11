
<template>
    <el-row >
        <div style="margin-top:30px"></div>
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
            <el-date-picker type = "date" placeholder="应付日期" v-model="filters.startdate">
            </el-date-picker>
            <el-date-picker type = "date" placeholder="至" v-model="filters.enddate">
            </el-date-picker>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getReceivable">搜索</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="Receivable" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="htbianhao" label="合同编号"     >
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"   >
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋" >
            </el-table-column>
            <el-table-column prop="houseno" label="房间号" >
            </el-table-column>
            <el-table-column prop="zuhu" label="租户" >
            </el-table-column>
            <el-table-column prop="skdate" label="收款日" :formatter="changeDate" >
            </el-table-column>
            <el-table-column prop="zhouqi" label="周期" >
            </el-table-column>
            <el-table-column prop="sktype" label="付款方式" :formatter="formatFKType"  >
            </el-table-column>
            <el-table-column prop="skmoney" label="应收房租" >
            </el-table-column>
            <el-table-column prop="monthmoney" label="月租金"  >
            </el-table-column>
            <el-table-column prop="compayname" label="户名"  >
            </el-table-column>
            <el-table-column prop="skyinhang" label="收款银行"   width="200" :formatter="formatskyh"  >
            </el-table-column>
            <el-table-column prop="srstate" label="状态"  :formatter="formatState"  width="100">
            </el-table-column>
            <el-table-column label="操作" width="180">
                   <template scope="scope">
                       <el-dropdown   menu-align="start">
                           <el-button type="primary" size="normal" splitButton="true">
                               操作<i class="el-icon-caret-bottom el-icon--right"></i>
                           </el-button>
                           <el-dropdown-menu slot="dropdown" >
                               <el-dropdown-item  > <el-button   @click="handleRokeBack(scope.$index, scope.row)">收&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;款</el-button> </el-dropdown-item>
                               <el-dropdown-item  > <el-button   @click="handleOpen(scope.$index, scope.row)">应收记录</el-button> </el-dropdown-item>
                           </el-dropdown-menu>
                       </el-dropdown>
                   </template>
            </el-table-column>
           </el-table>
           <div style="margin-top:30px"></div>
           <!-- 分页-->
        <el-col :span="24" class="toolbar" >
            应收房租：应收押金：合计：
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
        <el-dialog title="收款" v-model="rokeBackFormVisible" :close-on-click-modal="false">
            <el-form :model="rokeBackForm" label-width="120px" :rules="rokeBackFormRules" ref="rokeBackForm"  >
                <el-input type="hidden" prop="tQdCompayId"  v-model="rokeBackForm.tQdCompayId" auto-complete="off"></el-input>
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
                        <el-date-picker type = "date" v-model="rokeBackForm.skrq"   auto-complete="off">
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
        getReceivableListPage,
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
                    buildingname:'',
                    buildname:'',
                    roomname:'',
                    startdate:'2017-07-01',
                    enddate:'2017-07-31',

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
                Receivable:[],
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
                    fkrq:'',
                    fkstaDate:'',
                    fkendDate:'',
                    fkje:'',
                    isFP:'',
                },

                //收款界面数据
                rokeBackForm: {
                    tQdCompayId:0,
                    skType:1,
                    meoney:'',
                    skrq:'',
                    memo:'',
                },

                //被选中的权限
                checked:[],
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
                return status[row.sktype];
            },
            //状态显示转换
            formatState: function (row, column) {
                let status = [];
                status[0] = '未付';
                status[1] = '已付';
                return status[row.srstate];
            },
            //银行账号显示转换
            formatskyh: function (row, column) {

                return  row.skyinhang+"\r账号:"+row.skzhanhu ;
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
                    buildingname: this.filters.buildingname,
                    buildname: this.filters.buildname,
                    roomname: this.filters.roomname,
                    startdate: this.filters.startdate,
                    enddate: this.filters.enddate,
                };
                this.listLoading = true;
                getReceivableListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.Receivable = res.data.data;
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
                    skrq:'2017-07-05',
                    memo:'',
                };
            },
            //显示编辑界面
            handleEdit: function (index, row) {

                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
                this.editForm = {
                    fkrq:'',
                    fkstaDate:'',
                    fkendDate:'',
                    fkje:'',
                    isFP:1,
                };
            },
            //打开应收记录页面
            handleOpen: function () {
                window.open('#/accountsReceivable');
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
                                this.getReceivable();
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
            this.page=1;
            this.getReceivable();

        }
    }
</script>
