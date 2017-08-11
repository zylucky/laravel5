<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;list-style-type:none;"></div>
            <li v-for="officeList in officeList" style="list-style-type:none;" >
                <el-row>
                    <el-col :span="4">
                        <span>合同编号：{{bianhao}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>合同类型：收房合同</span>
                    </el-col>
                    <el-col :span="4">
                        <span >楼盘：{{officeList.loupanName}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span >楼栋：{{officeList.loudongName}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>房间号： {{officeList.fanghao}}</span>
                    </el-col>
                    <el-col :span="0" style="margin-rigjt:0;float:right;margin-top:50;">
                        <el-button type="primary" class="el-icon-plus" @click="addContract"> 新增</el-button>
                    </el-col>
                </el-row>
            </li>
        </el-row>
        <el-row>
            <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                <!--<el-table-column prop="zhanghu" label="收款方户名" width="300" >
                 <el-input v-model="zhanghu"></el-input>
                </el-table-column>-->
                <el-table-column
                        label="收款方户名"
                        width="365">
                    <template scope="scope">
                        <el-input v-model="scope.row.zhanghu" @blur="updataZhanghao(scope.$index, scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="收款方银行"
                        width="365">
                    <template scope="scope">
                        <el-input v-model="scope.row.yinhang" @blur="updataZhanghao(scope.$index, scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="收款账号"
                        width="365">
                    <template scope="scope">
                        <el-input v-model="scope.row.zhanghao" @blur="updataZhanghao(scope.$index, scope.row)"></el-input>
                    </template>
                </el-table-column>
                <!--<el-table-column
                        label="添加时间"
                        width="365">
                    <template scope="scope">
                        <el-input v-model="scope.row.tianjiadate"></el-input>
                    </template>
                </el-table-column>-->
                <el-table-column prop="tianjiadate" label="添加时间"  sortable>
                </el-table-column>-->
                <!--<el-table-column prop="yinhang" label="收款方银行"  sortable>
                </el-table-column>
                <el-table-column prop="zhanghao" label="收款账号"   sortable>
                </el-table-column>
                <el-table-column prop="tianjiadate" label="添加时间"  sortable>
                </el-table-column>-->







                <!--<el-row>
                    <el-col :span="20">
                        <el-form-item label="">
                            <el-input v-model="zhanghu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>-->
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
        <el-dialog size="tiny" title="付款账号管理" v-model="Visible" :close-on-click-modal="false">
            <el-form  label-width="120px"  ref="sureForm" :rules="zhanghaoRules" :model="zhanghao">
                <el-input type="hidden" prop="hetongid"  v-model="hetongid" auto-complete="off"></el-input>
                <el-input type="hidden" prop="qbianhao"  v-model="qbianhao" auto-complete="off"></el-input>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款方户名：" prop="zhanghu" required>
                            <el-input v-model="zhanghu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款银行：" prop="yinheng" required>
                            <el-input v-model="yinheng"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款账号：" prop="zhanghao" required>
                            <el-input v-model="zhanghao"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="Visible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="Loading">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>

<script>
    import {getPurchaseContractInfo,
        zhanghaoSavePurchaseContract,
        getZhanghaoPurchaseContractList,
        removeZhanghaoPurchaseContract,
        zhanghaoUpdataPurchaseContract} from '../../api/api';
    export default {
        data() {
            return {
                lists:[],
                listLoading:false,
                bianhao:null,
                officeList:[{
                    //hetongtype:null,
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                /*zhanghao:{
                    id:null,
                    Visible:false,
                    tHetongId:null,
                    zhanghu:null,
                    yinheng:null,
                    zhanghao:null,
                    Loading:null,
                },*/
                id:null,
                Visible:false,
                hetongid:null,
                qbianhao:null,
                zhanghu:null,
                yinheng:null,
                zhanghao:null,
                tianjiadate:null,
                Loading:null,
                zhanghaoRules:{
                    zhanghu: [
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
            purchaseZhanghaoContractList() {
                let para = {
                    page: this.page,
                    size: this.pageSize,
                    htid: this.$route.query.id,
                    httid:0,
                }
                //console.log(111);
                //console.log(this.page);
                //console.log(this.pageSize);
                //console.log(para);
                this.listLoading = true;
                getZhanghaoPurchaseContractList(para).then((res) => {
                    //console.log(12222);
                    console.log(res.data.data);
                    this.total = res.data.total;
                    //this.fuzhi1(res);
                    this.lists = res.data.data;
                    this.listLoading = false;

                });
            },
            handleSizeChange(val) {
                /*console.log(`每页 ${val} 条`);*/
                this.pageSize = val;
                this.purchaseZhanghaoContractList();
            },
            handleCurrentChange(val) {
                /*console.log(`当前页: ${val}`);*/
                this.page = val;
                this.purchaseZhanghaoContractList();
            },
            getPurchaseContract(id){
                getPurchaseContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //alert(11);
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
            //新增的提交
            handleEnd(index,row){
                this.$refs.sureForm.validate((valid) => {
                    if(valid){
                        let para1 = {
                            zhanghao:this.zhanghao,
                            yinheng:this.yinheng,
                            zhanghu:this.zhanghu,
                            hetongid:this.hetongid,
                            hetongtid:0,
                            hetongbianhao:this.qbianhao,
                        }
                        console.log(para1);
                        alert(222);
                        this.Visible = false;
                        zhanghaoSavePurchaseContract(para1).then((res)=>{
                            alert(11);
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
            //失去焦点事件
            updataZhanghao(index, row){
                alert(333);
                console.log(1111);
                console.log(index, row);
                let para = {
                    tHtYinhangzhanghaoId: row.tHtYinhangzhanghaoId,
                    zhanghu: row.zhanghu,
                    yinhang: row.yinhang,
                    zhanghao: row.zhanghao,
                };
                console.log(para);
                zhanghaoUpdataPurchaseContract(para).then((res)=>{
                    alert(11);
                    if(res.data.code!='200'){
                        this.$message({
                            message: '数据没有保存成功',
                            type: 'error'
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
                    removeZhanghaopurchaseContract(para).then((res) => {
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
                this.qbianhao = res.data.data.bianhao;
                this.officeList = res.data.data.officeList;
                //console.log(this.officeList);
                //console.log(this.jieyueXieyi);
            },
            /*fuzhi1(res){
                console.log(333333);
                console.log(res.data.data);
                this.yinheng = res.data.data.yinheng;
                this.zhanghao = res.data.data.zhanghao;
                this.zhanghu = res.data.data.zhanghu;
                this.tianjiadate = res.data.data.tianjiadate;
                console.log(this.zhanghu);
                console.log(res.data.data.zhanghu[0]);
                //console.log(this.jieyueXieyi);
            },*/
        },
        mounted(){
            this.purchaseZhanghaoContractList();
            //根据url得到的合同ID，来获取数据
            if(this.$route.query.id!=null){
                //alert(11);
                //console.log(this.$route.query);
                this.getPurchaseContract(this.$route.query);
            }
        }
    }
</script>
