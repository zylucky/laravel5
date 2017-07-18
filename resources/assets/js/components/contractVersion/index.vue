<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-select v-model="type" placeholder="请选择合同类型">
                    <el-option
                            v-for="item in options1"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="">
                <el-select v-model="status" placeholder="请选择版本状态">
                    <el-option
                            v-for="item in options2"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search"  v-on:click="getList">搜索</el-button>
            </el-form-item>
        </el-form>
        <el-table :data="decoration" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   >
            </el-table-column>
            <el-table-column prop="bianhao" label="版本名称"  sortable>
            </el-table-column>
            <el-table-column prop="gongzhangname" label="合同类型"  sortable>
            </el-table-column>
            <el-table-column prop="zhuangtai" label="版本状态"  :formatter="formatStatus" sortable>
            </el-table-column>
            <el-table-column prop="qianyuedate" label="版本创建时间"  sortable>
            </el-table-column>
            <el-table-column prop="qianyuedate" label="启用"  sortable>
                <template scope="scope">
                <el-switch
                        v-model="scope.row.zhuangtai"
                        on-color="#13ce66"
                        off-color="#ff4949">
                </el-switch>
                </template>
            </el-table-column>
            <el-table-column label="操作" >
                <template scope="scope">
                    <el-button type="small" size="small" @click="handleSet(scope.$index, scope.row)">查看</el-button>
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
        getDecorationList,//列表
        getDecorationDetail,//详情
    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    name:'',
                },
                options1:[
                    {value: 1, label: '收房合同'},
                    {value: 2, label: '出房合同'},
                    {value: 3, label: '工程合同'},
                ],
                options2:[
                    {value: 1, label: '启用'},
                    {value: 2, label: '停用'},
                ],
                status:null,
                type:null,
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                decoration:[],
                listLoading: false,
                sels: [],//列表选中列
                //被选中的权限
                checked:[],
            }
        },
        methods:{
            //佣金类型显示转换
            formatStatus: function (row, column) {
                let status = [];
                status[1] = '等待打印';
                status[2] = '正在确认';
                status[3] = '已确认';
                return status[row.zhuangtai];
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.qianyuedate);
                return newDate.toLocaleDateString()
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
            //获取合同列表
            getList() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    name: this.filters.name,
                };
                this.listLoading = true;
                getDecorationList(para).then((res) => {
                    this.total = res.data.total;
                    this.decoration = res.data.data;
                    this.listLoading = false;
                });
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.getList();
        }
    }
</script>
