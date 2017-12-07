
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
                <el-button type="primary" icon="search"  v-on:click="getchanpinReport">搜索</el-button>
                <el-button type="primary" class="el-icon-plus"    @click="handleExport"    > 导出</el-button>
            </el-form-item>
        </el-row>
        </el-form>
        <el-table :data="chuFang"  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="Quyu" label="区域"  width="100">
            </el-table-column>
            <el-table-column label="分区"  prop="Fenqu"  width="100">
            </el-table-column>
            <el-table-column prop="zuhuyezu" label="业主/租户"  width="105"  >
            </el-table-column>
            <el-table-column prop="Leixing" label="产品类型"  width="95"  >
            </el-table-column>
            <el-table-column prop="YongyouID" label="用友编号"  width="95"  >
            </el-table-column>
            <el-table-column prop="LoupanName" label="楼盘"     >
            </el-table-column>
            <el-table-column prop="LoudongName" label="楼栋"  width="80"  >
            </el-table-column>
            <el-table-column prop="Fanghao" label="房间号"   width="80"  >
            </el-table-column>
            <el-table-column prop="Mianji" label="面积" width="90" >
            </el-table-column>
            <el-table-column prop="num" label="房间数量" width="100" >
            </el-table-column>
            <el-table-column prop="Qynx" label="签约年限"   width="110"  >
            </el-table-column>
            <el-table-column prop="ShouChuFangDate" label="收房/出房日"   width="120"  >
            </el-table-column>
            <el-table-column prop="QianYueDate" label="签约日"  width="120" >
            </el-table-column>
            <el-table-column prop="QYZQ" label="合同租期"   width="150">
            </el-table-column>
            <el-table-column prop="EndDate" label="到期日"   width="100">
            </el-table-column>
            <el-table-column prop="MianZuQi" label="免租期"  width="120" >
            </el-table-column>
            <el-table-column prop="MianZuDays" label="免租天数" width="100" >
            </el-table-column>
            <el-table-column prop="MianZuFS" label="免租期扣除方式"  width="150" >
            </el-table-column>
            <el-table-column prop="FKFS" label="付款方式"    width="120" >
            </el-table-column>
            <el-table-column prop="ZJXX" label="租期/租金"   width="310" >
            </el-table-column>
            <el-table-column prop="DiZengDate" label="递增日"   width="110" >
            </el-table-column>
            <el-table-column prop="DiZengLiang" label="递增量"   width="110" >
            </el-table-column>
            <el-table-column prop="Price" label="单价（元/㎡/天）"  width="180"  >
            </el-table-column>
            <el-table-column prop="YaJin" label="业主/租户押金"  width="180"  >
            </el-table-column>
            <el-table-column prop="NowYueZuJin" label="当前月租金"  width="120"  >
            </el-table-column>
            <el-table-column prop="NowPrice" label="当前单价"  width="100"  >
            </el-table-column>
            <el-table-column prop="NowPriceCha" label="单价差额"  width="100"  >
            </el-table-column>
            <el-table-column prop="NowZuJinCha" label="租金差额"  width="100"  >
            </el-table-column>
            <el-table-column prop="JuJianFang" label="渠道公司名称+姓名"  width="220"  >
            </el-table-column>
            <el-table-column prop="HeDan" label="签约支持"  width="120"  >
            </el-table-column>
            <el-table-column prop="ChanQuanZhengHao" label="产权证号"  width="180"  >
            </el-table-column>
            <el-table-column prop="WeiZhi" label="房屋坐落"  width="180"  >
            </el-table-column>
            <el-table-column prop="XingMing" label="业主/租户姓名"  width="180"  >
            </el-table-column>
            <el-table-column prop="LianXiFangShi" label="业主/租户联系方式"  width="200"  >
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
        getchanpinReportListPage,
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
               this.getchanpinReport();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                //console.log(`每页 ${val} 条`);
                this.getchanpinReport();
            },
            //获取渠道公司列表
            getchanpinReport() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    startdate:this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString(),
                    enddate: this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString(),
                };
                this.listLoading = true;
                getchanpinReportListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.chuFang = res.data.data;
                    this.listLoading = false;
                });
            },
            handleExport: function () {
                var sDate=this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString();
                var eDate=this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString() ;
                window.open("/chanpinReport/ExportExcel?startdate="+sDate+"&enddate="+ eDate);
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.page=1;
            this.getchanpinReport();
        }
    }
</script>
