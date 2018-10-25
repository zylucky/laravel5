
<template>
    <el-row >
        <el-form   :inline="true" :model="filters"  class="demo-form-inline">
            <el-row>
                <el-form-item label="签约日期:">
                    <el-date-picker  type = "date" placeholder="请选择开始日期" v-model="filters.startdate">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="至">
                    <el-date-picker type = "date" placeholder="请选择结束日期" v-model="filters.enddate">
                    </el-date-picker>
                </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getfangyuanReport">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"     @click="handleExport"    > 导出</el-button>
            </el-form-item>
        </el-row>
        </el-form>
        <el-table :data="chuFang"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="QianYueDate" label="签约日"  width="120" >
            </el-table-column>
            <el-table-column prop="Leixing" label="产品类型"  width="95"  >
            </el-table-column>
            <el-table-column prop="Loupan_name" label="楼盘"  width="150"    >
            </el-table-column>
            <el-table-column prop="Loudong_name" label="楼栋"  width="80"  >
            </el-table-column>
            <el-table-column prop="Fanghao" label="房间号"   width="80"  >
            </el-table-column>
            <el-table-column prop="Qianyuemianji" label="面积" width="90" >
            </el-table-column>
            <el-table-column prop="Price" label="居间人-华亮"  width="180"  >
            </el-table-column>
            <el-table-column prop="Price" label="单价（元/㎡/天）"  width="180"  >
            </el-table-column>
            <el-table-column prop="YueZujin" label="实际月租金"   width="110" >
            </el-table-column>
            <el-table-column prop="htyzj" label="合同月租金"    width="120" >
            </el-table-column>
            <el-table-column prop="YueZujin" label="月租金60%"   width="110" >
            </el-table-column>
            <el-table-column prop="xsdj" label="合同返佣金额"    width="120" >
            </el-table-column>
            <el-table-column prop="xsyzj" label="月60%-返佣=差额" width="120" >
            </el-table-column>
            <el-table-column prop="ckzl" label="备注正数为华溯支付华亮;负数为华亮退还华溯"   width="120">
            </el-table-column>
            <el-table-column prop="ckzlzj" label="实际与华亮结佣"   width="130"  >
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
        getfangyuanReportListPage,
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
               this.getfangyuanReport();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                //console.log(`每页 ${val} 条`);
                this.getfangyuanReport();
            },
            //获取渠道公司列表
            getfangyuanReport() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    startdate:this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString(),
                    enddate: this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString(),
                };
                this.listLoading = true;
                getfangyuanReportListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.chuFang = res.data.data;
                    this.listLoading = false;
                });
            },
            handleExport: function () {
                var sDate=this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString();
                var eDate=this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString() ;
                window.open("/fangyuanXKReport/ExportExcel?startdate="+sDate+"&enddate="+ eDate);
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.page=1;
            this.getfangyuanReport();
        }
    }
</script>
