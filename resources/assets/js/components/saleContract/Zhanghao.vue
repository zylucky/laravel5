<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;list-style-type:none;"></div>
            <li v-for="xsOffice in xsOffice" style="list-style-type:none;" >
                <el-row>
                    <el-col :span="6">
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
                        <span>房间号： {{xsOffice.fanghao}}{{subleaseno}}</span>
                    </el-col>
                    <!--<el-col :span="0" style="margin-rigjt:0;float:right;margin-top:50;">
                        <el-button type="primary" class="el-icon-plus" @click="addContract"> 新增</el-button>
                    </el-col>-->
                </el-row>
            </li>
        </el-row>
        <el-row>
            <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                <el-table-column
                        label="付款方户名"
                        width="350">
                    <template scope="scope">
                        <el-input v-model="scope.row.zhanghu" @blur="updataZhanghao(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="付款方银行"
                        width="350">
                    <template scope="scope">
                        <el-input v-model="scope.row.yinhang" @blur="updataZhanghao(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="付款账号"
                        width="350">
                    <template scope="scope">
                        <el-input v-model="scope.row.zhanghao" @blur="updataZhanghao(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="tianjiadate" label="添加时间"  :formatter="changeDate"  sortable>
                </el-table-column>
                <!--<el-table-column prop="laiyuantype"  label="来源"   :formatter="formatStatus" sortable>
                </el-table-column>-->
               <!-- <el-table-column label="操作" width="170">
                    <template scope="scope">
                        <el-dropdown   menu-align="start">
                            <el-button v-show="!hanshu(scope.row)" @click="handleDel(scope.$index, scope.row)" type="primary" size="normal" splitButton="true">
                                删除&lt;!&ndash;<i class="el-icon-caret-bottom el-icon&#45;&#45;right"></i>&ndash;&gt;
                            </el-button>
                           &lt;!&ndash; <el-dropdown-menu slot="dropdown" >
                                <el-dropdown-item  ><el-button @click="handleDel(scope.$index, scope.row)">删除</el-button></el-dropdown-item>
                            </el-dropdown-menu>&ndash;&gt;
                        </el-dropdown>
                    </template>
                </el-table-column>-->
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
    </el-row>
</template>

<script>
    import {getSaleContractInfo,
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
                subleaseno:null,
                xsOffice:[{
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                id:null,
                Visible:false,
                zhanghao:{
                    hetongid:null,
                    hetongbianhao:null,
                    zhanghu:null,
                    yinhang:null,
                    zhanghao:null,
                    hetongtid: 1,
                },
                tianjiadate:null,
                Loading:null,
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
            //获取付款账号的数据列表
            purchaseZhanghaoContractList() {
                let para = {
                    page: this.page,
                    size: this.pageSize,
                    htid: this.$route.query.id,
                    httid:1,
                }
                this.listLoading = true;
                getZhanghaoPurchaseContractList(para).then((res) => {
                    //console.log(res.data);
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
                this.xsOffice = res.data.data.xsOffice;
                this.subleaseno = res.data.data.subleaseno;
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
