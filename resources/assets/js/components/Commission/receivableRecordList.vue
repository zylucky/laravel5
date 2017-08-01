
<template>
    <el-row >
        <el-table :data="ReceivableRecord" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="compayname" label="收款日"  >
            </el-table-column>
            <el-table-column prop="compaytest" label="收款类型"   >
            </el-table-column>
            <el-table-column prop="yjzbSf" label="收款金额" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="收款人" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="收款时间" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="收款备注" >
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
        getReceivableRecordListPage,

       // getUserNameByID,


    } from '../../api/api';
    import ElForm from "../../../../../node_modules/element-ui/packages/form/src/form";
    export default{
        components: {ElForm},
        data(){
            return {
                options:[
                    {
                        value: 1,
                        label: '押金'
                    }, {
                        value: 2,
                        label: '房租'
                    },
                ],
                showed:false,
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                ReceivableRecord:[],
                listLoading: false,
                sels: [],//列表选中列
                //被选中的权限
                checked:[],
            }
        },
        methods:{
            //佣金类型显示转换
            formatYJType: function (row, column) {
                return row.yjType == 1 ? '按月租金' : row.yjType == 2 ? '按年租金' : '未知';
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createdate);
                return newDate.toLocaleDateString()
            },

            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getReceivableRecord();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getReceivableRecord();
            },


            //获取渠道公司列表
            getReceivableRecord() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                };
                this.listLoading = true;
                getReceivableRecordListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.ReceivableRecord = res.data.data;
                    this.listLoading = false;
                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;
            this.getReceivableRecord();

        }
    }
</script>
