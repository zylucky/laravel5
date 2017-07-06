
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.name" placeholder="请输入项目"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search" @click="saleContractList">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="addContract"> 新增</el-button>
                <el-button type="primary" class="el-icon-upload2" @click="uploadImg">上传</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="bianhao" label="编号" width="200">
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"  sortable>
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋"   sortable>
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号"  sortable>
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态" :formatter="formatStatus"  sortable>
            </el-table-column>
            <el-table-column prop="qianyuedate" label="签约日" :formatter="changeDate"  sortable>
            </el-table-column>
            <el-table-column label="操作" width="170">
                <template scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item  ><el-button @click="handleEdit(scope.$index, scope.row)">编辑合同</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleReview(scope.$index, scope.row)">审核合同</el-button> </el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleDump(scope.$index, scope.row)">打印合同</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleConfirm(scope.$index, scope.row)">确认合同</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleWeiyue(scope.$index, scope.row)">违  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;约</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleJieyue(scope.$index, scope.row)">解约协议</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleCheckJieyue(scope.$index, scope.row)">查看协议</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button type="danger" @click="handleDel(scope.$index, scope.row)">删除合同</el-button></el-dropdown-item>
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
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right"
            >
            </el-pagination>
        </el-col>
    </el-row>
</template>
<script>
    import {getSaleContractList,removeSaleContract} from '../../api/api.js';
    export default {
        data() {
            return {
                filters: {
                    name: '',
                    region: ''
                },
                //分页类数据
                total:100,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                lists:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        methods: {
            //搜索
            search(){

            },
            getUsers() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    name: this.filters.name
                };
                this.listLoading = true;
                getUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.users = res.data.data;
                    this.listLoading = false;
                });
            },
            //新增
            addContract() {
                var _this = this;
                    _this.$router.push("/saleContact/Add");
            },
            formatStatus(row, column){
                let status = [];
                status[0] = '已创建';
                status[1] = '已提交';
                status[2] = '审核中';
                status[3] = '待打印';
                status[4] = '审核拒绝';
                status[5] = '正在确认';
                status[6] = '履约中';
                status[7] = '违约处理中';
                status[8] = '合同终止';
                status[9] = '解约中';
                status[10] = '解约完成';
                status[11] = '已完成';
                return status[row.zhuangtai];
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.qianyuedate);
                return newDate.toLocaleDateString()
            },
            //获取合同列表
            saleContractList() {
                let para = {
                    pn: this.page,
                    cnt: this.pageSize,
                    /*name:'',*/
                    selectItem:this.filters.name,
                }
                this.listLoading = true;
                getSaleContractList(para).then((res) => {
                    //console.log(res.data.data)
                    this.lists = res.data.data;
                    this.listLoading = false;

                });
            },
            handleSizeChange(val) {
                /*console.log(`每页 ${val} 条`);*/
                this.pageSize =val;
                this.saleContractList();
            },
            handleCurrentChange(val) {
                /*console.log(`当前页: ${val}`);*/
                this.page = val;
                this.saleContractList();
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            uploadImg(){
                var _this = this;
                _this.$router.push('/saleContact/upload');
            },
            handleEdit(index,row){
                //
                //var _this = this;
                //this.$router.push('/saleContact/edit?id='+row.id);
                this.$router.push('/saleContract/edit?id='+row.id);
                //
                // this.$router.push('/purchaseContact/add?id='+row.id);
            },
            handleReview(index,row){
                this.$router.push('/saleContract/review?id='+row.id);
            },
            handleJieyue(index,row){
                this.$router.push('/saleContract/jieyue?id='+row.id);
            },
            handleCheckJieyue(index,row){
                this.$router.push('/saleContract/checkJieyue?id='+row.id);
            },
            handleWeiyue(index,row){
               /* this.$router.push('/saleContract/weiyue?id='+row.id);*/
            },
            handleDump(index,row){
                window.open('/#/saleContract/dump?id='+row.id)
                /*this.$router.push('/saleContract/dump?id='+row.id);*/
            },
            handleDel(index,row){
                this.$confirm('确认删除该记录吗？','提示',{
                    type:'warning'
                }).then(()=>{
                    this.listLoading = true;
                    let para = { id: row.id};
                    removeSaleContract(para).then((res) =>
                    {
                        this.listLoading = false;
                        this.message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getUsers();
                    });
                }).catch(() => {

                });
            }
        },
        mounted(){
            this.saleContractList();
        }

    }
</script>
