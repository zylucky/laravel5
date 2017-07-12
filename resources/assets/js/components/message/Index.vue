
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-table :data="messageDate"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="compayname" label="编号"  sortable>
            </el-table-column>
            <el-table-column prop="compaytest" label="内容"  sortable>
            </el-table-column>
            <el-table-column prop="yjzbSf" label="创建人"  sortable>
            </el-table-column>
            <el-table-column prop="createdate" label="创建时间" :formatter="changeDate" sortable>
            </el-table-column>
            <el-table-column prop="yjType" label="优先级"  :formatter="formatYJType" sortable>
            </el-table-column>
            <el-table-column prop="yjType" label="类别"  :formatter="formatYJType" sortable>
            </el-table-column>
            <el-table-column prop="tbPersonIdCreate" label="状态"     sortable>
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item  > <el-button     @click="handleAccept(scope.$index, scope.row)">接&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;受</el-button> </el-dropdown-item>
                            <el-dropdown-item  > <el-button   @click="handleRefuse(scope.$index, scope.row)">拒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;绝</el-button> </el-dropdown-item>
                            <el-dropdown-item  >  <el-button   @click="handleEdit(scope.$index, scope.row)">查看详情</el-button> </el-dropdown-item>
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
                    :page-sizes="pageSizes"
                    :page-size="10"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right"
            >
            </el-pagination>
        </el-col>
        <!--查看界面-->
        <el-dialog title="详情" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="120px" ref="editForm">
                <el-form-item label="编号：" prop="compayname">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="内容：" prop="yjzbSf">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="创建人：" prop="yjzbCf">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="创建时间：" prop="compayname">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="优先级：" prop="yjzbSf">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="类别：" prop="yjzbCf">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="状态："   prop="yjType">
                    {{editForm.compayname}}
                </el-form-item>

            </el-form>

        </el-dialog>

    </el-row>
</template>
<script>


    import {
        getMessageListPage,
        AcceptMessage,
        RefuseMessage,

    } from '../../api/api';

    export default{

        data(){

            return {
                filters:{
                    bk_name:'',
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
                messageDate:[],
                listLoading: false,
                sels: [],//列表选中列

                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {

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

            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
               // console.log(`当前页: ${val}`);
               this.getMessage();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                //console.log(`每页 ${val} 条`);

                this.getMessage();
            },
            //获取消息列表
            getMessage() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name
                };
                this.listLoading = true;
                getMessageListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.messageDate = res.data.data;
                    this.listLoading = false;
                });
            },
            //接受按钮
            handleAccept: function (index, row) {
                this.$confirm('确认接受吗？', '提示', {}).then(() => {
                    this.editLoading = true;
                    let para = {
                        tQdApplyId:row.tQdApplyId,
                    }
                    //console.log(para);
                    finishSK(para).then((res) => {
                        this.editLoading = false;
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.$refs['editForm'].resetFields();
                        this.editFormVisible = false;
                        this.getShouFang();
                    });
                });
            },
            //拒绝按钮
            handleRefuse: function (index, row) {
                this.$confirm('确认拒绝吗？', '提示', {}).then(() => {
                    this.editLoading = true;
                    let para = {
                        tQdApplyId:row.tQdApplyId,
                    }
                    //console.log(para);
                    finishSK(para).then((res) => {
                        this.editLoading = false;
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.$refs['editForm'].resetFields();
                        this.editFormVisible = false;
                        this.getShouFang();
                    });
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


            selsChange: function (sels) {
                this.sels = sels;
            },

        },


        mounted() {
            this.page=1;
            this.getMessage();

        }
    }
</script>
