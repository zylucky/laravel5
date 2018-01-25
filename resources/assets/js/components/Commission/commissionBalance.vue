<template>
    <el-row>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.xm" placeholder="项目："></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" icon="search" v-on:click="getChuFangCommission">搜索</el-button>
            </el-form-item>
        </el-form>
        <el-tabs v-model="activeName2" type="border-card" @tab-click="handleClick">
            <el-tab-pane label="待审批" name="first"></el-tab-pane>
            <el-tab-pane label="已审批" name="second"></el-tab-pane>
        <el-table :data="ChuFang" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中"
                  @selection-change="selsChange" style="width: 100%;">

            <el-table-column prop="loupan" label="楼盘" >
            </el-table-column>
            <el-table-column prop="loudong" label="楼栋" >
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号" >
            </el-table-column>
            <el-table-column prop="monthMoney" label="合同月租金" :formatter="changeYZJ">
            </el-table-column>
            <el-table-column prop="yongjin" label="佣金金额" width="120"  :formatter="changeYJ">
            </el-table-column>
            <el-table-column prop="gsname" label="渠道公司" width="100" >
            </el-table-column>
            <el-table-column prop="qvdao" label="渠道人员" width="100" >
            </el-table-column>
            <el-table-column  label="审批状态" :formatter="formatYJType">
            </el-table-column>
            <el-table-column prop="zfzt" label="支付状态" :formatter="formatState">
            </el-table-column>
            <el-table-column prop="beizhu" label="备注" width="130" >
            </el-table-column>
            <el-table-column label="操作" width="140">
                <template slot-scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item  > <el-button v-if="filters.spzt==0&&fun('commissionBalanceAudit')" @click="handleAudit(scope.$index, scope.row)">审批</el-button> </el-dropdown-item>
                            <el-dropdown-item  > <el-button    @click="handleView(scope.$index, scope.row)">查看</el-button> </el-dropdown-item>
                            <el-dropdown-item  > <el-button  v-if="fun('approvalDump')"  @click="handledump(scope.$index, scope.row)">打印</el-button> </el-dropdown-item>
                            <el-dropdown-item  > <el-button  v-if="fun('commissionContact')"  @click="handleHT(scope.$index, scope.row)">查看合同</el-button> </el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
                </template>
            </el-table-column>
        </el-table>
        <div style="margin-top:30px"></div>
        <!-- 分页-->
        <el-col :span="24" class="toolbar">
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
        </el-tabs>
    </el-row>
</template>
<script>


    import {
        getcommissionBalanceListPage,
        editChuFangCommission,
        payComm,


    } from '../../api/api';

    export default{

        data(){

            return {
                filters: {
                    xm: '',
                    spzt: '',
                },
                optionsspzt: [
                    {
                        value: 0,
                        label: '请选择'
                    },
                    {
                        value: 2,
                        label: '待审批'
                    },
                    {
                        value: 3,
                        label: '已通过'
                    }, {
                        value: 4,
                        label: '已驳回'
                    },
                ],
                optionszfzt: [
                    {
                        value: 0,
                        label: '请选择'
                    },
                    {
                        value: 1,
                        label: '未付款'
                    },
                    {
                        value: 2,
                        label: '已付款'
                    },
                ],
                //分页类数据
                total: 0,
                currentPage: 0,
                pageSize: 10,
                pageSizes: [10, 20, 30, 40, 50, 100],
                ChuFang: [],
                listLoading: false,
                sels: [],//列表选中列
                activeName2:'first',
                //被选中的权限
                checked: [],
            }
        },
        methods: {
            //状态显示转换
            formatYJType: function (row, column) {
                let status = [];
                status[0] = '未提交';
                status[1] = '已提交';
                status[2] = '审核中';
                status[3] = '已通过';
                status[4] = '已驳回';
                return status[row.task_zt];
            },
            //状态显示转换
            formatState: function (row, column) {
                let status = [];
                status[1] = '未付款';
                status[2] = '已付款';
                return status[row.zfzt];
            },
            //标签切换时
            handleClick(tab, event) {

                this.filters.spzt = tab.index;
                this.getChuFangCommission();

            },
            //时间戳转日期格式
            changeXQDate(dt){
                if(dt!=null){
                    var newDate = new Date();
                    newDate.setTime(dt);
                    return newDate.toLocaleDateString();
                }
            },
            //时间戳转日期格式
            changeYZJ(row, column){
                if(row.monthMoney!=null) {
                    return this.toDecimal(row.monthMoney);
                }
            },
            changeYJ(row, column){
                if(row.yongjin!=null) {
                    return this.toDecimal(row.yongjin);
                }
            },

            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                // console.log(`当前页: ${val}`);
                this.getChuFangCommission();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize = val;
                //console.log(`每页 ${val} 条`);

                this.getChuFangCommission();
            },

            //获取出房佣金列表

            getChuFangCommission() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    xm: this.filters.xm,
                    spzt: this.filters.spzt,
                };
                this.listLoading = true;
                getcommissionBalanceListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.ChuFang = res.data.data;
                    this.listLoading = false;
                });
            },

            //显示审批界面
            handleAudit: function (index, row) {
                this.$router.push('/commissionAudit?id=' + row.id);
            },
            //显示查看界面
            handleView: function (index, row) {
                this.$router.push('/commissionView?id='+ row.id);
            },
            handledump: function (index, row) {
                this.$router.push('/approvalDump/'+ row.id);
            },
            handleHT: function (index, row) {
                window.open('/#/saleContract/see?id='+row.hetongid);
            },
            selsChange: function (sels) {
                this.sels = sels;
            },


            toDecimal(x) {
                var f = parseFloat(x);
                if (isNaN(f)) {
                    return false;
                }
                var f = Math.round(x * 100) / 100;
                var s = f.toString();
                var rs = s.indexOf('.');
                if (rs < 0) {
                    rs = s.length;
                    s += '.';
                }
                while (s.length <= rs + 2) {
                    s += '0';
                }
                return  s.split('').reverse().join('').replace(/(\d{3}(?=\d)(?!\d+\.|$))/g, '$1,').split('').reverse().join('');
            },
        },

        mounted() {
            this.page = 1;
            this.getChuFangCommission();

        }
    }
</script>
