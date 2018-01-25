
<template>
    <el-row >
        <el-form   :inline="true" :model="filters"  class="demo-form-inline">
            <el-row>
                <el-form-item label="带看时间:">
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
            <el-table-column prop="dep1" label="区域"  width="100"    >
            </el-table-column>
            <el-table-column prop="dep2" label="分区"  width="100"    >
            </el-table-column>
            <el-table-column prop="loupan" label="楼盘"  width="130"    >
            </el-table-column>
            <el-table-column prop="loudong" label="楼栋"  width="80"  >
            </el-table-column>
            <el-table-column prop="fangjian" label="房间号"   width="110"  >
            </el-table-column>
            <el-table-column prop="fjmj" label="面积" width="90" >
            </el-table-column>
            <el-table-column prop="ckzl" label="对外销售单价"  width="120"  >
            </el-table-column>
            <el-table-column prop="ckzlzj" label="对外销售月租金"  width="140"  >
            </el-table-column>
            <el-table-column prop="kehuyetai" label="客户业态"   width="100" >
            </el-table-column>
            <el-table-column prop="bangongrenshu" label="客户办公人数"    width="120" >
            </el-table-column>
            <el-table-column prop="kehumianji" label="客户面积"   width="100" >
            </el-table-column>
            <el-table-column prop="kehuyusuan" label="客户预算"    width="100" >
            </el-table-column>
            <el-table-column prop="kehuqvyv" label="客户所选择区域" width="140" >
            </el-table-column>
            <el-table-column prop="kehuyongfangshijian" label="客户用房时间"   width="120">
            </el-table-column>
            <el-table-column prop="shifoufuzeren" label="是否客户负责人"   width="140"  >
            </el-table-column>
            <el-table-column prop="gongsi" label="渠道公司名称"  width="160" >
            </el-table-column>
            <el-table-column prop="renyuan" label="渠道联系人"  width="120" >
            </el-table-column>
            <el-table-column prop="dianhua" label="联系电话"  width="130" >
            </el-table-column>
            <el-table-column prop="sfek" label="是否二看"  width="120" >
            </el-table-column>
            <el-table-column prop="shuoming" label="带看情况"  width="150" >
            </el-table-column>
            <el-table-column prop="xiaciqvdaoshuoming" label="下次渠道推荐说明"  width="150" >
            </el-table-column>
            <el-table-column prop="personname" label="幼狮带看人"  width="120" >
            </el-table-column>
            <el-table-column prop="phone" label="联系电话"  width="130" >
            </el-table-column>
            <el-table-column prop="dakatime" label="带看时间"  width="180" >
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
        getcoreDaiKanListPage,
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
                getcoreDaiKanListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.chuFang = res.data.data;
                    this.listLoading = false;
                });
            },
            handleExport: function () {
                var sDate=this.filters.startdate==''?'': this.filters.startdate.toLocaleDateString();
                var eDate=this.filters.enddate==''?'': this.filters.enddate.toLocaleDateString() ;
                window.open("/daikanReport/ExportExcel?startdate="+sDate+"&enddate="+ eDate);
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
