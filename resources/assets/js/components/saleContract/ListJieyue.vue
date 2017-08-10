<template>
    <div>
        <!--列表页-->
        <el-table :data="jieyueList" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="expand">
                <template scope="props">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <el-form-item label="解约方式">
                            <span>{{ props.row.jieyuefangshi  }}</span>
                        </el-form-item>
                        <el-form-item label="合同终止日期">
                            <span>{{ changedate(props.row.zhongzhidate)  }}</span>
                        </el-form-item>
                    </el-form>
                    <el-form label-position="left" inline class="demo-table-expand"
                             v-if="props.row.zujinList.length>0 "
                             v-for=" (item,index) in props.row.zujinList"
                             :key="index">
                        <!--<el-form-item label="合同终止日期">
                            <span>{{ changedate(item.startdate)  }}</span>
                        </el-form-item>-->
                        <el-form-item label="交房日期">
                            <span>{{ changedate(item.enddate)  }}</span>
                        </el-form-item>
                        <el-form-item label="">

                        </el-form-item>
                    </el-form>
                    <span>交房日期：{{ props.row.jiaofangdate }}&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span>工商营业执照迁出：{{props.row.zhizhaoqianchu}}</span>
                    <span>退还押金：{{ props.row.tuihuanyajin}}</span>
                    <span>退还剩余房租：{{props.row.tuihuanfangzu}}</span>
                    <span>应收杂费：{{ props.row.yingshouzafei}}</span>

                </template>
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="xinbianhao" label="编号"   sortable>
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"   sortable>
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋"   >
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号"  >
            </el-table-column>
            <el-table-column prop="createtime" label="解约时间" :formatter="changeDate"   sortable>
            </el-table-column>
        </el-table>
    </div>
</template>
<script>
    import {getjieyueSaleContractInfo,getSaleContractInfo} from '../../api/api.js';
    export default{
        data(){
            return {
                jieyueList:[],
                //分页类数据
                total:15,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                users:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        methods:{
            //获取这个解约协议页面的数据
            getListSaleContract(id){
                alert(66);
                console.log(id);
                getjieyueSaleContractInfo(id).then((res)=>{
                    alert(777);
                    this.jieyueList = res.data.data;
                    console.log(res.data.data);
                });
                getSaleContractInfo(id).then((res1)=>{
                    alert(888);
                    this.jieyueList = res1.data.data;
                    console.log(res.data.data);
                });

            },
            handleView(index,row){
                this.$router.push('/saleContract/checkBuchong?id='+row.id+'&type=1');//查看
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getSaleContract();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getSaleContract();
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createtime);
                if(row.createtime!=null){
                    return newDate.toLocaleDateString()
                }
            },
            //转化日期格式
            changedate(time){
                var newDate = new Date();
                newDate.setTime(time);
                if(time!=null){
                    return newDate.toLocaleDateString()
                }
            },
            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        //getSaleContract
        mounted(){
            this.getListSaleContract(this.$route.query);
        }
    }
</script>