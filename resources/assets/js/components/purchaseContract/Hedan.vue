<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;"></div>
            <li v-for="officeList in officeList" style="list-style-type:none;">
                <el-row>
                    <el-col :span="4">
                        <span>合同编号：{{bianhao}}</span>
                    </el-col>
                    <el-col :span="4">
                        <span>合同类型：出房合同</span>
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
                <el-table-column
                        label="签单人"
                        width="200">
                    <template scope="scope">
                        <el-input v-model="scope.row.signpersonnelname" @blur="updataHedan(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="合单占比"
                        width="300">
                    <template scope="scope">
                        <el-input v-model="scope.row.ratio" @blur="updataHedan(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="签单人领导"
                        width="300">
                    <template scope="scope">
                        <el-input v-model="scope.row.leaderpersonnelname" @blur="updataHedan(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column
                        label="签单人部门"
                        width="300">
                    <template scope="scope">
                        <el-input v-model="scope.row.departmentname" @blur="updataHedan(scope.$index, scope.row)" :disabled="hanshu(scope.row)"></el-input>
                    </template>
                </el-table-column>
                <el-table-column prop="tianjiadate" label="新增时间"  :formatter="changeDate"  sortable>
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
        <el-dialog title="新增签单人" v-model="Visible" :close-on-click-modal="false" style="max-height:700px;margin-top:150px;over-flow:hidden;">
            <el-form  label-width="150px"  ref="sureForm" :rules="zhanghaoRules" :model="hedan">
                <div style="max-height:400px;border:0px solid #8391a5;overflow:auto;">
                    <div v-for="(item, index) in hedan.qiandanren" style="height:150px;">
                        <el-row>
                            <el-input type="hidden" prop="contractid"  v-model="hedan.qiandanren.contractid" auto-complete="off"></el-input>
                            <el-col :span="10">
                                <el-form-item label="签单人姓名">
                                    <el-input v-model="hedan.qiandanren[index].signpersonnelname"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="10">
                                <el-form-item label="签单人所占比例">
                                    <el-input v-model="hedan.qiandanren[index].ratio"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="10">
                                <el-form-item label="签单人上级领导">
                                    <el-input v-model="hedan.qiandanren[index].leaderpersonnelname"></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :span="10">
                                <el-form-item label="签单人部门">
                                    <el-input v-model="hedan.qiandanren[index].departmentname"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </div>
                </div>
                <el-button v-show="editVisible"  @click="addqiandan" style="position:fixed;bottom:1%;left:6%;">添加</el-button>
                <el-button v-show="editVisible"  @click.prevent="removeQiandan(item)" style="position:fixed;bottom:1%;left:12%;">删除</el-button>
            </el-form>
            </div>
            <div slot="footer" class="dialog-footer" style="position:fixed;bottom:1%;left:80%;">
                <el-button @click.native="Visible = false" style=""> 取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="hedan.qiandanren.Loading" style="">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>

<script>
    import {getPurchaseContractInfo,
        hedanSavePurchaseContract,
        getHedanPurchaseContractList,
        removeHedanPurchaseContract,
        hedanUpdataPurchaseContract,} from '../../api/api';
    export default {
        data() {
            return {
                editVisible:true,
                lists:[],
                htype:1,//合同的类型
                listLoading:false,
                bianhao:null,
                officeList:[{
                    //hetongtype:null,
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                Visible:false,
                hetongid:null,
                hedan:{
                    qiandanren:[
                        {
                            //id:null,
                            contractid:null,
                            signpersonnelname:'',//签单人姓名
                            ratio:null,//签单人所占比例
                            leaderpersonnelname:null,//签单人上级领导
                            departmentname:null,//签单人部门
                            //Loading:null,
                        }
                    ],
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
            //获取付款账号的数据列表
            saleHedanContractList() {
                let para = {
                    pn: this.page,
                    cnt: this.pageSize,
                    htid: this.$route.query.id,
                }
                console.log(para);
                //console.log(this.page);
                //console.log(this.pageSize);
                //alert(222);
                this.listLoading = true;
                getHedanPurchaseContractList(para).then((res) => {
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
                this.saleHedanContractList();
            },
            handleCurrentChange(val) {
                /*console.log(`当前页: ${val}`);*/
                this.page = val;
                this.saleHedanContractList();
            },
            //增加租期租金
            addqiandan() {
                //console.log(this.hedan.qiandanren);
                this.hedan.qiandanren.push({
                    contractid:this.hedan.qiandanren[0].contractid,
                    signpersonnelname:'',
                    ratio:'',
                    leaderpersonnelname:'',
                    departmentname:'',
                });
            },
            removeQiandan(item) {
                this.hedan.qiandanren.pop();
                var index = this.hedan.qiandanren.indexOf(item)
                if (index !== -1) {
                    this.hedan.qiandanren.splice(index, 1)
                }
            },
            getSaleContract(id){
                getPurchaseContractInfo(id).then((res)=>{
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
                this.$refs.sureForm.validate((valid) => {
                    if(valid){
                        let para1 = this.hedan.qiandanren;
                        //console.log(para1);
                        this.Visible = false;
                        hedanSavePurchaseContract(para1).then((res)=>{
                            if(res.data.code!='200'){
                                this.$message({
                                    message: '数据没有保存成功',
                                    type: 'error'
                                });
                            }
                            this.saleHedanContractList();
                        });
                    }
                });

            },
            //失去焦点事件
            updataHedan(index, row){
                let para = {
                    id: row.id,
                    signpersonnelname: row.signpersonnelname,
                    ratio: row.ratio,
                    leaderpersonnelname: row.leaderpersonnelname,
                    departmentname: row.departmentname,
                };
                //alert(22);
                console.log(para);
                hedanUpdataPurchaseContract(para).then((res)=>{
                    if(res.data.code!='200'){
                        this.$message({
                            message: '数据没有保存成功',
                            type: 'error'
                        });
                    }
                });
            },
            //签单人删除
            handleDel(index, row){
                this.$confirm('确认删除该记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    removeHedanPurchaseContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.saleHedanContractList();
                    });
                }).catch(() => {
                });
            },
            fuzhi(res){
                //console.log(res.data.data);
                this.hedan.qiandanren.contractid = res.data.data.id;
                //this.hetongid = res.data.data.id;
                this.bianhao = res.data.data.bianhao;
                this.officeList = res.data.data.officeList;
                //console.log(this.xsOffice);
                //console.log(this.jieyueXieyi);
            },
        },
        mounted(){
            this.saleHedanContractList();
            this.hetongid = this.$route.query.id;
            this.hedan.qiandanren[0].contractid = this.$route.query.id;
            //根据url得到的合同ID，来获取数据
            if(this.$route.query.id!=null){
                //console.log(this.$route.query);
                this.getSaleContract(this.$route.query);
            }
        }
    }
</script>
