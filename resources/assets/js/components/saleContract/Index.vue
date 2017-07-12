
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
                <!--<el-button type="primary" class="el-icon-upload2" @click="uploadImg">上传</el-button>-->
            </el-form-item>
        </el-form>
        <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column prop="bianhao" label="编号" width="200" >
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
                            <el-dropdown-item  ><el-button @click="handlSee(scope.$index, scope.row)">查看合同</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[0,4,5])"><el-button @click="handleEdit(scope.$index, scope.row)">编辑合同</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[1,2])"><el-button @click="handleReview(scope.$index, scope.row)">审核合同</el-button> </el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[3])"><el-button @click="handleDump(scope.$index, scope.row)">打印合同</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[5])"><el-button @click="handleConfirm(scope.$index, scope.row)">签约成功</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[6,7])"><el-button @click="handleWeiyue(scope.$index, scope.row)">违 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;约</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[9])"><el-button @click="handleJieyue(scope.$index, scope.row)">解 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;约</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[10])"><el-button @click="handleJieyuewancheng(scope.$index, scope.row)">解约完成</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[10])"><el-button @click="handleCheckJieyue(scope.$index, scope.row)">查看协议</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleEnd(scope.$index, scope.row)">终止合同</el-button></el-dropdown-item>
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
    import {
        getSaleContractList,
        removeSaleContract,
        confirmSaleContract,
        weiyueSaleContract,
        endSaleContract,
        jieyueSaleContract,
        dumpingPurchaseContract,
        approvingSaleContract,} from '../../api/api.js';
    export default {
        data() {
            return {
                filters: {
                    name: '',
                    region: ''
                },
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                lists:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        components:{

        },
        methods: {
            ztin(row,arr){
                var status = arr.indexOf(row.zhuangtai);
                if(status>-1){
                    return true;
                }else{
                    return false;
                }
            },
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
                status[3] = '等待打印';
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
                    selectItem: this.filters.name,
                }
                this.listLoading = true;
                getSaleContractList(para).then((res) => {
                    //console.log(res.data.data)
                    this.total = res.data.total;
                    this.lists = res.data.data;
                    this.listLoading = false;

                });
            },
            handleSizeChange(val) {
                /*console.log(`每页 ${val} 条`);*/
                this.pageSize = val;
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
            handlSee(index, row){
                /*let para = {
                    id:row.id,
                }*/
                this.$router.push('/saleContract/see?id=' + row.id);
            },
            handleEdit(index, row){
                let para = {
                    id:row.id,
                }
                //
                //var _this = this;
                //this.$router.push('/saleContact/edit?id='+row.id);
                this.$router.push('/saleContract/edit?id=' + row.id);
                //
                // this.$router.push('/purchaseContact/add?id='+row.id);
            },
            handleReview(index, row){
                let para = {
                    id:row.id,
                }
                approvingSaleContract(para).then((res)=>{
                });
                this.$router.push('/saleContract/review?id=' + row.id);
            },
            handleJieyue(index, row){
                this.$confirm('确认将合同设置为解约中吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    jieyueSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getUsers();
                    });
                }).catch(() => {

                });
            },
            handleJieyuewancheng(index, row){
                this.$router.push('/saleContract/jieyue?id=' + row.id);
            },
            handleCheckJieyue(index, row){
                this.$router.push('/saleContract/checkJieyue?id=' + row.id);
            },

            handleDump(index, row){
                window.open('/#/saleContract/dump?id=' + row.id)
                /*this.$router.push('/saleContract/dump?id='+row.id);*/
                let para = {
                    id:row.id,
                }
                //this.getPurchaseContractList();
                dumpingPurchaseContract(para).then((res)=>{
                    //this.getPurchaseContractList();
                });
                window.open('/#/purchaseContract/dump?id='+row.id)
            },
            handleDel(index, row){
                this.$confirm('确认删除该记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    removeSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getUsers();
                    });
                }).catch(() => {

                });
            },
            //合同确认
            handleConfirm(index, row){
                this.$confirm('确认合同已完成吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    //alert(00);
                    this.listLoading = true;
                    let para = {id: row.id};
                    //alert(11);
                    confirmSaleContract(para).then((res) => {
                        //alert(22);
                        this.listLoading = false;
                        //alert(33);
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },
            handleWeiyue(index, row){
                this.$confirm('确认将合同设置为违约中吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    weiyueSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },
            //终止 弹窗确认是否终止
            handleEnd(index, row){
                this.$confirm('确认合同终止吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    endSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },

        },
        mounted(){
            this.saleContractList();
        }

    }
    //vue中和后台交汇数据时，是
</script>
