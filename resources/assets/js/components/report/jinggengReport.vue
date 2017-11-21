
<template>
    <el-row >
        <el-form   :inline="true" :model="filters"  class="demo-form-inline">
            <el-row>

            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getjinggengReport">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"     @click="handleExport"    > 导出</el-button>
            </el-form-item>
        </el-row>
        </el-form>
        <el-table :data="chuFang"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="topic" label="楼盘"  width="150"    >
            </el-table-column>
            <el-table-column prop="zdh" label="楼栋"  width="80"  >
            </el-table-column>
            <el-table-column prop="fybh" label="房间号"   width="80"  >
            </el-table-column>
            <el-table-column prop="fjmj" label="面积" width="90" >
            </el-table-column>
            <el-table-column prop="price" label="单价（元/㎡/天）"  width="160"  >
            </el-table-column>
            <el-table-column prop="fjyzj" label="月租金"   width="110" >
            </el-table-column>
            <el-table-column prop="hyzt" label="航远房源"    width="120" >
            </el-table-column>
            <el-table-column prop="kzzt" label="空置状态"   width="110" >
            </el-table-column>
            <el-table-column prop="sfzc" label="支持注册"    width="120" >
            </el-table-column>
            <el-table-column prop="yzsx" label="业主属性" width="120" >
            </el-table-column>
            <el-table-column prop="yzdh" label="业主电话"   width="120">
            </el-table-column>
            <el-table-column prop="bzxzyz" label="可租状态评估"   width="130"  >
            </el-table-column>
            <el-table-column prop="bzxzyz" label="本周新增"  width="120" >
            </el-table-column>
            <el-table-column prop="bzxzyz" label="本周已租"  width="120" >
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
    </el-row>
</template>
<script>
    import {
        getjinggengReportListPage,
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    export default{
        components: {ElRow},
        data(){
            return {
                filters:{
                    startdate: '',
                    enddate: '',
                },
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                chuFang:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        methods:{
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
               // console.log(`当前页: ${val}`);
               this.getjinggengReport();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                //console.log(`每页 ${val} 条`);
                this.getjinggengReport();
            },
            //获取渠道公司列表
            getjinggengReport() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    startdate:this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString(),
                    enddate: this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString(),
                };
                this.listLoading = true;
                getjinggengReportListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.chuFang = res.data.data;
                    this.listLoading = false;
                });
            },
            handleExport: function () {
                var sDate=this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString();
                var eDate=this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString() ;
                window.open("/jinggengReport/ExportExcel?startdate="+sDate+"&enddate="+ eDate);
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.page=1;
            this.getjinggengReport();
        }
    }
</script>
