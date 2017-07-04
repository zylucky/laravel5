
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.name" placeholder="请输入项目"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search" @click="purchaseContractList">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="addContract"> 新增</el-button>
                <el-button type="primary" class="el-icon-upload2" @click="uploadImg">上传</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column  prop="bianhao" label="编号" >
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"  sortable>
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋"   sortable>
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号"  sortable>
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态" :formatter="formatStatus" sortable>
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
                            <el-dropdown-item  ><el-button @click="handleEdit(scope.$index, scope.row)">编辑</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleReview(scope.$index, scope.row)">审核</el-button> </el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleDump(scope.$index, scope.row)">打印</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleConfirm(scope.$index, scope.row)">确认</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleOptimize(scope.$index, scope.row)">优化</el-button></el-dropdown-item>
                            <el-dropdown-item  ><el-button @click="handleDel(scope.$index, scope.row)">删除</el-button></el-dropdown-item>
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
    import {getPurchaseContractList,confirmPurchaseContract} from '../../api/api.js';
    export default {
        data() {
            return {
                filters: {
                    name: '',
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
            //新增
            addContract() {
                this.$router.push("purchaseContract/add");
            },
            formatStatus(row, column){
                let status = [];
                status[0] = '已创建';
                status[1] = '待审核';
                status[2] = '审核中';
                status[3] = '待打印';
                status[4] = '审核拒绝';
                status[5] = '待确认';
                status[6] = '履约中';
                return status[row.zhuangtai];
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.qianyuedate);
                return newDate.toLocaleDateString()
            },
            //获取合同列表
            purchaseContractList() {
                let para = {
                    pn: this.page,
                    cnt: this.pageSize,
                    selectItem:this.filters.name,
                }
                this.listLoading = true;
                getPurchaseContractList(para).then((res) => {
                    //console.log(res.data)
//                    this.total = res.data.total;

                    this.lists = res.data.data;
                    this.listLoading = false;
                });
            },
            handleSizeChange(val) {
                this.pageSize =val;
                this.purchaseContractList();
            },
            handleCurrentChange(val) {
                this.page = val;
                this.purchaseContractList();
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            uploadImg(){
                this.$router.push('/purchaseContract/upload');
            },
            handleEdit(index,row){
                this.$router.push('/purchaseContract/edit?id='+row.id);
            },
            handleReview(index,row){
                this.$router.push('/purchaseContract/review?id='+row.id);
            },
            handleOptimize(index,row){
                this.$router.push('/purchaseContract/optimize?id='+row.id);
            },
            handleDump(index,row){
                window.open('/#/purchaseContract/dump?id='+row.id)
                //this.$router.push('/purchaseContract/dump?id='+row.id);
            },
            //合同确认
            handleConfirm(index,row){
                let para = {
                    id:row.id,
                }
                confirmPurchaseContract(para).then((res)=>{
                    if(res.data.code == 200)　{
                        this.$message({
                            message: '合同确认成功',
                            type: 'success'
                        });
                        this.purchaseContractList();
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                })
            },

        },
        mounted(){
            this.purchaseContractList();
        }

    }
</script>
