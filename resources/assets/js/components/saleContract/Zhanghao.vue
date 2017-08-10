<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;list-style-type:none;"></div>
            <li v-for="xsOffice in xsOffice" style="list-style-type:none;" >
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
                <el-table-column prop="bianhao" label="收款方户名" width="300" >
                </el-table-column>
                <el-table-column prop="loupanName" label="收款方银行"  sortable>
                </el-table-column>
                <el-table-column prop="loudongName" label="收款账号"   sortable>
                </el-table-column>
                <el-table-column prop="fanghao" label="添加时间"  sortable>
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
        <el-dialog size="tiny" title="付款账号管理" v-model="zhanghao.Visible" :close-on-click-modal="false">
            <el-form  label-width="120px"  ref="sureForm" :rules="zhanghaoRules" :model="zhanghao">
                <el-input type="hidden" prop="tHetongId"  v-model="zhanghao.tHetongId" auto-complete="off"></el-input>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款方户名：" prop="huming">
                            <el-input v-model="zhanghao.huming"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款银行：" prop="yinheng">
                            <el-input v-model="zhanghao.yinheng"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款账号：" prop="zhanghao">
                            <el-input v-model="zhanghao.zhanghao"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="zhanghao.Visible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="zhanghao.Loading">提交</el-button>
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
                filters: {
                    name: '',
                    region: '',
                    status:'',
                },
                lists:[],
                listLoading:false,
                bianhao:null,
                xsOffice:[{
                    //hetongtype:null,
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                zhanghao:{
                    id:null,
                    Visible:false,
                    tHetongId:null,
                    huming:null,
                    yinheng:null,
                    zhanghao:null,
                    Loading:null,
                },
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
                this.zhanghao.Visible = true;
            },
            //合同终止
            handleEnd(index,row){
                this.$refs.sureForm.validate((valid) => {
                    if(valid){
                        let para1 = this.zhanghao;
                        this.zhanghao.Visible = false;
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
