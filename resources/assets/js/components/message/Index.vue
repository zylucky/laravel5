
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-table :data="messageDate"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="id" label="编号"  width="100" sortable>
            </el-table-column>
            <el-table-column prop="title" label="标题"  >
            </el-table-column>
            <el-table-column prop="content" label="内容"  width="300" >
            </el-table-column>
            <el-table-column prop="creatorname" label="创建人"  >
            </el-table-column>
            <el-table-column prop="creationtime" label="创建时间" :formatter="changeDate" sortable>
            </el-table-column>
            <el-table-column prop="priority" label="优先级"  :formatter="formatYXJ">
            </el-table-column>
            <el-table-column prop="category" label="类别"  :formatter="formatType" >
            </el-table-column>
            <el-table-column prop="status" label="状态" :formatter="formatZT"  width="100" >
            </el-table-column>
            <el-table-column label="操作" width="130">
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
                <el-form-item label="标题：" prop="title">
                    {{editForm.title}}
                </el-form-item>
                <el-form-item label="内容：" prop="content">
                    {{editForm.content}}
                </el-form-item>
                <el-form-item label="创建人：" prop="creatorname">
                    {{editForm.creatorname}}
                </el-form-item>
                <el-form-item label="创建时间：" prop="creationtime">
                    {{changeXQDate(editForm.creationtime)}}
                </el-form-item>
                <el-form-item label="优先级：" prop="yjzbSf">
                    {{editForm.compayname}}
                </el-form-item>
                <el-form-item label="类别：" prop="yjzbCf">
                    {{editForm.category}}
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
            //优先级
            formatYXJ: function (row, column) {
                let status = [];
                status[0] = '低';
                status[1] = '中';
                status[2] = '高'; ;
                return status[row.priority];
            },
            //类型：0,日程提醒；1,通知；2,任务；3,调查评测
            formatType: function (row, column) {
                let status = [];
                status[0] = '日程提醒';
                status[1] = '通知';
                status[2] = '任务';
                status[3] = '调查评测';
                return status[row.category];
            },
            //状态任务的状态。1，已创建；2，已送达，3，已读；4，已接受，5，拒绝接受；6，已办；7，已确认；8，已关闭
            formatZT: function (row, column) {
                let status = [];
                status[1] = '已创建';
                status[2] = '已送达';
                status[3] = '已读';
                status[4] = '已接受';
                status[5] = '拒绝接受';
                status[6] = '已办';
                status[7] = '已确认';
                status[8] = '已关闭';
                return status[row.status];
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
            changeDate(row, column){
                if(row.creationtime!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.creationtime);
                    return newDate.toLocaleDateString()
                }
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
                    let para = {
                        id:row.id,
                    }
                    AcceptMessage(para).then((res) => {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.getMessage();
                    });
                });
            },
            //拒绝按钮
            handleRefuse: function (index, row) {
                this.$confirm('确认拒绝吗？', '提示', {}).then(() => {
                    let para = {
                        id:row.id,
                    }
                    RefuseMessage(para).then((res) => {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.getMessage();
                    });
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
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
