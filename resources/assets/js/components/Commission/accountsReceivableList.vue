
<template>
    <el-row >
        <div style="margin-top:30px"></div>


        <el-table :data="updateInfos" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"  style="width: 100%;">
            <el-table-column prop="personname" label="修改人"  >
            </el-table-column>
            <el-table-column prop="updatedate" label="修改时间" :formatter="changeDate" >
            </el-table-column>
            <el-table-column prop="xiugaixinxi" label="修改内容"   >
            </el-table-column>

        </el-table>

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

                updateInfos:[],
                listLoading: false,

            }
        },
        methods:{

            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.updatedate);
                return newDate.toLocaleDateString()
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
                    this.updateInfos = res.data.data;
                    this.listLoading = false;
                });
            },



        },
        mounted() {
            this.getAccountsReceivable();

        }
    }
</script>
