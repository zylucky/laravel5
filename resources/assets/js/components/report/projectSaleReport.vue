
<template>
    <el-row >
        <el-form   :inline="true" :model="filters"  class="demo-form-inline">
            <el-row>
                <el-form-item label="项目名称:">
                    <el-input v-model="filters.xm" placeholder="请输入项目名称"></el-input>
                </el-form-item>
                <el-form-item label="选择周:">
                    <el-date-picker
                            v-model="filters.weekNum"
                            type="week"
                            format="yyyy 第 WW 周"
                            placeholder="选择周">
                    </el-date-picker>
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
            <el-table-column prop="enum_key" label="面积"  width="110"  >
            </el-table-column>
            <el-table-column prop="totalNum" label="总套数"   width="115"  >
            </el-table-column>
            <el-table-column prop="bzxzNum" label="本周新增套数" width="160" >
            </el-table-column>
            <el-table-column prop="bzyzNum" label="本周已租套数"  width="160"  >
            </el-table-column>
            <el-table-column prop="zdqjfy" label="最低价格区间房源"   width="110" >
            </el-table-column>
            <el-table-column prop="minprice" label="最低价格"    width="110" >
            </el-table-column>
            <el-table-column prop="maxprice" label="最高价格"   width="110" >
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
                    weekNum:'',
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
                window.open("/projectSaleReport/ExportExcel?xm="+xm );
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
