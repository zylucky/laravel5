
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="filters" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="filters.name" placeholder="请输入项目"></el-input>
            </el-form-item>
            <el-form-item label="">
                <el-select v-model="filters.status" placeholder="请选择合同状态">
                    <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search" @click="saleContractList">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="addContract"> 新增</el-button>
                <!--<el-button type="primary" class="el-icon-upload2" @click="uploadImg">上传</el-button>-->
            </el-form-item>
        </el-form>
        <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column prop="bianhao" label="编号" width="200" >
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"  sortable>
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋"   sortable>
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号"  sortable>
            </el-table-column>
            <el-table-column prop="zhuangtai" label="状态" :formatter="formatStatus"  sortable>
            </el-table-column>
            <el-table-column prop="qianyuedate" label="签约日" :formatter="changeDate"  sortable>
            </el-table-column>
            <el-table-column label="操作" width="170">
                <template scope="scope">
                    <el-dropdown   menu-align="start">
                        <el-button type="primary" size="normal" splitButton="true">
                            操作<i class="el-icon-caret-bottom el-icon--right"></i>
                        </el-button>
                        <el-dropdown-menu slot="dropdown" >
                            <el-dropdown-item  ><el-button @click="handlSee(scope.$index, scope.row)">查看合同</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[0,4,5])"><el-button @click="handleEdit(scope.$index, scope.row)">编辑合同</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[1,2])"><el-button @click="handleReview(scope.$index, scope.row)">审核合同</el-button> </el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[3])"><el-button @click="handleDump(scope.$index, scope.row)">打印合同</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[5])"><el-button @click="handleConfirm(scope.$index, scope.row)">签约成功</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[6])"><el-button @click="handleWeiyue(scope.$index, scope.row)">违 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;约</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[6])"><el-button @click="handleJieyue(scope.$index, scope.row)">解 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;约</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[9])"><el-button @click="handleJieyuewancheng(scope.$index, scope.row)">解约完成</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[10])"><el-button @click="handleCheckJieyue(scope.$index, scope.row)">查看协议</el-button></el-dropdown-item>
                            <el-dropdown-item  v-if="ztin(scope.row,[7])"><el-button @click="openEndDialog(scope.$index, scope.row)">合同终止</el-button></el-dropdown-item>
                        </el-dropdown-menu>
                    </el-dropdown>
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
                    :page-sizes="pageSizes"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right"
            >
            </el-pagination>
        </el-col>
        <el-dialog title="违约" v-model="weiYue.Visible" :close-on-click-modal="false">
            <el-form  label-width="120px"  ref="sureForm">
                <el-input type="hidden" prop="tHetongId"  v-model="weiYue.tHetongId" auto-complete="off"></el-input>
                <el-form-item label="合同编号：" prop="tHetongBianhao">
                    {{weiYue.tHetongBianhao}}
                </el-form-item>
                <el-form-item label="违约类型：" >
                    <el-radio-group v-model="weiYue.weiyueleixing">
                        <el-radio class="radio" label="1" >租户违约</el-radio>
                        <el-radio class="radio" label="2" >幼狮违约</el-radio>
                        <el-radio class="radio" label="3" >不可抗拒</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="终止时间：">
                    <el-date-picker type = "date" placeholder="结束时间"   v-model="weiYue.zhongzhidate" @change="changeEnd">
                    </el-date-picker>
                </el-form-item>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="应收金额：">
                            <el-input v-model="weiYue.yingshoujine"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="14">
                        <el-form-item label="应付金额：">
                            <el-input v-model="weiYue.yingfujine"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="weiYue.Visible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="weiYue.Loading">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>
<script>
    import {
        getSaleContractList,
        removeSaleContract,
        confirmSaleContract,
        confirmedSaleContract,
        weiyueSaleContract,
        endSaleContract,
        jieyueSaleContract,
        weiYueSaveSaleContract,
        weiYueInfoSaleContract,
        approvingSaleContract,} from '../../api/api.js';
    export default {
        data() {
            return {
                filters: {
                    name: '',
                    region: '',
                    status:null,
                },
                weiYue:{
                    id:null,
                    Visible:false,
                    tHetongId:null,
                    tHetongBianhao:null,
                    weiyueleixing:null,
                    zhongzhidate:null,
                    yingshoujine:null,
                    yingfujine:null,
                    Loading:null,
                },
                options:[
                    {value:0, label:'已创建',},
                    {value:1, label:'已提交',},
                    {value:2, label:'审核中',},
                    {value:3, label:'待打印',},
                    {value:4, label:'审核拒绝',},
                    {value:5, label:'待确认',},
                    {value:6, label:'履约中',},
                    {value:7, label:'违约处理中',},
                    {value:8, label:'合同终止（违约处理完成）',},
                    {value:9, label:'解约中',},
                    {value:10, label:'合同终止（解约完成）',},
                    {value:11, label:'合同终止（合同到期）',},
                ],
                //分页类数据
                total:0,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                lists:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        components:{

        },
        methods: {
            changeEnd(value){
                //获取三个信息：合同ID，违约类型，以及本日期
                let para = {
                    hetongId:this.id,
                    hetongType:0,
                    weiYueType:this.weiYue.weiyueleixing,
                    zhongZhiDate:new Date(this.weiYue.zhongzhidate).toLocaleDateString(),
                }
                weiYueInfoSaleContract(para).then((res)=>{
                    if(res.data.code!='200'){
                        this.$message({
                            message: '获取应付信息失败',
                            type: 'error'
                        });
                    }
                    //把值赋予weiYue
                    this.weiYue.yingfujine = res.data.data.yfMoney;
                    this.weiYue.yingshoujine = res.data.data.ysMoney;
                })

            },
            ztin(row,arr){
                var status = arr.indexOf(row.zhuangtai);
                if(status>-1){
                    return true;
                }else{
                    return false;
                }
            },
            //搜索
            search(){

            },
            getUsers() {
                let para = {
                    page: this.page,
                    pageSize: this.pageSize,
                    name: this.filters.name
                };
                this.listLoading = true;
                getUserListPage(para).then((res) => {
                    this.total = res.data.total;
                    this.users = res.data.data;
                    this.listLoading = false;
                });
            },
            //新增
            addContract() {
                var _this = this;
                _this.$router.push("/saleContact/Add");
            },
            formatStatus(row, column){
                let status = [];
                status[0] = '已创建';
                status[1] = '已提交';
                status[2] = '审核中';
                status[3] = '等待打印';
                status[4] = '审核拒绝';
                status[5] = '正在确认';
                status[6] = '履约中';
                status[7] = '违约处理中';
                status[8] = '合同终止（违约处理完成）';
                status[9] = '解约中';
                status[10] = '合同终止（解约完成）';
                status[11] = '合同终止（合同到期）';
                return status[row.zhuangtai];
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.qianyuedate);
                if(row.qianyuedate!=null){
                    return newDate.toLocaleDateString()
                }
            },
            //获取合同列表
            saleContractList() {
                let para = {
                    pn: this.page,
                    cnt: this.pageSize,
                    /*name:'',*/
                    selectItem: this.filters.name,
                    zhuangtai:this.filters.status,
                }
                this.listLoading = true;
                getSaleContractList(para).then((res) => {
                    //console.log(res.data.data)
                    this.total = res.data.total;
                    this.lists = res.data.data;
                    this.listLoading = false;

                });
            },
            handleSizeChange(val) {
                /*console.log(`每页 ${val} 条`);*/
                this.pageSize = val;
                this.saleContractList();
            },
            handleCurrentChange(val) {
                /*console.log(`当前页: ${val}`);*/
                this.page = val;
                this.saleContractList();
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            uploadImg(){
                var _this = this;
                _this.$router.push('/saleContact/upload');
            },
            handlSee(index, row){
                /*let para = {
                    id:row.id,
                }*/
                this.$router.push('/saleContract/see?id=' + row.id);
            },
            handleEdit(index, row){
                let para = {
                    id:row.id,
                }
                //
                //var _this = this;
                //this.$router.push('/saleContact/edit?id='+row.id);
                this.$router.push('/saleContract/edit?id=' + row.id);
                //
                // this.$router.push('/purchaseContact/add?id='+row.id);
            },
            handleReview(index, row){
                let para = {
                    id:row.id,
                }
                approvingSaleContract(para).then((res)=>{
                });
                this.$router.push('/saleContract/review?id=' + row.id);
            },
            /*handleJieyue(index, row){
                this.$confirm('确认将合同设置为解约中吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    alert(11);
                    jieyueSaleContract(para).then((res) => {
                        this.listLoading = false;
                        alert(2222);
                        this.message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                        alert(333);
                    });
                }).catch(() => {

                });
            },*/
            handleJieyue(index, row){
                this.$confirm('确认将合同设置为解约中吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    jieyueSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },
            handleJieyuewancheng(index, row){
                let para = {
                    id:row.id,
                }
                jieyueSaleContract(para).then((res)=>{
                });
                this.$router.push('/saleContract/jieyue?id=' + row.id);
            },
            handleCheckJieyue(index, row){
                this.$router.push('/saleContract/checkJieyue?id=' + row.id);
            },

            handleDump(index, row){
                /*this.$router.push('/saleContract/dump?id='+row.id);*/
                let para = {
                    id:row.id,
                }
                //this.getPurchaseContractList();
                confirmSaleContract(para).then((res)=>{
                    if(res.data.code=="200"){
                        this.saleContractList();
                        window.open('/#/saleContract/dump?id=' + row.id);
                    }
                });
                //window.open('/#/purchaseContract/dump?id='+row.id)
            },
            handleDel(index, row){
                this.$confirm('确认删除该记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    removeSaleContract(para).then((res) => {
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
            //合同确认
            handleConfirm(index, row){
                this.$confirm('确认合同已完成吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    //alert(00);
                    this.listLoading = true;
                    let para = {id: row.id};
                    //alert(11);
                    confirmedSaleContract(para).then((res) => {
                        //alert(22);
                        this.listLoading = false;
                        //alert(33);
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },
            handleWeiyue(index, row){
                this.$confirm('确认将合同设置为违约中吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {id: row.id};
                    weiyueSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },
            //终止 弹窗确认是否终止
            openEndDialog(index,row){
                this.id = row.id;
                this.weiYue.tHetongBianhao = row.bianhao;
                this.weiYue.Visible = true;
                this.weiYue.tHetongId = this.id;
                this.weiYue.id = this.id;

            },
            //合同终止
            handleEnd(index, row){
                this.$confirm('确认合同终止吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    let para1 = this.weiYue;
                    this.weiYue.Visible = false;
                    weiYueSaveSaleContract(para1).then((res)=>{
                        if(res.data.code!='200'){
                            this.$message({
                                message: '数据没有保存成功',
                                type: 'error'
                            });
                        }
                    });
                    this.listLoading = true;
                    let para = {id: row.id};
                    endSaleContract(para).then((res) => {
                        this.listLoading = false;
                        this.$message({
                            message: '设置成功',
                            type: 'success'
                        });
                        this.saleContractList();
                    });
                }).catch(() => {

                });
            },

        },
        mounted(){
            this.saleContractList();
        }

    }
    //vue中和后台交汇数据时，是
</script>
