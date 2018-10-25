
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
            <el-table-column prop="lpname" label="项目名称"  width="150"    >
            </el-table-column>
            <el-table-column prop="xmzhs" label="项目总户数"  width="110"  >
            </el-table-column>
            <el-table-column prop="xyzzhs" label="小业主总户数"   width="115"  >
            </el-table-column>
            <el-table-column prop="yzxyzhs" label="已知小业主房间总户数" width="160" >
            </el-table-column>
            <el-table-column prop="xyzzjbfb" label="小业主资料百分比"  width="160"  >
            </el-table-column>
            <el-table-column prop="xmzmj" label="项目总面积"   width="110" >
            </el-table-column>
            <el-table-column prop="xkzmj" label="销控总面积"    width="110" >
            </el-table-column>
            <el-table-column prop="xkzts" label="销控总套数"   width="110" >
            </el-table-column>
            <el-table-column prop="xkzmjbfb" label="销控总面积百分比"    width="150" >
            </el-table-column>
            <el-table-column prop="xyzkzmj" label="小业主空置可出租房源面积" width="120" >
            </el-table-column>
            <el-table-column prop="xyzkzts" label="小业主空置可出租房源套数"   width="120">
            </el-table-column>
            <el-table-column prop="xyzamj" label="小业主45天之内到期可出租的面积"   width="130"  >
            </el-table-column>
            <el-table-column prop="xyzats" label="小业主45天之内到期可出租的套数"  width="120" >
            </el-table-column>
            <el-table-column prop="xyzbmj" label="46到90天之内到期可出租面积" width="120" >
            </el-table-column>
            <el-table-column prop="xyzbts" label="46到90天之内到期可出租套数"   width="120">
            </el-table-column>
            <el-table-column prop="xyzcmj" label="租户或资产管理公司转租约的面积" width="120" >
            </el-table-column>
            <el-table-column prop="xyzcts" label="租户或资产管理公司转租约的套数"   width="120">
            </el-table-column>
            <el-table-column prop="ksgfyzmj" label="可收购房源总面积" width="120" >
            </el-table-column>
            <el-table-column prop="ksgfyzts" label="可收购房源总套数"   width="120">
            </el-table-column>
            <el-table-column prop="bzxzfymj" label="本周新增房源面积"   width="130"  >
            </el-table-column>
            <el-table-column prop="bzxzfyts" label="本周新增房源套数"  width="120" >
            </el-table-column>
            <el-table-column prop="bzyzfymj" label="本周已租房源面积" width="120" >
            </el-table-column>
            <el-table-column prop="bzyzfyts" label="本周已租房源套数"   width="120">
            </el-table-column>
            <el-table-column prop="ysgfymj" label="已收购面积" width="120" >
            </el-table-column>
            <el-table-column prop="ysgfyts" label="已收购套数"   width="120">
            </el-table-column>
            <el-table-column prop="sgprice" label="已收购均价"   width="120">
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
        getprojectReportListPage,
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    export default{
        components: {ElRow},
        data(){
            return {
                filters:{
                    xm: '',

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
                getprojectReportListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.chuFang = res.data.data;
                    this.listLoading = false;
                });
            },
            handleExport: function () {
                var xm=this.filters.xm ;
                window.open("/projectReport/ExportExcel?xm="+xm );
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.page=1;
            this.getprojectReport();
        }
    }
</script>
