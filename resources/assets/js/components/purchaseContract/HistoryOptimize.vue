<template>
    <div>
        <!--列表页-->
        <el-table :data="youhuaList" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="bianhao" label="编号"   sortable>
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"   sortable>
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋"   >
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号"  >
            </el-table-column>
            <el-table-column prop="createtime" label="优化时间" :formatter="changeDate"   sortable>
            </el-table-column>

            <el-table-column label="操作" width="100">
                <template scope="scope">
                    <el-button type="small" size="small" @click="handleView(scope.$index, scope.row)">查看</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!-- 分页-->
        <el-col :span="24" class="toolbar">

            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="pageSizes"
                    :page-size="10"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right">
            </el-pagination>
        </el-col>
    </div>
</template>
<script>
    import {youhuaPurchaseContractList} from '../../api/api.js';
    export default{
        data(){
            return {
                youhuaList:[],
                //分页类数据
                total:15,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                users:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        methods:{
            getList(){
                youhuaPurchaseContractList(this.$route.query).then((res)=>{
                    this.youhuaList = res.data.data;
                    this.total = res.total;
                });
            },
            handleView(index,row){
                this.$router.push('/purchaseContract/checkOptimize?xyid='+row.id+'type==1');//查看
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getList();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getList();
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createtime);
                if(row.createtime!=null){
                    return newDate.toLocaleDateString()
                }
            },
            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted(){
            this.getList();
        }
    }
</script>