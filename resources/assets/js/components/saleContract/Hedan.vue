<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;"></div>
            <li v-for="xsOffice in xsOffice" style="list-style-type:none;">
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
                    <el-col :span="0" style="margin-rigjt:0;float:right;margin-top:50;">
                        <el-button type="primary" class="el-icon-plus" v-if="fun('saleContactEdit')"  @click="addContract"> 新增</el-button>
                    </el-col>
                </el-row>
            </li>
        </el-row>
        <el-form    ref="hedan" :rules="hedanRules" :model="hedan">
                <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                    <div v-for="(item, index) in hedan.qiandanren"> <!--style="height:150px;"-->
                        <el-row>
                            <el-table-column
                                    label="签单人"
                                    >
                                <template slot-scope="scope">
                                    <el-col>
                                        <el-form-item>
                                            <el-select
                                                    style="top:10px"
                                                    v-model="scope.row.signpersonnelname"
                                                    filterable
                                                    remote
                                                    @change="updataHedan1(scope.$index, scope.row)"
                                                    placeholder="签单人姓名"
                                                    :remote-method="remoteMethodyslxr1"
                                                    :loading="fristyslxrloading1"
                                                    :disabled="!fun('saleContactEdit')"
                                            >
                                                <el-option
                                                        v-for="item in optionsyslxr1"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </template>
                            </el-table-column>
                            <el-table-column label="合单占比">
                                <template slot-scope="scope">
                                    <el-input v-model="scope.row.ratio" @blur="updataHedan(scope.$index, scope.row)"  :disabled="!fun('saleContactEdit')"></el-input>
                                </template>
                            </el-table-column>
                            <el-table-column label="签单人领导">
                                <template slot-scope="scope">
                                    <el-col>
                                        <el-form-item>
                                            <el-select
                                                    style="top:10px"
                                                    v-model="scope.row.leaderpersonnelname"
                                                    filterable
                                                    remote
                                                    @change="updataHedan2(scope.$index, scope.row)"
                                                    placeholder="签单人上级领导"
                                                    :remote-method="remoteMethodyslxr2"
                                                    :loading="fristyslxrloading1"
                                                    :disabled="!fun('saleContactEdit')">
                                                <el-option
                                                        v-for="item in optionsyslxr2"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </template>
                            </el-table-column>
                            <el-table-column label="签单人部门">
                                <template slot-scope="scope">
                                    <el-col>
                                        <el-form-item>
                                            <el-select
                                                    style="top:10px"
                                                    v-model="scope.row.departmentname"
                                                    filterable
                                                    remote
                                                    @change="updataHedan3(scope.$index, scope.row)"
                                                    placeholder="签单人部门"
                                                    :remote-method="remoteMethodyslxr3"
                                                    :loading="fristyslxrloading2"
                                                    :disabled="!fun('saleContactEdit')">
                                                <el-option
                                                        v-for="item in optionsyslxr3"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </el-col>
                                </template>
                            </el-table-column>
                            <el-table-column prop="createtime" label="新增时间"  sortable>
                            </el-table-column>
                           <!-- <el-table-column label="操作" width="170">
                                <template slot-scope="scope">
                                    <el-dropdown   menu-align="start">
                                        <el-button @click="handleDel(scope.$index, scope.row)" type="primary" size="normal" splitButton="true">
                                            删除&lt;!&ndash;<i class="el-icon-caret-bottom el-icon&#45;&#45;right"></i>&ndash;&gt;
                                        </el-button>
                                    </el-dropdown>
                                </template>
                            </el-table-column>-->
                            <el-table-column label="操作" width="170">
                                <template slot-scope="scope">
                                    <el-dropdown v-if="fun('saleContactEdit')"  menu-align="start">
                                        <el-button type="primary" size="normal" splitButton="true">
                                            删除<i class="el-icon-caret-bottom el-icon&#45;&#45;right"></i>
                                        </el-button>
                                        <el-dropdown-menu slot="dropdown" >
                                            <el-dropdown-item  ><el-button @click="handleDel(scope.$index, scope.row)">删除</el-button></el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                </template>
                            </el-table-column>
                        </el-row>
                    </div>
                </el-table>
        </el-form>
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
        <el-dialog title="新增签单人" v-model="Visible" :close-on-click-modal="false" :before-close="dianji" style="max-height:700px;margin-top:150px;over-flow:hidden;">
            <el-form  label-width="150px"  ref="hedan" :rules="hedanRules" :model="hedan">
                <div style="max-height:400px;border:0px solid #8391a5;overflow:auto;">
                <div v-for="(item, index) in hedan.qiandanren" style="height:150px;">
                    <el-row>
                        <el-col :span="12">
                            <el-form-item label="签单人姓名" :prop="'qiandanren.' + index + '.signpersonnelname' " :rules="[
                                {
                                    required: true, message: '不能为空'
                                }
                                ]"
                            >
                                <el-select
                                        v-model="item.signpersonnelname"
                                        filterable
                                        remote
                                        @change="changeyslxr1"
                                        placeholder="签单人姓名"
                                        :remote-method="remoteMethodyslxr1"
                                        :loading="fristyslxrloading1">
                                    <el-option
                                            v-for="item in optionsyslxr1"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="签单人所占比例" :prop="'qiandanren.' + index + '.ratio' " :rules="[
                                {
                                    required: true, message: '不能为空'
                                }
                                ]"
                            >
                                <el-input v-model="item.ratio" placeholder="签单人所占比例"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="12">
                            <el-form-item label="签单人上级领导">
                                <el-select
                                        v-model="item.leaderpersonnelname"
                                        filterable
                                        remote
                                        @change="changeyslxr2"
                                        placeholder="签单人上级领导"
                                        :remote-method="remoteMethodyslxr2"
                                        :loading="fristyslxrloading1">
                                    <el-option
                                            v-for="item in optionsyslxr2"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="签单人部门" :prop="'qiandanren.' + index + '.departmentname'" :rules="[
                                {
                                    required: true, message: '不能为空'
                                }
                                ]"
                            >
                                <el-select
                                        v-model="item.departmentname"
                                        filterable
                                        remote
                                        @change="changeyslxr3"
                                        placeholder="签单人部门"
                                        :remote-method="remoteMethodyslxr3"
                                        :loading="fristyslxrloading2">
                                    <el-option
                                            v-for="item in optionsyslxr3"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </div>
                </div>
                <el-button v-show="editVisible"  @click="addqiandan" style="position:fixed;bottom:1%;left:40px;">添加</el-button>
                <el-button v-show="editVisible"  @click.prevent="removeQiandan(item)" style="position:fixed;bottom:1%;left:100px;">删除</el-button>
            </el-form>
            <div slot="footer" class="dialog-footer" style="position:fixed;bottom:1%;left:80%;">
                <el-button @click.native="quexiao" style=""> 取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="hedan.qiandanren.Loading" style="">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>

<script>
    import {getSaleContractInfo,
        getHedanqiannameSaleList,
        getHedanbumenSaleList,
        hedanSaveSaleContract,
        getHedanSaleContractList,
        removeHedanSaleContract,
        hedanUpdataSaleContract,} from '../../api/api';
    export default {
        data() {
            return {
                editVisible:true,
                lists:[],
                list:[],
                listLoading:false,
                tabIndex:1,
                bianhao:null,
                subleaseno:null,
                xsOffice:[{
                    //hetongtype:null,
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                Visible:false,
                hetongid:null,
                createtime:null,
                hedan:{
                    qiandanren:[
                        {
                            //id:null,
                            contractid:null,
                            signpersonnelname:'',//签单人姓名
                            signpersonnelnameId:'',
                            ratio:null,//签单人所占比例
                            leaderpersonnelname:null,//签单人上级领导
                            leaderpersonnelnameId:'',
                            departmentname:null,//签单人部门
                            departmentnameId:'',
                            //Loading:null,
                        }
                    ],
                },
                fristyslxrloading1: false,
                fristyslxrloading2:false,
                optionsyslxr1: [],
                optionsyslxr2: [],
                optionsyslxr3: [],
                hedanRules:{

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
                this.listLoading = true;
                getHedanSaleContractList(para).then((res) => {
                    this.total = res.data.total;
                    this.lists = res.data.data;
                    this.listLoading = false;

                });
            },
            changeyslxr1(){
                for (var x in this.optionsyslxr1) {
                    if (this.optionsyslxr1[x].value == this.hedan.qiandanren[this.tabIndex-1].signpersonnelname) {
                        this.hedan.qiandanren[this.tabIndex-1].signpersonnelname = this.optionsyslxr1[x].label;
                    }
                }
            },
            changeyslxr2(){
                for (var x in this.optionsyslxr2) {
                    if (this.optionsyslxr2[x].value == this.hedan.qiandanren[this.tabIndex-1].leaderpersonnelname) {
                        this.hedan.qiandanren[this.tabIndex-1].leaderpersonnelname = this.optionsyslxr2[x].label;
                    }
                }
            },
            changeyslxr3(){
                for (var x in this.optionsyslxr3) {
                    if (this.optionsyslxr3[x].value == this.hedan.qiandanren[this.tabIndex-1].departmentname) {
                        this.hedan.qiandanren[this.tabIndex-1].departmentname = this.optionsyslxr3[x].label;
                    }
                }
            },

            //获取签单人列表
            remoteMethodyslxr1(query) {
                let para = {
                    uname: query
                };
                //console.log(para);
                this.list = [];
                this.fristyslxrloading1 = true;
                getHedanqiannameSaleList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[i] = res.data[i]
                    }
                    this.estate = arr;
                    this.fristyslxrloading1 = false;
                    this.list = this.estate.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.fristyslxrloading1 = true;
                        setTimeout(() => {
                            this.fristyslxrloading1 = false;
                            this.optionsyslxr1 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.optionsyslxr1 = [];
                    }
                });
            },
            remoteMethodyslxr2(query) {
                let para = {
                    uname: query
                };
                this.list = [];
                this.fristyslxrloading1 = true;
                getHedanqiannameSaleList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[i] = res.data[i]
                    }
                    this.estate = arr;
                    this.fristyslxrloading1 = false;
                    this.list = this.estate.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.fristyslxrloading1 = true;
                        setTimeout(() => {

                            this.fristyslxrloading1 = false;
                            this.optionsyslxr2 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.optionsyslxr2 = [];
                    }
                });
            },
            remoteMethodyslxr3(query) {
                let para = {
                    dname: query
                };
                this.list = [];
                this.fristyslxrloading2 = true;
                getHedanbumenSaleList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[i] = res.data[i]
                    }
                    this.estate = arr;
                    this.fristyslxrloading2 = false;
                    this.list = this.estate.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.fristyslxrloading2 = true;
                        setTimeout(() => {
                            this.fristyslxrloading2 = false;
                            this.optionsyslxr3 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.optionsyslxr3 = [];
                    }
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
            //添加签单人
            addqiandan() {
                this.tabIndex = this.tabIndex + 1;
                this.hedan.qiandanren.push({
                    contractid:this.hedan.qiandanren[0].contractid,
                    signpersonnelname:'',
                    ratio:'',
                    leaderpersonnelname:'',
                    departmentname:'',
                });
            },
            removeQiandan(item) {
                if(this.hedan.qiandanren.length > 1){
                    this.hedan.qiandanren.pop();
                    var index = this.hedan.qiandanren.indexOf(item)
                    --this.tabIndex;
                    if (index !== -1) {
                        this.hedan.qiandanren.splice(index, 1)
                    }
                }
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
            dianji(){
                location.reload('http://127.0.0.1:8000/#/saleContract');

            },
            quexiao(){
                this.resetForm('hedan');
                history.go(0)
                this.Visible = false;
            },
            //新增的提交
            handleEnd(index,row){
                this.$refs.hedan.validate((valid) => {
                    if(valid){
                        let para1 = this.hedan.qiandanren;
                        //console.log(para1);
                        this.Visible = false;
                        console.log(para1);
                        hedanSaveSaleContract(para1).then((res)=>{
                            if(res.data.code!='200'){
                                this.$message({
                                    message: '数据没有保存成功',
                                    type: 'error'
                                });
                            }
                            this.saleHedanContractList();
                            this.resetForm('hedan');
                            location.reload('http://127.0.0.1:8000/#/saleContract');
                        });
                    }
                });

            },
            //失去焦点事件
            updataHedan1(index, row){
                for (var x in this.optionsyslxr1) {
                    if (this.optionsyslxr1[x].value == row.signpersonnelname) {
                        row.signpersonnelname = this.optionsyslxr1[x].label;
                    }
                }
                let para = {
                    id: row.id,
                    signpersonnelname: row.signpersonnelname,
                    ratio: row.ratio,
                    leaderpersonnelname: row.leaderpersonnelname,
                    departmentname: row.departmentname,
                };
                hedanUpdataSaleContract(para).then((res)=>{
                    if(res.data.code!='200'){
                        this.$message({
                            message: '数据没有保存成功',
                            type: 'error'
                        });
                    }
                });
            },
            updataHedan(index, row){
                let para = {
                    id: row.id,
                    signpersonnelname: row.signpersonnelname,
                    ratio: row.ratio,
                    leaderpersonnelname: row.leaderpersonnelname,
                    departmentname: row.departmentname,
                };
                //alert(22);
                //console.log(para);
                hedanUpdataSaleContract(para).then((res)=>{
                    if(res.data.code!='200'){
                        this.$message({
                            message: '数据没有保存成功',
                            type: 'error'
                        });
                    }
                });
            },
            updataHedan2(index, row){
                for (var x in this.optionsyslxr2) {
                    if (this.optionsyslxr2[x].value == row.leaderpersonnelname) {
                        row.leaderpersonnelname = this.optionsyslxr2[x].label;
                    }

                }
                let para = {
                    id: row.id,
                    signpersonnelname: row.signpersonnelname,
                    ratio: row.ratio,
                    leaderpersonnelname: row.leaderpersonnelname,
                    departmentname: row.departmentname,
                };

                hedanUpdataSaleContract(para).then((res)=>{
                    if(res.data.code!='200'){
                        this.$message({
                            message: '数据没有保存成功',
                            type: 'error'
                        });
                    }
                });
            },
            updataHedan3(index, row){
                for (var x in this.optionsyslxr3) {
                    if (this.optionsyslxr3[x].value == row.departmentname) {
                        row.departmentname = this.optionsyslxr3[x].label;
                    }
                }
                let para = {
                    id: row.id,
                    signpersonnelname: row.signpersonnelname,
                    ratio: row.ratio,
                    leaderpersonnelname: row.leaderpersonnelname,
                    departmentname: row.departmentname,
                };
                //alert(22);2222222
                //console.log(para);
                hedanUpdataSaleContract(para).then((res)=>{
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
                    removeHedanSaleContract(para).then((res) => {
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
                this.hedan.qiandanren.contractid = res.data.data.id;
                this.bianhao = res.data.data.bianhao;
                this.xsOffice = res.data.data.xsOffice;
                this.subleaseno = res.data.data.subleaseno;
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
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
