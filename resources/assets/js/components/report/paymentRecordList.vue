
<template>
    <el-row >
        <div style="margin-top:30px"></div>

           <!-- 分页-->
        <el-table :data="paymentRecord.updateInfos" highlight-current-row v-loading="UpdatelistLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column prop="personname" label="修改人"  >
            </el-table-column>
            <el-table-column prop="updatedate" label="修改时间" :formatter="changeDate" >
            </el-table-column>
            <el-table-column prop="xiugaixinxi" label="修改内容"   >
            </el-table-column>

        </el-table>
        <div style="margin-top:30px"></div>

    </el-row>
</template>
<script>

    import {
        getPayableInfos,

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
                paymentRecord:[],
                UpdateList:[],
                listLoading: false,
                UpdatelistLoading: false,
                sels: [],//列表选中列
            }
        },
        methods:{

            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.updatedate);
                return newDate.toLocaleDateString()
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getpaymentRecord();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getpaymentRecord();
            },
            //获取应收款记录列表
            getpaymentRecord() {
                let para = {
                    id:this.$route.query.id,
                };
                this.listLoading = true;
                getPayableInfos(para).then((res) => {
                    this.total = res.data.total;
                    this.paymentRecord = res.data.data;
                    this.listLoading = false;
                });
            },


            selsChange: function (sels) {
                this.sels = sels;
            },
        },
        mounted() {
            this.page=1;
            this.getpaymentRecord();
        }
    }
</script>
