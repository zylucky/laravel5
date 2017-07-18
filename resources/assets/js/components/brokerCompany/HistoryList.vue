
<template>
    <el-row >
        <div style="margin-top:30px"></div>

        <el-table :data="brokerCompanyUser" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">

            <el-table-column type="index"   width="60">
            </el-table-column>
            <el-table-column prop="qvDaoCompayXinxi.compayname" label="跟进进度"  >
            </el-table-column>
            <el-table-column prop="qdPername" label="跟进时间"  >
            </el-table-column>
            <el-table-column   prop="qdPertel" label="跟进人"  >
            </el-table-column>
            <el-table-column prop="yjzbSf" label="信息是否有效"  >
            </el-table-column>
            <el-table-column prop="yjzbCf" label="信息是否准确"  >
            </el-table-column>
            <el-table-column v-if="isShowd" prop="qdPertel" label="是否转行"  >
            </el-table-column>
            <el-table-column   type="expand">
                       <template scope="props">
                           <el-form label-position="left" inline class="demo-table-expand">
                               <el-form-item label="跟进内容：">
                                   <span>{{ props.row.qvDaoCompayXinxi.compayname }}</span>
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
        getBrokerCompanyUserListPage,
        editBrokerCompanyUser,
        removeBrokerCompanyUser,
        addBrokerCompanyUser,
        batchRemoveBrokerCompanyUser,
        getbkNameList,
       // getUserNameByID,


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
                isShowd:false,
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                brokerCompanyUser:[],
                estate: [],//服务器搜索的渠道公司数据放入这个数组中
                listLoading: false,
                sels: [],//列表选中列

                bk_id:0,
                bk_name:'',
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
                this.getBrokerCompanyUser();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getBrokerCompanyUser();
            },
            //编辑选择渠道公司将id赋值给隐藏字段
            change(){
                //alert(this.editForm.tQdCompayId);

                if(!isNaN(this.editForm.tQdCompayId)){

                this.editForm.tQdCompayName= this.editForm.tQdCompayId;
                }
            },

            //获取渠道公司列表
            getBrokerCompanyUser() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    bk_name: this.filters.bk_name,
                    username: this.filters.bk_username,
                };
                this.listLoading = true;
                getBrokerCompanyUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.brokerCompanyUser = res.data.data;
                    this.listLoading = false;
                });
            },

            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted() {
            this.page=1;

            //根据url得到的合同ID，来获取数据
            if (this.$route.query.id != null) {
                // this.getPurchaseContract(this.$route.query);
                this.isShowd=true;
            }
            this.getBrokerCompanyUser();

        }
    }
</script>
