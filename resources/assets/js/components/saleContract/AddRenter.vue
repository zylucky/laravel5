<template>
    <div>
        <el-form :label-position="labelPosition" ref="renterForm" :rules="editRenterRules" label-width="100px" :model="renter">
        <el-col :span="24">
            <el-form-item label="出租人">
                <el-radio-group v-model="renter.chengzufang">
                    <el-radio :disabled="true" label="华塑商贸"></el-radio>
                    <el-radio :disabled="true" label="幼狮科技"></el-radio>
                    <el-radio :disabled="true" label="航远房地产"></el-radio>
                    <el-radio :disabled="true" label="航远投资管理"></el-radio>
                    <el-radio :disabled="true" label="彭昆"></el-radio>
                    <el-radio :disabled="true" label="彭亮"></el-radio>
                    <el-radio :disabled="true" label="无"></el-radio>
                </el-radio-group>
            </el-form-item>
            <el-row>
                <el-form-item label="居间方类型">
                    <el-radio-group v-model="renter.jujianfangtype" @change="jujianfangtypeChange">
                        <el-radio :label="1">公司</el-radio>
                        <el-radio :label="2">个人</el-radio>
                    </el-radio-group>
                </el-form-item>
            </el-row>
            <div v-if="renter.jujianfangtype==1">
                <el-row>
                    <el-col  :span="8">
                        <el-form-item label="居间方">
                            <el-select
                                    id="jujianfang"
                                    v-model="renter.jujianfangid"
                                    filterable
                                    remote
                                    @change="changeOnSelect1"
                                    placeholder="渠道公司名称"
                                    :remote-method="remoteMethod1"
                                    :loading="bkNameloading">
                                <el-option
                                        v-for="item in renter.options1"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col  :span="8">
                        <el-form-item label="渠道人员">
                            <el-select
                                    v-model="renter.qudaorenid"
                                    filterable
                                    remote
                                    @change="changeOnSelect3"
                                    placeholder="渠道人员"
                                    :remote-method="remoteMethod3"
                                    :loading="bkryNameloading">
                                <el-option
                                        v-for="item in renter.options2"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
            <div v-if="renter.jujianfangtype==2">
                <el-row>
                    <el-form-item label="自由经纪人">
                        <el-select
                                id="jujianfang"
                                v-model="renter.jujianfangid"
                                filterable
                                remote
                                @change="jingjirenchangeOnSelect"
                                placeholder="自由经纪人名称"
                                :remote-method="remoteMethod2"
                                :loading="bkNameloading">
                            <el-option
                                    v-for="item in renter.options1"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-row>
            </div>

            <el-row>
                <el-col :span="8">
                    <el-form-item label="收款人" prop="shoukuanren" required>
                        <el-input v-model="renter.shoukuanren"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="10">
                    <el-form-item label="开户行" prop="kaihuhang" required>
                        <el-input v-model="renter.kaihuhang"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="账号" prop="zhanghao" required>
                        <el-input v-model="renter.zhanghao"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="租户类型" prop="zuhuleixing" required>
                <el-radio-group v-model="renter.zuhuleixing" @change="zuhuleixingChange">
                    <el-radio :label="1">个人</el-radio>
                    <el-radio :label="2">公司</el-radio>
                </el-radio-group>
            </el-form-item>
            <div v-if="renter.zuhuleixing==1">
                <div v-for="(item, index) in renter.chengzuren"
                     :key="index"
                >
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="承租人" :prop="'chengzuren.' + index + '.name'"
                                      :rules="[
                                      { required: true, message: '不能为空' }
                                        ]"
                                      required>
                            <el-input v-model="renter.chengzuren[index].name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="renter.chengzuren[index].idNo"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="renter.chengzuren[index].tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="renter.chengzuren[index].sex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button style="margin-left:6px;" v-show="editVisible" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
                </div>
                <el-form-item>
                    <el-button v-show="editVisible"  @click="addRentItem">新增承租人</el-button>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="代理人" >
                            <el-input v-model="renter.qianyuerenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="renter.qianyuerenId"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="renter.qianyuerenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="renter.qianyuerenSex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
            <div v-if="renter.zuhuleixing == 2">
                <div v-for="(item, index) in renter.chengzuren"
                     :key="index"
                >
                    <el-row>
                        <el-col :span="18">
                            <el-form-item label="公司名称" :prop="'chengzuren.' + index + '.name'" :rules="[
                         { required: true, message: '不能为空' }
                        ]">
                                <el-input v-model="renter.chengzuren[0].name"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="8">
                            <el-form-item label="法人" >
                                <el-input v-model="renter.chengzuren[0].faren"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="10">
                            <el-form-item label="身份证号" >
                                <el-input v-model="renter.chengzuren[0].idNo"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="8">
                            <el-form-item label="联系方式" >
                                <el-input v-model="renter.chengzuren[0].tel"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item label="性别">
                                <el-radio-group v-model="renter.chengzuren[0].sex">
                                    <el-radio :label="1">男</el-radio>
                                    <el-radio :label="2">女</el-radio>
                                </el-radio-group>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </div>
<!--
                <div v-for="(item, index) in renter.chengzuren"
                    :key="index"
                >
                <el-row>
                    <el-col :span="10">
                        <el-form-item label="公司名称" :prop="'chengzuren' + index + '.name'" :rules="[
                         { required: true, message: '不能为空' }
                        ]">
                            <el-input v-model="renter.chengzuren[index].name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="法人" >
                            <el-input v-model="renter.chengzuren[index].faren"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="renter.chengzuren[index].idNo"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="renter.chengzuren[index].tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="renter.chengzuren[index].sex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                </div>-->
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="签约人" >
                            <el-input v-model="renter.qianyuerenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="renter.qianyuerenId"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="renter.qianyuerenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="renter.qianyuerenSex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
        </el-col>
    </el-form>
    </div>
</template>
<script>
    import {getbkNameList,getNameSaleList,getBrokerCompanyUserListPage} from '../../api/api';;
    export default{
        data(){
            return {
                editVisible:true,
                labelPosition:'right',
                bkNameloading:false,
                bkryNameloading:false,
                estate: [],//服务器搜索的渠道公司数据放入这个数组中
                editRenterRules :{
                    shoukuanren: [
                        { required: true, message: '不能为空' }
                    ],
                    kaihuhang: [
                        { required: true, message: '不能为空' }
                    ],
                    zhanghao: [
                        { required: true, message: '不能为空' }
                    ],
                },
            }
        },
        props:['renter'],
        methods: {
            zuhuleixingChange(){
                //只要业主类型发生改变，那么我就将变量初始化
                if(this.$route.path=='/saleContract/add'||this.renter.zuhuleixing!=this.renter.zuhuleixing2){
                    this.renter.chengzuren = [{
                        name: '',
                        faren: '',
                        idNo: '',
                        tel: '',
                        sex: 1,
                        hetongid: null,
                    },]
                }
            },
            jujianfangtypeChange(){
                if(this.$route.path=='/saleContract/add'||this.renter.jujianfangtype!=this.renter.jujianfangtype2) {
                    alert(1111);
                    this.renter.jujianfangid = null,
                    this.renter.jujianfangid2 = null,
                    this.renter.qudaorenid = null,
                    this.renter.jujianfang = null,
                    this.renter.qudaoren = null,
                    this.renter.options1 = [
                        {
                            value: null,
                            label: null,
                        },
                    ];
                    this.renter.options2 = [
                        {
                            value: null,
                            label: null,
                        },
                    ];
                }
            },
            valid(){
                this.$refs.renterForm.validate((valid) => {
                    this.renter.flag = valid;
                });
            },
            changeOnSelect1(){
                var arr = this.renter.options1;
                for (let i=0;i<arr.length;i++ ){
                    if(arr[i].value==this.renter.jujianfangid){
                        this.renter.jujianfang = arr[i].label;
                        if(this.renter.jujianfangid!=this.renter.jujianfangid2){
                            this.renter.qudaoren=null;
                            this.renter.qudaorenid=null;
                        }
                    }
                }
            },
            changeOnSelect3(){
                var arr = this.renter.options2;
                for (let i=0;i<arr.length;i++ ){
                    if(arr[i].value==this.renter.qudaorenid){
                        this.renter.qudaoren = arr[i].label;
                    }
                }
            },
            jingjirenchangeOnSelect(){
                var arr = this.renter.options1;
                for (let i=0;i<arr.length;i++ ){
                    if(arr[i].value==this.renter.jujianfangid){
                        this.renter.jujianfang = arr[i].label;
                    }
                }
            },
            //获取渠道公司名称
            remoteMethod1(query) {
                let para = {
                    name: query
                };
                this.bkNameloading = true;
                getbkNameList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data.data ){
                        arr[i]=res.data.data[i]
                    }
                    this.estate = arr;
                    this.bkNameloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: item.tQdCompayId, label: item.compayname };
                    });
                    if (query !== '') {
                        this.bkNameloading = true;
                        setTimeout(() => {
                            this.bkNameloading = false;
                            this.renter.options1 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query) > -1;
                            });
                        }, 200);
                    } else {
                        this.renter.options1 = [];
                    }
                });

            },







            /*remoteMethod1(query) {
                let para = {
                    name: query
                };
                this.bkNameloading = true;
                getbkNameList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data.data ){
                        arr[i]=res.data.data[i]
                    }
                    this.estate = arr;
                    this.bkNameloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: item.tQdCompayId, label: item.compayname };
                    });
                    if (query !== '') {
                        this.bkNameloading = true;
                        setTimeout(() => {
                            this.bkNameloading = false;
                            this.renter.options1 = this.list;
                        }, 200);
                    } else {
                        this.renter.options1 = [];
                    }
                });

            },*/










            //获取渠道人员
            remoteMethod3(query) {
                let para = {
                    username: query,
                    id:this.renter.jujianfangid!=null?this.renter.jujianfangid:'',
                };
                this.bkryNameloading = true;
                getBrokerCompanyUserListPage(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data.data ){
                        arr[i]=res.data.data[i]
                    }
                    this.estate = arr;
                    this.bkryNameloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: item.tQdPersonId, label: item.qdPername };
                    });
                    if (query !== '') {
                        this.bkryNameloading = true;
                        setTimeout(() => {
                            this.bkryNameloading = false;
                            this.renter.options2 = this.list;
                        }, 200);
                    } else {
                        this.renter.options2 = [];
                    }
                });

            },
            //获取自由经济人名称
            remoteMethod2(query) {
                let para = {
                    name: query
                };
                this.bkNameloading = true;
                getNameSaleList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data.data ){
                        arr[i]=res.data.data[i]
                    }
                    this.estate = arr;
                    this.bkNameloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: item.tQdZyPersonId, label: item.xingming };
                    });
                    if (query !== '') {
                        this.bkNameloading = true;
                        setTimeout(() => {
                            this.bkNameloading = false;
                            this.renter.options1 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query) > -1;
                            });
                        }, 200);
                    } else {
                        this.renter.options1 = [];
                    }
                });

            },
            //新增承租人
            addRentItem() {
                this.renter.chengzuren.push({
                    name:'',
                    idNo:'',
                    tel:'',
                    sex:null,
                });
            },
            //移除承租人
            removeRentItem(item) {
                this.renter.chengzuren.pop();
                var index = this.renter.chengzuren.indexOf(item)
                if (index !== -1) {
                    this.renter.chengzuren.splice(index, 1)
                }
            },

        },
        mounted(){
            //审核页面input禁用
            if(this.$route.path=='/saleContract/review'){
                this.editVisible   =false;
            }
            if(this.$route.path=='/saleContract/see'){
                this.editVisible   =false;
            }
            //获取收房合同出租人

        }
    }
</script>