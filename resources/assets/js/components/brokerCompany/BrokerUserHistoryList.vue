
<template>
    <el-row >
        <el-table :data="brokerCompanyUserHistroy" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="genjinjindo" label="跟进进度"  >
            </el-table-column>
            <el-table-column prop="genjindate" label="跟进时间"  :formatter="changeDate" >
            </el-table-column>
            <el-table-column   prop="genjinren" label="跟进人"  >
            </el-table-column>
            <el-table-column prop="shifouyouxiao" label="信息是否有效"   :formatter="changeyx">
            </el-table-column>
            <el-table-column prop="xinxishifouzhunque" label="信息是否准确" :formatter="changezq" >
            </el-table-column>
            <el-table-column  prop="shifouzhuanhang" label="是否转行" :formatter="changezh"  >
            </el-table-column>
            <el-table-column   type="expand">
                       <template scope="props">
                           <el-form label-position="left" inline class="demo-table-expand">
                               <el-form-item label="跟进内容：">
                                   <span>{{ props.row.shuoming }}</span>
                               </el-form-item>
                           </el-form>
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
        getBrokerUserHistoryListPage,

    } from '../../api/api';
    export default{
        data(){
            return {
                filters:{
                    bk_name:'',
                    bk_username:'',
                },
                options:[
                    {
                        value: 1,
                        label: '按月租金'
                    }, {
                        value: 2,
                        label: '按年租金'
                    },
                ],
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                brokerCompanyUserHistroy:[],
                listLoading: false,
                sels: [],//列表选中列

            }
        },
        methods:{
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.genjindate);
                return newDate.toLocaleDateString()
            },
            //是否有效
            changeyx(row, column){
                return row.shifouyouxiao == 1 ? '有效' : row.shifouyouxiao == 2 ? '无效' : '无法取得联系';
            },
            //上报信息
            changezq(row, column){
                return row.xinxishifouzhunque == 1 ? '上报信息准确' : row.xinxishifouzhunque == 2 ? '上报信息不准确' : '未知';
            },
            //是否转行
            changezh(row, column){
                return row.xinxishifouzhunque == 1 ? '未转行' : row.xinxishifouzhunque == 2 ? '转行' : '未知';
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getBrokerCompanyUser();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getBrokerCompanyUser();
            },


            //获取渠道公司列表
            getBrokerCompanyUser() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    personid: this.$route.query.id,
                };
                this.listLoading = true;
                getBrokerUserHistoryListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompanyUserHistroy = res.data.data;
                    this.listLoading = false;
                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;

            this.getBrokerCompanyUser();

        }
    }
</script>
