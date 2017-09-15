<template>

    <el-row>
        <div style="margin-bottom: 60px;"></div>
        <el-form label-Weizhi="right" ref="brokerCompanyUserForm" :rules="brokerCompanyUserFormRules"
                 label-width="180px"
                 :model="brokerCompanyUserForm" class="demo-dynamic">
            <el-col :span="18">

                <el-row>
                    <el-col :span="8">
                        <el-form-item label="姓名" prop="qdPername">
                            <el-input v-model="brokerCompanyUserForm.qdPername" :disabled="isname"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="职务" prop="zhiwu">
                            <el-input v-model="brokerCompanyUserForm.zhiwu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item required label="联系电话" v-for="(item, index) in brokerCompanyUserForm.telList"
                              :key="item.key">
                    <el-col :span="8">
                        <el-form-item :prop="'telList.' + index + '.dianhua' " :rules="[
                                {required: true, message: '不能为空'},
                                {required: true,validator:MycheckPhone, trigger:'blur'  }
                        ]">
                        <el-input v-model.number="brokerCompanyUserForm.telList[index].dianhua"></el-input>
                </el-form-item>
            </el-col>
            <el-button v-if="index>0" @click.prevent="removeFreeItem(item)">删除</el-button>
            </el-form-item>
            <el-form-item>
                <el-button v-show="editVisible" @click="addFreeItem">新增</el-button>
            </el-form-item>

            <el-row>
                <el-col :span="8">
                    <el-form-item label="渠道公司名称" prop="tQdCompayId">
                        <el-select
                                v-model="brokerCompanyUserForm.qvDaoCompayXinxi.tQdCompayId"
                                filterable
                                remote
                                @change="change1"
                                placeholder="渠道公司名称"
                                :remote-method="remoteMethod1"
                                :loading="bkNameloading">
                            <el-option
                                    v-for="item in options1"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="项目名称" prop="gsLoupan">
                        <el-input v-model="brokerCompanyUserForm.qvDaoCompayXinxi.gsLoupan"
                                  disabled="disabled"></el-input>
                    </el-form-item>
                </el-col>

            </el-row>
            <el-row>
                <el-col :span="8">
                    <el-form-item label="幼狮联系人1" prop="yslianxiren1">
                        <el-input v-model="brokerCompanyUserForm.yslianxiren1"  ></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="幼狮联系人2" prop="yslianxiren2">
                        <el-input v-model="brokerCompanyUserForm.yslianxiren2"  ></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="幼狮联系人3" prop="yslianxiren3">
                        <el-input v-model="brokerCompanyUserForm.yslianxiren3"  ></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>

                <el-col :span="8">
                    <el-form-item label="是否添加微信好友" prop="shifouweixin">
                        <el-radio-group v-model="brokerCompanyUserForm.shifouweixin"
                                        @change="changehaoyou">
                            <el-radio :label=true>是</el-radio>
                            <el-radio :label=false>否</el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="添加好友人数" prop="tianjiahaoyourenshu" v-if="ishy">
                        <el-input v-model.number="brokerCompanyUserForm.tianjiahaoyourenshu"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="8">
                    <el-form-item label="是否带看幼狮" prop="shifoudaikanyoushi">
                        <el-radio-group v-model="brokerCompanyUserForm.shifoudaikanyoushi"
                                        @change="changedaikan">
                            <el-radio :label=true>是</el-radio>
                            <el-radio :label=false>否</el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="带看次数" prop="daikancishu" v-if="isdk">
                        <el-input v-model.number="brokerCompanyUserForm.daikancishu"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="带看对接人数" prop="daikanduijierenshu" v-if="isdk">
                        <el-input v-model.number="brokerCompanyUserForm.daikanduijierenshu"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="8">
                    <el-form-item label="是否签约过幼狮" prop="shifouqianyueyoushifang">
                        <el-radio-group v-model="brokerCompanyUserForm.shifouqianyueyoushifang"
                                        @change="changeqianyue">
                            <el-radio :label=true>是</el-radio>
                            <el-radio :label=false>否</el-radio>
                        </el-radio-group>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="签约次数" prop="qianyuecishu" v-if="isqy">
                        <el-input v-model.number="brokerCompanyUserForm.qianyuecishu"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="签约对接人数" prop="qianyueduijierenshu" v-if="isqy">
                        <el-input v-model.number="brokerCompanyUserForm.qianyueduijierenshu"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="粘性等级" prop="qvdaodengji">
                <el-select v-model="brokerCompanyUserForm.qvdaodengji" placeholder="">
                    <el-option
                            v-for="item in optionsqddj"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="备注" prop="beizhu">
                <el-input type="textarea" v-model="brokerCompanyUserForm.beizhu" auto-complete="off"></el-input>
            </el-form-item>
            </el-col>
        </el-form>
        <el-button type="primary" v-show="editVisible" @click="save" style="margin-left:50%;">提交</el-button>
        <el-button v-show="editVisible" @click.native="fanhui">返回</el-button>
        <el-col>
            <div v-show="showeidt">
                <el-button @click.native="change">跟进记录</el-button>
                <add-history v-show="showhistory"></add-history>

                <div v-show="showed">
                    <el-form :model="editForm" label-width="180px" :rules="editFormRules" ref="editForm"
                             label-Weizhi="right">

                        <el-row :span="18">
                            <el-form-item label="信息是否有效" prop="shifouyouxiao">
                                <el-radio-group v-model="editForm.shifouyouxiao">
                                    <el-radio :label="1">有效</el-radio>
                                    <el-radio :label="2">无效</el-radio>
                                    <el-radio :label="3">无法取得联系</el-radio>
                                </el-radio-group>
                            </el-form-item>
                        </el-row>
                        <el-row :span="18">
                            <el-form-item label="信息是否准确" prop="xinxishifouzhunque">
                                <el-radio-group v-model="editForm.xinxishifouzhunque">
                                    <el-radio :label="1">上报信息准确</el-radio>
                                    <el-radio :label="2">上报信息不准确</el-radio>
                                </el-radio-group>
                            </el-form-item>
                        </el-row>
                        <el-row :span="18">
                            <el-form-item label="是否转行" prop="shifouzhuanhang">
                                <el-radio-group v-model="editForm.shifouzhuanhang">
                                    <el-radio :label="1">未转行</el-radio>
                                    <el-radio :label="2">转行</el-radio>
                                </el-radio-group>
                            </el-form-item>
                        </el-row>
                        <el-row :span="18">
                            <el-form-item label="内容" prop="shuoming">
                                <el-input type="textarea" v-model="editForm.shuoming" auto-complete="off"
                                          style="width:1100px"></el-input>
                            </el-form-item>
                        </el-row>
                        <a href='javascript:;' @click="openHistory">查看历史记录</a>
                    </el-form>
                    <el-button type="primary" v-show="editVisible" @click="savehistory" style="margin-left:37%;">保存
                    </el-button>
                    <el-button v-show="editVisible" @click.native="fanhui">返回</el-button>
                </div>
            </div>

        </el-col>
    </el-row>
</template>
<script>
    import {
        getbkNameList,
        getYSLXRDicList,
        addBrokerCompanyUserHistory,
        getBrokerCompanyUserInfo,
        editBrokerCompanyUser,
        addBrokerCompanyUser,
        getQDDJDicList,
        checkPhone,
        checkName

    } from '../../api/api';
    import AddHistory from './UserHistoryList.vue'
    import ElRow from "element-ui/packages/row/src/row";
    export default {
        components: {
            ElRow,
            AddHistory
        },
        data() {
            return {
                dialogImageUrl: '',
                dialogVisible: false,
                showed: false,
                ishy: true,
                isdk: true,
                isqy: true,
                isname: false,
                brokerCompanyUserForm: {
                    tQdPersonId: '',
                    tQdCompayId: '',
                    qdPername: '',
                    zhiwu: null,
                    qdPertel: '',
                    yjzbSf: '',
                    yjzbCf: '',
                    yjType: '',
                    qdType: '',
                    yslianxiren1: '',
                    yslianxiren1Id: '',
                    yslianxiren2: '',
                    yslianxiren2Id: '',
                    yslianxiren3: '',
                    yslianxiren3Id: '',
                    shifouweixin: true,
                    tianjiahaoyourenshu: '',
                    shifoudaikanyoushi: true,
                    daikancishu: '',
                    daikanduijierenshu: '',
                    shifouqianyueyoushifang: true,
                    qianyuecishu: '',
                    qianyueduijierenshu: '',
                    qvdaodengji: '',
                    beizhu: '',
                    zhuangtai: '',
                    qvDaoCompayXinxi: {
                        tQdCompayId: '',
                        compayname: '',
                        gsLoupan: '',
                    },
                    telList: [
                        {
                            tQdPersonTelId: 0,
                            dianhua: '',
                            qdType: '',
                            personid: ''
                        }
                    ],
                    persontype: 0,
                    genjinDate: null,
                    wanchengdu: '',
                },
                list: [],
                optionsqddj: [],
                optionsyslxr1: [],
                fristyslxrloading1: false,
                optionsyslxr2: [],
                fristyslxrloading2: false,
                optionsyslxr3: [],
                fristyslxrloading3: false,
                brokerCompanyUserFormRules: {
                    qdPername: [
                        {required: true, message: '不能为空'},

                    ],
                    tQdCompayId: [
                        {required: true, message: '不能为空'},
                    ],
                    zhiwu: [
                        {required: true, message: '不能为空'},
                    ],
                    yslianxiren1Id: [
                        {required: true, message: '不能为空'},
                    ],
                    shifouweixin: [
                        {required: true, message: '不能为空'},
                    ],
                    shifoudaikanyoushi: [
                        {required: true, message: '不能为空'},
                    ],
                    shifouqianyueyoushifang: [
                        {required: true, message: '不能为空'},
                    ],
                    qvdaodengji: [
                        {required: true, message: '不能为空'},
                    ],

                    tianjiahaoyourenshu: [{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                    daikancishu: [{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                    daikanduijierenshu: [{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                    qianyuecishu: [{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                    qianyueduijierenshu: [{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                },
                editVisible: true,
                bkNameloading: false,
                options1: [],
                ischeckname: '',

                //房源数据初始化
                showeidt: true,
                showhistory: false,
                //编辑界面数据
                editLoading: false,
                editForm: {
                    tQdCompayId: 0,
                    shifouyouxiao: null,
                    xinxishifouzhunque: null,
                    shifouzhuanhang: null,
                    shuoming: '',
                },
                editFormRules: {
                    shifouyouxiao: [{required: true, message: '不能为空'},],
                    xinxishifouzhunque: [{required: true, message: '不能为空'},],
                    shifouzhuanhang: [{required: true, message: '不能为空'},],
                },
            }
        },
        methods: {
            openHistory(){
                window.open("/#/brokerCompanyUserHistory?id=" + this.$route.query.id);
            },
            //增加
            addFreeItem() {
                this.brokerCompanyUserForm.telList.push({
                    "tQdPersonTelId":0,
                    "dianhua": '',
                    "qdType": '',
                    "personid": ''
                });
            },
            MycheckPhone(rule,value,callback){
                if (/^\d+$/.test(value) == true) {
                    var telid=0;
                    for (var x in this.brokerCompanyUserForm.telList) {
                        if (this.brokerCompanyUserForm.telList[x].dianhua ==value) {
                            telid= this.brokerCompanyUserForm.telList[x].tQdPersonTelId;
                        }
                    }
                    let para = {
                        id:telid ,
                        phone: value,
                    };
                    checkPhone(para).then((res) => {
                        if (res.data.code != '200') {
                            callback(res.data.msg);
                        } else {
                            callback();
                        }
                    })

                }else{
                    callback('必须为数字');
                }
            },
            changehaoyou(){
                if (this.brokerCompanyUserForm.shifouweixin == true) {
                    this.ishy = true;

                } else {
                    this.ishy = false;
                    this.brokerCompanyUserForm.tianjiahaoyourenshu =null;
                }

            },

            changedaikan(){
                if (this.brokerCompanyUserForm.shifoudaikanyoushi == true) {
                    this.isdk = true;
                } else {
                    this.isdk = false;
                    this.brokerCompanyUserForm.daikancishu =null;
                    this.brokerCompanyUserForm.daikanduijierenshu =null;
                }

            },
            changeqianyue(){
                if (this.brokerCompanyUserForm.shifouqianyueyoushifang == true) {
                    this.isqy = true;
                } else {
                    this.isqy = false;
                    this.brokerCompanyUserForm.qianyuecishu =null;
                    this.brokerCompanyUserForm.qianyueduijierenshu =null;
                }

            },
            //获取渠道等级
            remoteMethodqddj() {

                getQDDJDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsqddj.push({
                                value: res.data.data[item].enumValue,
                                label: res.data.data[item].enumKey
                            });
                        }
                    } else {
                        this.$message({
                            message: '获取公司属性数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            //移除
            removeFreeItem(item) {
                var index = this.brokerCompanyUserForm.telList.indexOf(item)
                if (index !== -1) {
                    this.brokerCompanyUserForm.telList.splice(index, 1)
                }
            },

            checkName(){
                let para = {
                    name: this.brokerCompanyUserForm.qdPername,
                    id: this.brokerCompanyUserForm.tQdCompayId
                };

                checkName(para).then((res) => {
                    if (res.data.total > 0) {
                        this.ischeckname = res.data.msg;
                        console.log(this.ischeckname);
                    }
                })

            },
            //显示和隐藏跟进记录
            change(){
                if (this.$route.path == '/brokerCompanyUserList/view') {
                    if (this.showhistory == false) {
                        this.showhistory = true;
                    } else {
                        this.showhistory = false;
                    }
                } else {
                    if (this.showed == false) {
                        this.showed = true;
                    } else {
                        this.showed = false;
                    }
                }

            },

            //获取渠道公司名称
            remoteMethod1(query) {
                let para = {
                    name: query
                };
                this.bkNameloading = true;
                this.list = [];
                getbkNameList(para).then((res) => {
                    for (let i in res.data.data) {
                        this.list.push({
                            value: res.data.data[i].tQdCompayId,
                            label: res.data.data[i].compayname,
                            lpname: res.data.data[i].gsLoupan
                        });
                    }
                    this.bkNameloading = false;
                    if (query !== '') {
                        this.bkNameloading = true;
                        setTimeout(() => {

                            this.bkNameloading = false;
                            this.options1 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);

                    } else {
                        this.options1 = [];
                    }

                });

            },
            //根据url得到的合同ID，来获取数据
            getBrokerCompanyUser(id){
                getBrokerCompanyUserInfo(id).then((res) => {
                    if (res.data.code == '200') {
                        this.options1.push({
                            value: res.data.data.qvDaoCompayXinxi.tQdCompayId,
                            label: res.data.data.qvDaoCompayXinxi.compayname,
                            lpname: res.data.data.qvDaoCompayXinxi.gsLoupan
                        });
                        this.brokerCompanyUserForm = Object.assign({}, res.data.data);

                    } else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },

            //选择渠道公司后绑定楼盘名称
            change1(){
                this.brokerCompanyUserForm.tQdCompayId = this.brokerCompanyUserForm.qvDaoCompayXinxi.tQdCompayId;
                //渠道公司
                for (var x in this.options1) {
                    if (this.options1[x].value == this.brokerCompanyUserForm.qvDaoCompayXinxi.tQdCompayId) {
                        this.brokerCompanyUserForm.qvDaoCompayXinxi.gsLoupan = this.options1[x].lpname;
                    }
                }
            },

            save(){
                this.$refs.brokerCompanyUserForm.validate((valid) => {
                    if (valid) {
                        if (this.brokerCompanyUserForm.tQdPersonId == '' || this.brokerCompanyUserForm.tQdPersonId == null) {
                            let para = {
                                name: this.brokerCompanyUserForm.qdPername,
                                id: this.brokerCompanyUserForm.tQdCompayId
                            };
                            checkName(para).then((res) => {
                                if (res.data.total > 0) {
                                    this.ischeckname = res.data.msg;
                                }
                                this.$confirm(this.ischeckname + '确认提交吗？', '提示', {}).then(() => {
                                    let para = Object.assign({}, this.brokerCompanyUserForm);
                                    para.gsChenglishijian = (!para.gsChenglishijian || para.gsChenglishijian == '') ? '' : new Date(para.gsChenglishijian).toLocaleDateString();
                                    para.qianxieyishijian = (!para.qianxieyishijian || para.qianxieyishijian == '') ? '' : new Date(para.qianxieyishijian).toLocaleDateString();
                                    para.tQdCompayId = para.qvDaoCompayXinxi.tQdCompayId;
                                    addBrokerCompanyUser(para).then((res) => {
                                        if (res.data.code == 200) {
                                            this.$message({
                                                message: '提交成功',
                                                type: 'success'
                                            });
                                        } else {
                                            this.$message({
                                                message: res.data.msg,
                                                type: 'error'
                                            });
                                        };
                                    });
                                    this.$router.push('/brokerCompanyUserList');
                                });
                            })
                        } else {
                            this.$confirm(this.ischeckname + '确认提交吗？', '提示', {}).then(() => {
                                let para = Object.assign({}, this.brokerCompanyUserForm);
                                para.gsChenglishijian = (!para.gsChenglishijian || para.gsChenglishijian == '') ? '' : new Date(para.gsChenglishijian).toLocaleDateString();
                                para.qianxieyishijian = (!para.qianxieyishijian || para.qianxieyishijian == '') ? '' : new Date(para.qianxieyishijian).toLocaleDateString();
                                para.tQdCompayId = para.qvDaoCompayXinxi.tQdCompayId;
                                editBrokerCompanyUser(para).then((res) => {
                                    if (res.data.code == 200) {
                                        this.$message({
                                            message: '提交成功',
                                            type: 'success'
                                        });
                                        this.brokerCompanyUserForm = Object.assign({}, res.data.data);
                                    } else {
                                        this.$message({
                                            message: res.data.msg,
                                            type: 'error'
                                        });
                                    };
                                });
                            });
                        }
                    }
                });
            },
            fanhui(){
                this.$router.push('/brokerCompanyUserList');
            },
            savehistory(){
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            let para = Object.assign({}, this.editForm);
                            para.tQdPersonId = this.$route.query.id;
                            addBrokerCompanyUserHistory(para).then((res) => {

                                if (res.data.code == 200) {
                                    this.$message({
                                        message: '提交成功',
                                        type: 'success'
                                    });
                                } else {
                                    this.$message({
                                        message: res.data.msg,
                                        type: 'error'
                                    });
                                };
                            });
                        });
                    }
                });
            },

            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            disabledInput(){
                var allInputs = document.getElementsByTagName('input');
                var textArea = document.getElementsByTagName('textarea');
                for (let i = 0; i < allInputs.length; i++) {
                    allInputs[i].disabled = "true";
                    allInputs[i].parentNode.className += " is-disabled";
                }
                for (let i = 0; i < textArea.length; i++) {
                    textArea[i].disabled = "true";
                    textArea[i].parentNode.className += " is-disabled";
                }
            },

        },
        mounted() {
            //根据url得到的渠道ID，来获取数据
            if (this.$route.query.id != null) {
                this.getBrokerCompanyUser(this.$route.query);
                this.isname = true;

            }
            //新增页面隐藏跟进记录
            if (this.$route.path == '/brokerCompanyUserList/add') {
                this.showeidt = false;
            }
            //详情页面input禁用
            if (this.$route.path == '/brokerCompanyUserList/view') {
                this.editVisible = false;
                this.disabledInput();
            }
            this.remoteMethodqddj();
        }

    }
</script>