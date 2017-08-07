
<template>
    <el-row >
        <div style="margin-top:30px"></div>


        <el-table :data="AccountsReceivable.updateInfos" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="compayname" label="修改人"  >
            </el-table-column>
            <el-table-column prop="compayname" label="收款日"  >
            </el-table-column>
            <el-table-column prop="compayname" label="收款周期"  >
            </el-table-column>
            <el-table-column prop="compaytest" label="收款项目"   >
            </el-table-column>
            <el-table-column prop="yjzbSf" label="收款金额" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="月租金（元）" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="是否需要发票" >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="是否收款" >
            </el-table-column>
            <el-table-column prop="compayname" label="修改时间"  >
            </el-table-column>
            <el-table-column prop="compaytest" label="修改内容"   >
            </el-table-column>

        </el-table>
        <div style="margin-top:30px"></div>
        <!-- 修改记录分页-->
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
        getAccountsReceivableListPage,
        editReceivable,
        saveShouKuan,
        removeReceivable,
        addReceivable,

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
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                AccountsReceivable:[],
                listLoading: false,
                sels: [],//列表选中列

                //被选中的权限
                checked:[],
            }
        },
        methods:{

            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createdate);
                return newDate.toLocaleDateString()
            },

            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getAccountsReceivable();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getAccountsReceivable();
            },

            //获取应收款记录列表
            getAccountsReceivable() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    id:this.$route.query.id,
                };
                this.listLoading = true;
                getAccountsReceivableListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.AccountsReceivable = res.data.data;
                    this.listLoading = false;
                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;
            this.getAccountsReceivable();

        }
    }
</script>
