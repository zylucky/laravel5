<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;"></div>
            <li v-for="xsOffice in xsOffice" style="list-style-type:none;">
                <el-row>
                    <el-col :span="4">
                        <span>合同编号：{{bianhao}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>合同类型：出房合同</span>
                    </el-col>
                    <el-col :span="4">
                        <span >楼盘：{{xsOffice.loupanName}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span >楼栋：{{xsOffice.loudongName}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>房间号： {{xsOffice.fanghao}}</span>
                    </el-col>
                    <el-col :span="0" style="margin-rigjt:0;float:right;margin-top:50;">
                        <el-button type="primary" class="el-icon-plus" @click="addContract"> 新增</el-button>
                    </el-col>
                </el-row>
            </li>
        </el-row>
        <el-row>
            <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                <el-table-column prop="bianhao" label="签单人" width="200" >
                </el-table-column>
                <el-table-column prop="loupanName" label="合单占比"  sortable>
                </el-table-column>
                <el-table-column prop="loudongName" label="签单人领导"   sortable>
                </el-table-column>
                <el-table-column prop="fanghao" label="签单人部门"  sortable>
                </el-table-column>
                <el-table-column prop="fanghao" label="新增时间"  sortable>
                </el-table-column>
                <el-table-column label="操作" width="170">
                    <template scope="scope">
                        <el-dropdown   menu-align="start">
                            <el-button type="primary" size="normal" splitButton="true">
                                操作<i class="el-icon-caret-bottom el-icon--right"></i>
                            </el-button>
                            <el-dropdown-menu slot="dropdown" >
                                <el-dropdown-item  ><el-button @click="handleDel(scope.$index, scope.row)">删除</el-button></el-dropdown-item>
                            </el-dropdown-menu>
                        </el-dropdown>
                    </template>
                </el-table-column>
            </el-table>
        </el-row>
        <!-- 分页-->
        <el-col :span="24" class="toolbar" >
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="pageSizes"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right"
            >
            </el-pagination>
        </el-col>
        <el-dialog size="small" title="新增签单人" v-model="Visible" :close-on-click-modal="false" style="height:800px;margin-top:150px;over-flow:hidden;">
            <el-form  label-width="150px"  ref="sureForm" :rules="zhanghaoRules" :model="qiandanren">
                <el-input type="hidden" prop="tHetongId"  v-model="qiandanren.tHetongId" auto-complete="off"></el-input>
                <div style="height:500px;border:0px solid #8391a5;overflow:auto;">
                <div v-for="(item, index) in qiandanren" style="height:150px;">
                    <el-row>
                        <el-col :span="10">
                            <el-form-item label="签单人姓名">
                                <el-input v-model="qiandanren.qiandanname"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="签单人所占比例">
                                <el-input v-model="qiandanren.bilei"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="10">
                            <el-form-item label="签单人上级领导">
                                <el-input v-model="qiandanren.lingdao"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="签单人部门">
                                <el-input v-model="qiandanren.bumen"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </div>
                </div>
                <el-button v-show="editVisible"  @click="addqiandan" style="position:fixed;bottom:1%;left:6%;">添加</el-button>
            </el-form>
            </div>
            <div slot="footer" class="dialog-footer" style="position:fixed;bottom:1%;left:80%;">
                <el-button @click.native="Visible = false" style=""> 取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="qiandanren.Loading" style="">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>

<script>
    import {getSaleContractInfo,
        zhanghaoSaveSaleContract,
        getZhanghaoSaleContractList,
        removeZhanghaoSaleContract} from '../../api/api';
    export default {
        data() {
            return {
                editVisible:true,
                lists:[],
                listLoading:false,
                bianhao:null,
                xsOffice:[{
                    //hetongtype:null,
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                Visible:false,
                qiandanren:[{
                    id:null,
                    tHetongId:null,
                    qiandanname:null,
                    bilei:null,
                    lingdao:null,
                    bumen:null,
                    Loading:null,
                }],
                zhanghaoRules:{
                    huming: [
                        { required: true, message: '不能为空'}
                    ],
                    yinheng: [
                        { required: true, message: '不能为空'}
                    ],
                    zhanghao: [
                        { required: true, message: '不能为空'}
                    ],
                },
                //分页类数据
                total:0,
                page:null,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                sels: [],//列表选中列
            }
        },
        methods: {
            //获取付款账号的数据列表
            saleZhanghaoContractList() {
                let para = {
                    pn: this.page,
                    cnt: this.pageSize,
                    selectItem: this.filters.name,
                    zhuangtai:this.filters.status,
                }
                //console.log(111);
                //console.log(this.page);
                //console.log(this.pageSize);
                //console.log(para);
                this.listLoading = true;
                getZhanghaoSaleContractList(para).then((res) => {
                    //console.log(12222);
                    //console.log(res.data.data);
                    this.total = res.data.total;
                    this.lists = res.data.data;
                    this.listLoading = false;

                });
            },
            handleSizeChange(val) {
                /*console.log(`每页 ${val} 条`);*/
                this.pageSize = val;
                this.saleZhanghaoContractList();
            },
            handleCurrentChange(val) {
                /*console.log(`当前页: ${val}`);*/
                this.page = val;
                this.saleZhanghaoContractList();
            },
            //增加租期租金
            addqiandan() {
                //console.log(this.qiandanren);
                this.qiandanren.push({
                    qiandanname:'',
                    bilei:'',
                    lingdao:'',
                    bumen:'',
                });
            },
            getSaleContract(id){
                getSaleContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        this.fuzhi(res);
                    }else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            //新增
            addContract(){
                this.Visible = true;
            },
            //合同终止
            handleEnd(index,row){
                this.$refs.sureForm.validate((valid) => {
                    if(valid){
                        let para1 = this.qiandanren;
                        this.Visible = false;
                        zhanghaoSaveSaleContract(para1).then((res)=>{
                            if(res.data.code!='200'){
                                this.$message({
                                    message: '数据没有保存成功',
                                    type: 'error'
                                });
                            }
                        });
                    }
                });

            },
            //账号删除
            handleDel(index, row){
                this.$confirm('确认删除该记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    removeZhanghaoSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getUsers();
                    });
                }).catch(() => {

                });
            },
            fuzhi(res){
                //console.log(res.data.data);
                this.hetongid = res.data.data.id;
                this.bianhao = res.data.data.bianhao;
                this.xsOffice = res.data.data.xsOffice;
                //console.log(this.xsOffice);
                //console.log(this.jieyueXieyi);
            },
        },
        mounted(){
            this.saleZhanghaoContractList();
            //根据url得到的合同ID，来获取数据
            if(this.$route.query.id!=null){
                //alert(11);
                //console.log(this.$route.query);
                this.getSaleContract(this.$route.query);
            }
        }
    }
</script>
