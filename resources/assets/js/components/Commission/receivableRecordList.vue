
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-table :data="ReceivableRecord" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="hetongbianhao" label="合同编号"  >
            </el-table-column>
            <el-table-column prop="xiangmu" label="项目"  >
            </el-table-column>
            <el-table-column prop="tijiaodate" label="提交日期"   :formatter="changeTJDate">
            </el-table-column>
            <el-table-column prop="fukuankemu" label="付款科目">
            </el-table-column>
            <el-table-column prop="tijiaomoney" label="提交金额" >
            </el-table-column>
            <el-table-column prop="fukuanmoney" label="付款金额" >
            </el-table-column>
            <el-table-column prop="fukuandate" label="付款日期"  :formatter="changeFKDate">
            </el-table-column>
            <el-table-column prop="faqiren" label="发起人" >
            </el-table-column>
            <el-table-column prop="skyinhang" label="收款银行及账号"   width="200" :formatter="formatskyh">
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

            //时间戳转日期格式
            changeTJDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.tijiaodate);
                return newDate.toLocaleDateString()
            },
            //时间戳转日期格式
            changeFKDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.fukuandate);
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
                    id:this.$route.query.id,
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
