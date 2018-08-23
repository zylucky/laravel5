<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;list-style-type:none;"></div>
            <li   style="list-style-type:none;" >
                <el-row>
                    <el-col :span="6">
                        <span>合同编号：{{bianhao}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>合同类型：出房合同</span>
                    </el-col>
                    <el-col :span="4">
                        <span >楼盘：{{xsOffice[0].loupanName}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span >楼栋：{{xsOffice[0].loudongName}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>房间号： {{xsOffice[0].fanghao}} </span>
                    </el-col>
                     <el-col :span="0" style="margin-rigjt:0;float:right;margin-top:50;">
                        <el-button type="primary" class="el-icon-plus" @click="addContract" v-if="fun('saleContactZHAdd')"> 新增</el-button>
                    </el-col>
                </el-row>
            </li>
        </el-row>
        <el-row>
            <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                <el-table-column prop="zhanghu"  label="收款方户名"  width="150">
                </el-table-column>
                <el-table-column prop="yinhang"  label="收款方银行"  width="220">
                </el-table-column>
                <el-table-column prop="zhanghao"  label="收款账号"  width="220">
                </el-table-column>
                <el-table-column prop="tianjiadate" label="添加时间"  :formatter="changeDate"   >
                </el-table-column>
                <el-table-column prop="laiyuantype"  label="来源"   :formatter="formatStatus"  >
                </el-table-column>
                <el-table-column prop="stateid" label="状态"  :formatter="formatState"   >
                </el-table-column>
                <el-table-column label="操作" width="300">
                    <template slot-scope="scope">
                        <el-button v-if="fun('saleContactZHEdit')&&!hanshu(scope.row)&&scope.row.stateid>2"   type="primary" size="normal" splitButton="true" @click="editYHZH(scope.$index, scope.row)">
                            编辑
                        </el-button>
                        <el-button  v-if="fun('saleContactZHAudit')&&scope.row.stateid==1"  type="primary" size="normal" splitButton="true" @click="handleShenHe(scope.$index, scope.row)">
                            审核
                        </el-button>
                        <el-button  v-if="fun('saleContactZHStop')&&scope.row.stateid==2"  type="primary" size="normal" splitButton="true" @click="handleStop(scope.$index, scope.row)">
                            停用
                        </el-button>
                        <el-button v-if="fun('saleContactZHStart')&&scope.row.stateid>2"  type="primary" size="normal" splitButton="true" @click="handleStart(scope.$index, scope.row)">
                            启用
                        </el-button>
                        <el-button v-if="fun('saleContactZHDel')&&!hanshu(scope.row)"  type="primary" size="normal" splitButton="true" @click="handleDel(scope.$index, scope.row)">
                            删除
                        </el-button>
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
            <el-form  label-width="120px"  ref="zhanghao" :rules="zhanghaoRules" :model="zhanghao">
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款方户名：" prop="zhanghu" required>
                            <el-input v-model="zhanghao.zhanghu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款银行：" prop="yinhang" required>
                            <el-input v-model="zhanghao.yinhang"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款账号：" prop="zhanghao" required>
                            <el-input v-model="zhanghao.zhanghao"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="Visible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="Loading">提交</el-button>
            </div>
        </el-dialog>
        <el-dialog size="tiny" title="付款账号管理" v-model="editVisible" :close-on-click-modal="false">
            <el-form  label-width="120px"  ref="zhanghaoedit" :rules="zhanghaoeditRules" :model="zhanghaoedit">
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款方户名：" prop="zhanghu" required>
                            <el-input v-model="zhanghaoedit.zhanghu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款银行：" prop="yinhang" required>
                            <el-input v-model="zhanghaoedit.yinhang"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="付款账号：" prop="zhanghao" required>
                            <el-input v-model="zhanghaoedit.zhanghao"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editVisible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEdit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
        <el-dialog size="tiny" title="审核" v-model="aduitVisible" :close-on-click-modal="false">
            确认启用该账号吗？
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click.native="handleAduit" :loading="Loading">通过</el-button>
                <el-button type="primary" @click.native="handleAduitEnd" :loading="Loading">驳回</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>

<script>
    import {getSaleContractInfo,
        zhanghaoSavePurchaseContract,
        getZhanghaoPurchaseContractList,
        removeZhanghaoPurchaseContract,
        zhanghaoUpdataPurchaseContract,
        changeSFZhanghao} from '../../api/api';
    export default {
        data() {
            return {
                lists:[],
                listLoading:false,
                bianhao:null,
                subleaseno:null,
                xsOffice:[{
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                id:null,
                Visible:false,
                aduitVisible:false,
                editVisible:false,
                zhanghao:{
                    hetongid:null,
                    hetongbianhao:null,
                    zhanghu:null,
                    yinhang:null,
                    zhanghao:null,
                    hetongtid: 1,
                },
                zhanghaoedit:{
                    hetongid:null,
                    hetongbianhao:null,
                    zhanghu:null,
                    yinhang:null,
                    zhanghao:null,
                    hetongtid: 1,
                    tHtYinhangzhanghaoId:0,
                },
                tianjiadate:null,
                Loading:null,
                editLoading:null,
                zhanghaoRules:{
                    zhanghu: [
                        { required: true, message: '不能为空'}
                    ],
                    yinhang: [
                        { required: true, message: '不能为空'}
                    ],
                    zhanghao: [
                        { required: true, message: '不能为空'}
                    ],
                },
                zhanghaoeditRules:{
                    zhanghu: [
                        { required: true, message: '不能为空'}
                    ],
                    yinhang: [
                        { required: true, message: '不能为空'}
                    ],
                    zhanghao: [
                        { required: true, message: '不能为空'}
                    ],
                },
                auditid:0,
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
            hanshu(row){
                return row.laiyuantype==3?true:false;
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.tianjiadate);
                if(row.tianjiadate!=null){
                    return newDate.toLocaleDateString()
                }
            },
            formatStatus(row, column){
                let status = [];
                status[1] = '合同';
                status[2] = '新增';
                status[3] = '财务';
                return status[row.laiyuantype];
            },
            formatState(row, column){
                let status = [];
                status[1] = '待审核';
                status[2] = '已启用';
                status[3] = '已驳回';
                status[4] = '已停用';
                return status[row.stateid];
            },
            //获取付款账号的数据列表
            purchaseZhanghaoContractList() {
                let para = {
                    page: this.page,
                    size: this.pageSize,
                    htid: this.$route.query.id,
                    httid:0,
                }
                getZhanghaoPurchaseContractList(para).then((res) => {
                    this.total = res.data.total;
                    this.lists = res.data.data;
                    this.listLoading = false;
                });
            },
            handleSizeChange(val) {
                this.pageSize = val;
                this.purchaseZhanghaoContractList();
            },
            handleCurrentChange(val) {
                this.page = val;
                this.purchaseZhanghaoContractList();
            },
            /*getSaleContract(id){
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
            },*/
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
                this.zhanghao= {
                    hetongid: this.$route.query.id,
                    hetongbianhao:this.bianhao,
                    zhanghu:null,
                    yinhang:null,
                    zhanghao:null,
                    hetongtid: 1,
                }
            },
            //新增的提交
            handleEnd(index,row){
                this.$refs.zhanghao.validate((valid) => {
                    if(valid){
                        let para1 = this.zhanghao;
                        this.Visible = false;
                        zhanghaoSavePurchaseContract(para1).then((res)=>{
                            if(res.data.code!='200'){
                                this.$message({
                                    message: '数据没有保存成功',
                                    type: 'error'
                                });
                            }
                            this.resetForm('zhanghao');
                            this.purchaseZhanghaoContractList();

                        });
                    }
                });

            },
            //审核
            handleShenHe(index,row){
                this.aduitVisible = true;
                this.auditid=row.tHtYinhangzhanghaoId;
            },
            //审核通过
            handleAduit(index,row){
                this.$confirm('确认审核通过吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    let para = {
                        id:this.auditid,
                        stateid:2,
                    }
                    changeSFZhanghao(para).then((res)=>{
                        if(res.data.code=='200'){
                            this.listLoading = false;
                            this.$message({
                                message: '设置成功',
                                type: 'success'
                            });
                            this.purchaseZhanghaoContractList();
                        }else{
                            this.$message({
                                message: '设置失败',
                                type: 'error'
                            });
                        }
                    });
                })
                this.aduitVisible = false;
            },
            //审核通过
            handleAduitEnd(index,row){
                this.$confirm('确认驳回吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    let para = {
                        id:this.auditid,
                        stateid:3,
                    }
                    changeSFZhanghao(para).then((res)=>{
                        if(res.data.code=='200'){
                            this.listLoading = false;
                            this.$message({
                                message: '设置成功',
                                type: 'success'
                            });
                            this.purchaseZhanghaoContractList();
                        }else{
                            this.$message({
                                message: '设置失败',
                                type: 'error'
                            });
                        }
                    });
                })
                this.aduitVisible = false;
            },
            //停用
            handleStop(index,row){
                this.$confirm('确认停用吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    let para = {
                        id:row.tHtYinhangzhanghaoId,
                        stateid:4,
                    }
                    changeSFZhanghao(para).then((res)=>{
                        if(res.data.code=='200'){
                            this.listLoading = false;
                            this.aduitVisible = false;
                            this.$message({
                                message: '设置成功',
                                type: 'success'
                            });
                            this.purchaseZhanghaoContractList();
                        }else{
                            this.$message({
                                message: '设置失败',
                                type: 'error'
                            });
                        }
                    });
                    //this.$router.push('/purchaseContract/optimize?hetongid='+row.id+'&bianhao='+row.bianhao);
                })

            },
            //启用
            handleStart(index,row){
                this.$confirm('确认启用吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    let para = {
                        id:row.tHtYinhangzhanghaoId,
                        stateid:1,
                    }
                    changeSFZhanghao(para).then((res)=>{
                        if(res.data.code=='200'){
                            this.listLoading = false;
                            this.aduitVisible = false;
                            this.$message({
                                message: '设置成功',
                                type: 'success'
                            });
                            this.purchaseZhanghaoContractList();
                        }else{
                            this.$message({
                                message: '设置失败',
                                type: 'error'
                            });
                        }
                    });
                })

            },

            //编辑
            editYHZH(index, row){
                this.editVisible = true;
                this.zhanghaoedit = Object.assign({}, row);
            },
            //新增的提交
            handleEdit(index,row){
                this.$refs.zhanghaoedit.validate((valid) => {
                    if(valid){
                        let para = Object.assign({}, this.zhanghaoedit);
                        this.editVisible = false;
                        zhanghaoUpdataPurchaseContract(para).then((res)=>{
                            if(res.data.code!='200'){
                                this.$message({
                                    message: '数据没有保存成功',
                                    type: 'error'
                                });
                            } else{
                                this.$message({
                                    message: '数据保存成功',
                                    type: 'success'
                                });
                            }
                            this.purchaseZhanghaoContractList();

                        });
                    }
                });

            },
            //失去焦点事件
            updataZhanghao(index, row){
                let para = {
                    tHtYinhangzhanghaoId: row.tHtYinhangzhanghaoId,
                    zhanghu: row.zhanghu,
                    yinhang: row.yinhang,
                    zhanghao: row.zhanghao,
                };
                zhanghaoUpdataPurchaseContract(para).then((res)=>{
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
                    let para = {id: row.tHtYinhangzhanghaoId};
                    removeZhanghaoPurchaseContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.purchaseZhanghaoContractList();
                    });
                }).catch((res) => {
                    console.log(res)
                });
            },
            fuzhi(res){
                this.hetongid = res.data.data.id;
                this.bianhao = res.data.data.bianhao;
                this.xsOffice = res.data.data.xsOffice
                var fj="";
                for (var x in this.xsOffice){
                    fj=fj+this.xsOffice[x].fanghao+"-"+this.xsOffice[x].subleaseno+",";
                }
                var reg = new RegExp( '-null' , "g" );
                fj=fj.replace( reg , '' );
                this.xsOffice[0].fanghao = fj.substring(0,fj.length-1);

                //console.log(this.xsOffice)
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        },


        mounted(){
            this.purchaseZhanghaoContractList();
            this.zhanghao.hetongid = this.$route.query.id;
            //根据url得到的合同ID，来获取数据
            if(this.$route.query.id!=null){
                this.getSaleContract(this.$route.query);
            }
        }
    }
</script>
