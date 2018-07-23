<template>
    <el-row>
        <el-row>
            <div style="margin-top:30px;list-style-type:none;"></div>
            <li v-for="officeList in officeList" style="list-style-type:none;" >
                <el-row>
                    <el-col :span="6">
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
                        <el-button type="primary" v-if="fun('saleContactAppZHAdd')"  class="el-icon-plus" @click="addContract"> 新增</el-button>
                    </el-col>
                </el-row>
            </li>
        </el-row>
        <el-row>
            <el-table :data="lists" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
                <!--<if condition="laiyuantype eq 2">-->
                    <el-table-column prop="name"  label="姓名"  width="150">
                    </el-table-column>
                    <el-table-column prop="phone"  label="APP账号"  width="220">
                    </el-table-column>
                    <el-table-column prop="roleid"  label="APP权限"  width="220"  :formatter="formatStatus" >
                    </el-table-column>
                    <el-table-column prop="createtime" label="添加时间"  :formatter="changeDate"   >
                    </el-table-column>
                    <el-table-column label="操作" width="300">
                        <template slot-scope="scope">
                                <el-button v-if="fun('saleContactAppZHEdit')"   type="primary" size="normal" splitButton="true" @click="editYHZH(scope.$index, scope.row)">
                                    编辑
                                </el-button>
                                <el-button v-if="fun('saleContactAppZHDel')"  type="primary" size="normal" splitButton="true" @click="handleDel(scope.$index, scope.row)">
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
        <el-dialog size="tiny" title="账号管理" v-model="Visible" :close-on-click-modal="false">
            <el-form  label-width="120px"  ref="zhanghao" :rules="zhanghaoRules" :model="zhanghao">
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="APP账号：" prop="phone" required>
                            <el-select
                                    v-model="zhanghao.phone"
                                    filterable
                                    allow-create
                                    default-first-option
                                    remote
                                    @change="change3"
                                    placeholder="请输入手机号"
                                    :remote-method="remoteMethod3"
                                    :loading="fanghaoloading"
                            >
                                <el-option
                                        v-for="item in options3"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.label">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="姓名：" prop="name" >
                            <el-input v-model="zhanghao.name"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="账号权限：" prop="roleid" required>
                            <el-select v-model="zhanghao.roleid" placeholder="">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>

                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="Visible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEnd" :loading="Loading">提交</el-button>
            </div>
        </el-dialog>
        <el-dialog size="tiny" title="账号编辑" v-model="editVisible" :close-on-click-modal="false">
            <el-form  label-width="120px"  ref="zhanghaoedit" :rules="zhanghaoeditRules" :model="zhanghaoedit">

                <el-row>
                    <el-col :span="20">
                        <el-form-item label="APP账号：" prop="phone" required>
                            <el-input v-model="zhanghaoedit.phone" disabled="disabled"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="姓名：" prop="name"  >
                            <el-input v-model="zhanghaoedit.name" disabled="disabled"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="20">
                        <el-form-item label="账号权限：" prop="roleid" required>
                            <el-select v-model="zhanghaoedit.roleid" placeholder="">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>

                    </el-col>
                </el-row>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editVisible = false">取消</el-button>
                <el-button type="primary" @click.native="handleEdit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
    </el-row>
</template>

<script>
    import {
        getSaleContractInfo,
        getAppUserList,
        appUserSave,
        appUserAlter,
        deleteAppUser,
        getUserListByPhone
    } from '../../api/api';
    export default {
        data() {
            return {
                lists:[],
                listLoading:false,
                bianhao:null,
                officeList:[{
                    loupanName:null,
                    loudongName:null,
                    fanghao:null,
                }],
                id:null,
                Visible:false,
                editVisible:false,
                zhanghao:{
                    hetongid:null,
                    userid:null,
                    name:null,
                    phone:null,
                    roleid:null,
                    hetongtid: 1,
                },
                zhanghaoedit:{
                    hetongid:null,
                    userid:null,
                    name:null,
                    phone:null,
                    roleid:null,
                    hetongtid: 1,
                },
                tianjiadate:null,
                Loading:null,
                editLoading:null,
                zhanghaoRules:{
                    phone: [
                        { required: true, message: '不能为空'}
                    ],
                    roleid: [
                        { required: true, message: '不能为空'}
                    ],

                },
                zhanghaoeditRules:{
                    phone: [
                        { required: true, message: '不能为空'}
                    ],
                    roleid: [
                        { required: true, message: '不能为空'}
                    ],
                },
                options:[
                    {
                        value: 1,
                        label: '管理员'
                    }, {
                        value: 2,
                        label: '普通用户'
                    }
                ],
                options3:[],
                options3_mark:false,
                list3: [],
                fanghaoloading: false,
                list: [],//服务器搜索的楼盘数据放入这个数组中
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
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createtime);
                if(row.createtime!=null){
                    return newDate.toLocaleDateString()
                }
            },
            formatStatus(row, column){
                let status = [];
                status[1] = '管理员';
                status[2] = '普通用户';
                return status[row.roleid];
            },
            //获取账号的数据列表
            purchaseZhanghaoContractList() {
                let para = {
                    page: this.page,
                    size: this.pageSize,
                    htid: this.$route.query.id,
                    httid:0,
                }
                getAppUserList(para).then((res) => {
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
            change3(){
                for (var x in this.options3){
                    if(this.options3[x].label==this.zhanghao.phone){
                        if(this.options3[x].typeid==2)
                        {
                            this.$message({
                                message: '该用户已经是业主了',
                                type: 'error'
                            });
                            this.zhanghao.phone='';
                            return false;
                        }
                        this.zhanghao.userid=this.options3[x].value;
                        this.zhanghao.name=this.options3[x].name;
                    }
                }

            },

            //获取房号
            remoteMethod3(query) {
                let para = {
                    phone: query
                };
                this.fanghaoloading = true;
                this.list = [];
                getUserListByPhone(para).then((res) => {
                    //console.log(res.data);
                    this.fanghaoloading = false;
                    for (let i in res.data) {
                        this.list.push({
                            value: res.data[i].id,
                            label: res.data[i].phone,
                            name: res.data[i].name,
                            typeid:res.data[i].typeid,
                        });
                    }
                    if (query !== '') {
                            this.fanghaoloading = false;
                            this.options3 = this.list;
                    } else {
                        this.options3 = [];
                    }
                });


            },
            //新增
            addContract(){
                this.Visible = true;
                this.zhanghao ={
                    hetongid: this.$route.query.id ,
                    userid:null,
                    name:null,
                    phone:null,
                    roleid:null,
                    hetongtid: 1,
                };
            },
            //新增的提交
            handleEnd(index,row){
                this.$refs.zhanghao.validate((valid) => {
                    if(valid){
                        let para1 = this.zhanghao;
                        this.Visible = false;
                        appUserSave(para1).then((res)=>{
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
            //编辑
            editYHZH(index, row){
                this.editVisible = true;
                this.zhanghaoedit ={
                    hetongid: this.$route.query.id ,
                    userid:row.id,
                    name:row.name,
                    phone:row.phone,
                    roleid:row.roleid,
                    hetongtid: 1,
                };
            },
            //新增的提交
            handleEdit(index,row){
                this.$refs.zhanghaoedit.validate((valid) => {
                    if(valid){
                        let para = Object.assign({}, this.zhanghaoedit);
                        this.editVisible = false;
                        appUserAlter(para).then((res)=>{
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

            //账号删除
            handleDel(index, row){
                this.$confirm('确认删除该记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    let para = {
                        userid: row.id,
                        hetongid:this.$route.query.id,
                        hetongtid:0
                    };
                    deleteAppUser(para).then((res) => {
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
                this.officeList = res.data.data.xsOffice;
                //console.log(this.officeList)
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
