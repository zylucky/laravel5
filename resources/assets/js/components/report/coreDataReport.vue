
<template>
    <el-row >
        <el-form   :inline="true" :model="filters"  class="demo-form-inline">
            <el-row>
                <el-form-item label="项目名称:">
                    <el-input v-model="filters.xm" placeholder="请输入项目名称"></el-input>
                </el-form-item>

            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getprojectReport">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"     @click="handleExport"    > 导出</el-button>
            </el-form-item>
        </el-row>
        </el-form>
        <el-table :data="chuFang"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="pname" label="区域"  width="100">
            </el-table-column>
            <el-table-column label="分区"  prop="fd_name"  width="100">
            </el-table-column>
            <el-table-column prop="xmsx" label="类别"  width="95"  >
            </el-table-column>
            <el-table-column prop="Loupan_name" label="楼盘"  width="150"    >
            </el-table-column>
            <el-table-column prop="Loudong_name" label="楼栋"  width="80"  >
            </el-table-column>
            <el-table-column prop="Fanghao" label="房间号"   width="80"  >
            </el-table-column>
            <el-table-column prop="Qianyuemianji" label="面积" width="90" >
            </el-table-column>
            <el-table-column prop="Price" label="收购单价"  width="110"  >
            </el-table-column>
            <el-table-column prop="saleprice" label="出房单价"   width="110" >
            </el-table-column>
            <el-table-column prop="StartDate" label="产品收房日"    width="120" >
            </el-table-column>
            <el-table-column prop="cfdate" label="出房签约日" width="120" >
            </el-table-column>
            <el-table-column prop="kzts" label="空置天数"   width="120">
            </el-table-column>
            <el-table-column prop="cfcs" label="出房次数" width="120" >
            </el-table-column>
            <el-table-column prop="ZhongzhiDate" label="前租户房租截止日"   width="180">
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
        getcoreDataReportListPage,
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    export default{
        components: {ElRow},
        data(){
            return {
                filters:{
                    xm: '',
                    weekNum: this.addDate(new Date(),-7),
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
               this.getprojectReport();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                //console.log(`每页 ${val} 条`);
                this.getprojectReport();
            },
            //获取渠道公司列表
            getprojectReport() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    xm:this.filters.xm,
                };

                this.listLoading = true;
                getcoreDataReportListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.chuFang = res.data.data;
                    this.listLoading = false;
                });
            },
            handleExport: function () {
                var xm=this.filters.xm ;
                window.open("/coreDataReport/ExportExcel?xm="+xm );
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            addDate: function (date,days){
                var d=new Date(date);
                d.setDate(d.getDate()+days);
                var m=d.getMonth()+1;
                return d.getFullYear()+'-'+m+'-'+d.getDate();
            },
        },
        mounted() {
            this.page=1;
            this.getprojectReport();
        }
    }
</script>
