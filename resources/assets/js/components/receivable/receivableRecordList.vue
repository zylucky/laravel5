
<template>
    <el-row >
        <el-table :data="ReceivableRecord" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"  style="width: 100%;">
            <el-table-column prop="hetongbianhao" label="合同编号" width="200"  >
            </el-table-column>
            <el-table-column prop="xiangmu" label="项目" width="200"  >
            </el-table-column>
            <el-table-column prop="tijiaoriqi" label="提交日期" width="150"   :formatter="changeTJDate">
            </el-table-column>
            <el-table-column prop="kemu" label="收款科目" width="150"  :formatter="formatFKType">
            </el-table-column>
            <el-table-column prop="tijiaomoney" label="提交金额" width="150" >
            </el-table-column>
            <el-table-column prop="shoukuanmoney" label="收款金额" width="150" >
            </el-table-column>
            <el-table-column prop="shoukuandate" label="收款日期"  :formatter="changeSKDate">
            </el-table-column>
            <el-table-column prop="persnoname" label="发起人" width="150" >
            </el-table-column>
            <el-table-column   label="付款银行及账号"   width="200" :formatter="formatskyh">
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template slot-scope="scope">
                    <el-button v-if="fun('cancelClaim')"  @click="handleRokeBack(scope.$index, scope.row)">取消认领</el-button>
                </template>
            </el-table-column>
           </el-table>

    </el-row>
</template>
<script>

    import {
        getReceivableRecordListPage,
        cancelClaim,
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

                ReceivableRecord:[],
                listLoading: false,

            }
        },
        methods:{

            //时间戳转日期格式
            changeTJDate(row, column){
                if(row.tijiaoriqi!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.tijiaoriqi);
                    return newDate.toLocaleDateString()
                }
            },
            //时间戳转日期格式
            changeSKDate(row, column){
                if(row.shoukuandate!=null) {
                    var newDate = new Date();
                    newDate.setTime(row.shoukuandate);
                    return newDate.toLocaleDateString()
                }
            },

            formatFKType(row, column){
                let status = [];
                status[0] = '押金';
                status[1] = '房租';
                status[5] = '杂费';
                status[10] = '意向金';
                return status[row.kemu];
            },
            //收款账号显示转换
            formatskyh: function (row, column) {
                return  row.fkyinhang+"\r账号:"+row.fkzhanghao;
            },
            //获取渠道公司列表
            getReceivableRecord() {
                let para = {
                    id:this.$route.query.id,

                };
                this.listLoading = true;
                getReceivableRecordListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.ReceivableRecord = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示确认收款界面
            handleRokeBack: function (index, row) {
                this.$confirm('确认取消认领吗？', '提示', {}).then(() => {
                    let para = {
                        id:row.tCwSrSubmitId,
                    }
                    cancelClaim(para).then((res) => {
                        this.$message({
                            message: '提交成功',
                            type: 'success'
                        });
                        this.getReceivableRecord();
                    });
                });
            },

        },
        mounted() {

            this.getReceivableRecord();

        }
    }
</script>
