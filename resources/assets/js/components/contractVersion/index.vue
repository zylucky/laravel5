<template>
    <el-row >
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-select v-model="filters.category" placeholder="请选择合同类型">
                    <el-option
                            v-for="item in options1"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="">
                <el-select v-model="filters.status" placeholder="请选择版本状态">
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
            <el-table-column prop="version" label="合同版本"  sortable>
            </el-table-column>
            <el-table-column prop="comment" label="版本名称" width="300"   sortable>
            </el-table-column>
            <el-table-column prop="category" label="合同类型" :formatter="formatCategory"  sortable>
            </el-table-column>
            <el-table-column prop="createtime" label="版本创建时间" :formatter="changeDate" sortable>
            </el-table-column>
            <el-table-column prop="enabled" label="版本状态"  sortable>
                <template slot-scope="scope">
                <el-switch
                        v-model="scope.row.enabled"
                        on-color="#13ce66"
                        off-color="#ff4949"
                        :on-value=1
                        :off-value=0
                        @change="changeStatus(scope.row)"
                >
                </el-switch>
                </template>
            </el-table-column>
            <el-table-column label="操作" >
                <template slot-scope="scope">
                    <el-button v-if="fun('versionView')" type="small" size="small" @click="preview(scope.$index, scope.row)">查看</el-button>
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
        getContractVersionList,//列表
        changeContractVersionStatus,//启用禁用
    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    category:'',
                    status:'',
                },
                options1:[
                    {value: 0, label: '收房合同'},
                    {value: 1, label: '出房合同'},
                    {value: 2, label: '工程合同'},
                ],
                options2:[
                    {value: 1, label: '启用'},
                    {value: 0, label: '停用'},
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
            //合同类型
            formatCategory: function (row, column) {
                let status = [];
                status[0] = '收房合同';
                status[1] = '出房合同';
                status[2] = '工程合同';
                return status[row.category];
            },
            changeStatus(row){
                let para ={
                    id:row.id,
                    status:row.enabled,
                }
                changeContractVersionStatus(para).then((res)=>{

                })
            },

            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createtime);
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
                    category: this.filters.category,
                    status:this.filters.status,
                };
                this.listLoading = true;
                getContractVersionList(para).then((res) => {
                    this.total = res.data.total;
                    this.decoration = res.data.data;
                    this.listLoading = false;
                });
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            preview(index,row){
                if(row.category == 0){
                    window.open('/#/purchaseContract/dump'+row.version+'?isdump=0')
                }else if(row.category == 1){
                    window.open('/#/saleContract/dump'+row.version+'?isdump=0')
                }else if(row.category == 2){
                    //window.open('/#/saleContract/dump'+version)
                }
            },
        },
        mounted() {
            this.getList();
        }
    }
</script>
