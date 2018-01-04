
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
            <el-table-column prop="Loupan_name" label="楼盘"  width="150"    >
            </el-table-column>
            <el-table-column prop="Loudong_name" label="楼栋"  width="80"  >
            </el-table-column>
            <el-table-column prop="Fanghao" label="房间号"   width="80"  >
            </el-table-column>
            <el-table-column prop="Qianyuemianji" label="面积" width="90" >
            </el-table-column>
            <el-table-column prop="Price" label="收购单价（元/㎡/天）"  width="180"  >
            </el-table-column>
            <el-table-column prop="Price" label="出租单价（元/㎡/天）"  width="180"  >
            </el-table-column>
            <el-table-column prop="YueZujin" label="收购月租金"   width="110" >
            </el-table-column>
            <el-table-column prop="xsdj" label="收购日租金"    width="120" >
            </el-table-column>
            <el-table-column prop="YueZujin" label="出租月租金"   width="110" >
            </el-table-column>
            <el-table-column prop="xsdj" label="出租日租金"    width="120" >
            </el-table-column>
            <el-table-column prop="xsyzj" label="收购付款方式" width="120" >
            </el-table-column>
            <el-table-column prop="ckzl" label="出租付款方式"   width="120">
            </el-table-column>
            <el-table-column prop="ckzlzj" label="收购免租"   width="130"  >
            </el-table-column>
            <el-table-column prop="QianyueDate" label="收房佣金合计天数"  width="120" >
            </el-table-column>
            <el-table-column prop="StartDate" label="收房佣金补差额"  width="120" >
            </el-table-column>
            <el-table-column prop="EndDate" label="出房佣金"  width="120" >
            </el-table-column>
            <el-table-column prop="yjts" label="出房佣金合计天数"  width="120" >
            </el-table-column>
            <el-table-column prop="yjkxf" label="出房免租"  width="95" >
            </el-table-column>
            <el-table-column prop="yjjb" label="出房免租期"  width="100" >
            </el-table-column>
            <el-table-column prop="zxsp" label="销售出房预警"  width="120" >
            </el-table-column>
            <el-table-column prop="lpsort" label="空置时间"  width="120" >
            </el-table-column>
            <el-table-column prop="QianyueDate" label="实际空置时间"  width="120" >
            </el-table-column>
            <el-table-column prop="StartDate" label="装修工期天数"  width="120" >
            </el-table-column>
            <el-table-column prop="EndDate" label="装修款"  width="120" >
            </el-table-column>
            <el-table-column prop="yjts" label="装修费用合计天数"  width="120" >
            </el-table-column>
            <el-table-column prop="yjkxf" label="定制装修款"  width="95" >
            </el-table-column>
            <el-table-column prop="yjjb" label="定制装修费用合计天数"  width="100" >
            </el-table-column>
            <el-table-column prop="zxsp" label="礼品费用"  width="120" >
            </el-table-column>
            <el-table-column prop="lpsort" label="礼品费用合计天数"  width="120" >
            </el-table-column>
            <el-table-column prop="StartDate" label="盈亏天数"  width="120" >
            </el-table-column>
            <el-table-column prop="EndDate" label="盈亏金额"  width="120" >
            </el-table-column>
            <el-table-column prop="yjts" label="出房已收款"  width="120" >
            </el-table-column>
            <el-table-column prop="yjkxf" label="出房未收款"  width="95" >
            </el-table-column>
            <el-table-column prop="yjjb" label="何时收齐"  width="100" >
            </el-table-column>
            <el-table-column prop="zxsp" label="客服收房日"  width="120" >
            </el-table-column>
            <el-table-column prop="lpsort" label="出房签约日"  width="120" >
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
