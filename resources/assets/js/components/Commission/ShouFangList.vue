
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
            <el-checkbox v-model="filters.checked" @change="change">高级搜索</el-checkbox>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getBrokerCompanyUser">搜索</el-button>
            </el-form-item>
            <br/>
            <div v-show="showed" v-model="filters.showDiv">
            <el-form-item label=""  >
                <el-select v-model="filters.ZhuangTai" placeholder="状态">
                    <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>

            </el-form-item>
            <el-form-item label="">
                <el-input v-model="filters.personname" placeholder="渠道人员"></el-input>
            </el-form-item>
            <el-date-picker type = "date" placeholder="合同日期" v-model="filters.startdate">
            </el-date-picker>
            <el-date-picker type = "date" placeholder="至" v-model="filters.enddate">
            </el-date-picker>
            <el-date-picker type = "date" placeholder="佣金结算" v-model="filters.yjstartdate">
            </el-date-picker>
            <el-date-picker type = "date" placeholder="至" v-model="filters.yjenddate">
            </el-date-picker>
            </div>
        </el-form>

        <span  style="color:red;">注：负数=幼狮支出 正数=幼狮盈利 零=持平 佣金差额=业主实际支付佣金-华亮佣金 实际结款金额=佣金差额-其它金额</span>
        <el-table :data="brokerCompanyUser" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="compayname" label="合同签订日期"  >
            </el-table-column>
            <el-table-column prop="compaytest" label="楼盘"   >
            </el-table-column>
            <el-table-column prop="yjzbSf" label="楼栋" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="房间号" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="合同月租金" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="实际月租金" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="合同标注佣金" >
            </el-table-column>
            <el-table-column prop="compayname" label="业主实际支付佣金" >
            </el-table-column>
            <el-table-column prop="compayname" label="华亮佣金(实际月租金60%)" >
            </el-table-column>
            <el-table-column prop="compayname" label="佣金差额"  >
            </el-table-column>
            <el-table-column prop="compayname" label="其它金额"  >
            </el-table-column>
            <el-table-column prop="compayname" label="实际结款金额"  >
            </el-table-column>
            <el-table-column prop="compayname" label="渠道人员"  >
            </el-table-column>
            <el-table-column prop="compayname" label="佣金结算日"  >
            </el-table-column>
            <el-table-column prop="yjType" label="返佣状态" :formatter="formatYJType" >
            </el-table-column>

            <el-table-column label="操作" width="100">
                   <template scope="scope">
                       <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                       <el-button    size="small"  @click="handleRokeBack(scope.$index, scope.row)">确认</el-button>
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
                <el-input type="hidden" prop="tQdCompayName"  auto-complete="off"></el-input>
                <el-col :span="10">
                <el-form-item label="楼盘" prop="buildingname">
                    <el-input v-model="editForm.buildingname" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item label="楼栋" prop="buildname">
                    <el-input type="tel"  v-model="editForm.buildname" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item label="房间号" prop="roomname">
                    <el-input  type="number"  v-model="editForm.roomname" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="面积" prop="area">
                    <el-input type="number" v-model="editForm.area" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="合同月租金" prop="htyzj">
                    <el-input type="number" v-model="editForm.htyzj" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="实际月租金" prop="sjyzj">
                    <el-input type="number" v-model="editForm.sjyzj" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="合同标注佣金" prop="htbzyj">
                    <el-input type="number" v-model="editForm.htbzyj" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="业主实际支付佣金" prop="yzsjzf">
                    <el-input type="number" v-model="editForm.yzsjzf" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="华亮返佣(60%)" prop="hlfy">
                    <el-input type="number" v-model="editForm.hlfy" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
                <el-form-item   label="其他金额" prop="qtje">
                    <el-input  v-model="editForm.qtje" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
                <el-col :span="10">
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
                </el-col>
                <el-col :span="10">
                <!--渠道人员-->
                <el-form-item label="渠道人员" v-for="(item, index) in editForm.QDPersonList"
                              :key="item.key"
                              :prop="'QDPersonList.' + index + '.value'"
                >
                    <el-select
                            v-model="editForm.qdPername"
                            filterable
                            remote
                            @change="change"
                            placeholder="渠道人员"
                            :remote-method="remoteMethod1"
                            :loading="qdPernameloading">
                        <el-option
                                v-for="item in options1"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                    <el-button @click.prevent="removeFreeItem(item)">删除</el-button>

                </el-form-item>
                </el-col>


                <el-form-item>
                    <el-button  @click="addFreeItem">新增渠道人员</el-button>
                </el-form-item>
                <el-form-item   label="备注" prop="yjzbCf">
                    <el-input type="textarea" v-model="editForm.yjzbCf" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
        <el-dialog title="财务返佣" v-model="rokeBackFormVisible" :close-on-click-modal="false">
            <el-form :model="rokeBackForm" label-width="120px" :rules="rokeBackFormRules" ref="editForm"  >
                <el-input type="hidden" prop="tQdCompayName"  auto-complete="off"></el-input>
                <el-form-item label="操作人" prop="buildingname">
                    admin@qq.com
                </el-form-item>
                    <el-form-item label="渠道人员" prop="buildingname">
                        <el-input v-model="rokeBackForm.buildingname" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="返佣银行" prop="buildname">
                        <el-input type="tel"  v-model="rokeBackForm.buildname" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="返佣卡号" prop="roomname">
                        <el-input  type="number"  v-model="rokeBackForm.roomname" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item   label="实际返佣今晚" prop="area">
                        <el-input type="number" v-model="rokeBackForm.area" auto-complete="off"></el-input>
                    </el-form-item>

            </el-form>
                    <div slot="footer" class="dialog-footer">
                        <el-button @click.native="rokeBackFormVisible = false">取消</el-button>
                        <el-button type="primary" @click.native="editSubmit" :loading="rokeBackLoading">确认已返佣</el-button>
                    </div>
        </el-dialog>
    </el-row>
</template>
<script>

    import {
        getShouFangCommissionListPage,
        editBrokerCompanyUser,
        removeBrokerCompanyUser,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
       // getUserNameByID,


    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
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
                showed:false,
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
                qdPernameloading:false,
                options1:[],

                rokeBackFormVisible: false,//返佣界面是否显示
                rokeBackLoading: false,

                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {


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
                    QDPersonList: [{
                        qdPername:'',
                    }],
                },
                //编辑界面数据
                rokeBackForm: {
                    //compayname: '',
                    tQdCompayId:'',
                    qdPername:'',
                    qdPertel:'',
                    yjzbSf:'',
                    yjzbCf:'',
                    yjType:'',
                    QDPersonList: [{
                        qdPername:'',
                    }],
                },

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
            //增加渠道人员
            addFreeItem() {
                this.editForm.mianzuqiList.push({

                    mianzufangshi:'',
                    key: Date.now()
                });
            },
            //移除渠道人员
            removeFreeItem(item) {
                var index = this.editForm.mianzuqiList.indexOf(item)
                if (index !== -1) {
                    this.editForm.mianzuqiList.splice(index, 1)
                }
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
            //显示和隐藏高级搜索
            change(){
                //alert(this.editForm.tQdCompayId);

                if(this.filters.checked){
                    this.showed=true;
                }else{
                    this.showed=false;
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
                getShouFangCommissionListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompanyUser = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示返佣界面
            handleRokeBack: function (index, row) {
                // Console.log(row);
                this.rokeBackFormVisible = true;
                this.rokeBackForm  = Object.assign({}, row);
                // alert(this.editForm.tQdCompayName);
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                // Console.log(row);

                this.editForm.QDPersonList =   [{
                    qdPername:'1',
                    key: Date.now()
                }];
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
               // this.editForm.yjType= row.yjType == 1 ? '按月租金' : row.yjType == 2 ? '按年租金' : '未知';
                this.editForm.tQdCompayId= row.qvDaoCompayXinxi.compayname;
                this.editForm.tQdCompayName= row.qvDaoCompayXinxi.tQdCompayId;
                this.editForm.yjzbCf= row.yjzbCf.toString();
                this.editForm.yjzbSf= row.yjzbSf.toString();


                // alert(this.editForm.tQdCompayName);
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
