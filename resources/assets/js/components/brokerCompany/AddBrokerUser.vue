<template>

    <el-row >
        <div style="margin-bottom: 60px;"></div>
        <el-form label-Weizhi="right" ref="brokerCompanyUserForm" :rules="brokerCompanyUserFormRules" label-width="180px"
                 :model="brokerCompanyUserForm" class="demo-dynamic">
            <el-col :span="18">

                <el-row>
                    <el-col :span="8">
                        <el-form-item  label="姓名" prop="xingming">
                            <el-input v-model="brokerCompanyUserForm.xingming" :disabled="isname"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item required label="联系电话" v-for="(item, index) in brokerCompanyUserForm.telList"
                              :key="item.key">
                    <el-col :span="8">
                        <el-form-item  :prop="'telList.' + index + '.dianhua' " :rules="[
                                {required: true, message: '不能为空'},
                                {required: true, validator: MycheckPhone, trigger: 'blur' },
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
                        <el-form-item required label="所在业务区域" prop="yewuqvyvId">
                            <el-select v-model="brokerCompanyUserForm.yewuqvyvId" placeholder=""
                                       @change="remoteMethoddtqy"
                            >
                                <el-option
                                        v-for="item in optionsywqy"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label-width="10px" prop="yewupianqvId">
                            <el-select v-model="brokerCompanyUserForm.yewupianqvId" placeholder="地图区域"
                                       @change="changedtqy" >
                                <el-option
                                        v-for="item in optionsdtqy"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item  label="幼狮联系人1" prop="yslianxiren1Id">
                            <el-select
                                    v-model="brokerCompanyUserForm.yslianxiren1Id"
                                    filterable
                                    remote
                                    @change="changeyslxr1"
                                    placeholder="请输入幼狮联系人"
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
                    <el-col :span="8">
                        <el-form-item  label="幼狮联系人2" prop="yslianxiren2Id">
                            <el-select
                                    v-model="brokerCompanyUserForm.yslianxiren2Id"
                                    filterable
                                    remote
                                    @change="changeyslxr2"
                                    placeholder="请输入幼狮联系人"
                                    :remote-method="remoteMethodyslxr2"
                                    :loading="fristyslxrloading2">
                                <el-option
                                        v-for="item in optionsyslxr2"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="幼狮联系人3" prop="yslianxiren3Id">
                            <el-select
                                    v-model="brokerCompanyUserForm.yslianxiren3Id"
                                    filterable
                                    remote
                                    @change="changeyslxr3"
                                    placeholder="请输入幼狮联系人"
                                    :remote-method="remoteMethodyslxr3"
                                    :loading="fristyslxrloading3">
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
                <el-row>

                    <el-col :span="8">
                        <el-form-item label="是否添加微信好友" prop="shifouweixin">
                            <el-radio-group v-model="brokerCompanyUserForm.shifouweixin"  @change="changehaoyou">
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
                            <el-radio-group v-model="brokerCompanyUserForm.shifoudaikanyoushi"   @change="changedaikan">
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
                        <el-form-item label="是否签约过幼狮" prop="shifoudaikanyoushifang">
                            <el-radio-group v-model="brokerCompanyUserForm.shifoudaikanyoushifang"  @change="changeqianyue">
                                <el-radio :label=true>是</el-radio>
                                <el-radio :label=false>否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="签约次数" prop="qianyuecishu"  v-if="isqy">
                            <el-input v-model.number="brokerCompanyUserForm.qianyuecishu"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="签约对接人数" prop="qianyueduijierenshu"  v-if="isqy">
                            <el-input v-model.number="brokerCompanyUserForm.qianyueduijierenshu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="渠道等级" prop="qvdaodengji">
                    <el-select v-model="brokerCompanyUserForm.qvdaodengji" placeholder="">
                        <el-option
                                v-for="item in optionsqddj"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-row>
                    <el-col :span="8">
                        <el-form-item label="佣金类型" prop="yjType">
                            <el-select v-model="brokerCompanyUserForm.yjType" placeholder="请输入佣金类型"  @change="changeDJ">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="收房佣金占比" prop="yjzbSf">
                            <el-input v-model.number="brokerCompanyUserForm.yjzbSf"   auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="出房佣金占比" prop="yjzbCf">
                            <el-input v-model.number="brokerCompanyUserForm.yjzbCf" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="备注" prop="beizhu">
                    <el-input type="textarea" v-model="brokerCompanyUserForm.beizhu" auto-complete="off"></el-input>
                </el-form-item>
            </el-col>
        </el-form>
        <el-button type="primary" v-show="editVisible" @click="save" style="margin-left:50%;">保存</el-button>
        <el-button  v-show="editVisible" @click.native="fanhui">返回</el-button>
        <el-col>
            <div v-show="showeidt">
                <el-button @click.native="change">跟进记录</el-button>
                <add-history v-show="showhistory"></add-history>

            <div v-show="showed">
                <el-form :model="editForm" label-width="180px" :rules="editFormRules" ref="editForm" label-Weizhi="right" >

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
                            <el-input type="textarea" v-model="editForm.shuoming" auto-complete="off" style="width:1100px"></el-input>
                        </el-form-item>
                    </el-row>
                    <a href='javascript:;' @click="openHistory" >查看历史记录</a>
                </el-form>
                <el-button type="primary" v-show="editVisible" @click="savehistory" style="margin-left:37%;">保存</el-button>
                <el-button v-show="editVisible" @click.native="fanhui">返回</el-button>
            </div>

            </div>
        </el-col>
    </el-row>
</template>
<script>
    import { getQDDJDicList,
        getYWQYDicList,
        getFanghaoList,
        getBrokerUserInfo,
        addBrokerUser,
        editBrokerUser,
        addBrokerUserHistory,
        getYSLXRDicList,
        checkPhone,
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    import AddHistory from './BrokerUserHistoryList.vue'
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
                ischanged:false,
                showhistory:false,
                ishy: true,
                isdk: true,
                isqy: true,
                isname: false,
                brokerCompanyUserForm: {
                    tQdZyPersonId: '',
                    xingming: '',
                    zhiwu: '',
                    yewuqvyv: '',
                    yewuqvyvId: '',
                    yewupianqv: '',
                    yewupianqvId: '',
                    yslianxiren1: null,
                    yslianxiren1Id: null,
                    yslianxiren2: null,
                    yslianxiren2Id: null,
                    yslianxiren3: null,
                    yslianxiren3Id: null,
                    shifouweixin: true,
                    tianjiahaoyourenshu: null,
                    shifoudaikanyoushi: true,
                    daikancishu: null,
                    daikanduijierenshu: null,
                    shifoudaikanyoushifang: true,
                    qianyuecishu: null,
                    qianyueduijierenshu:null,
                    qvdaodengji: null,
                    beizhu: null,
                    yjType: 2,
                    yjzbSf: 0.08,
                    yjzbCf: 0.08,
                    zhuangtai: null,
                    telList: [
                        {
                            tQdPersonTelId: 0,
                            dianhua: '',
                            qdType: '',
                            personid:''
                        }
                    ],
                    persontype: 1,
                    genjinDate: null,
                    wanchengdu: ''
                },
                list:[],
                brokerCompanyUserFormRules: {
                    xingming: [
                        {required: true, message: '不能为空'},
                    ],
                    zhiwu: [
                        {required: true, message: '不能为空'},
                    ],
                    yewuqvyvId: [
                        {required: true, message: '不能为空'},
                    ],
                    yewupianqvId: [
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
                    yjzbSf: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                        {
                            required: true, validator: (rule, value, callback) => {
                            if (value > 1 || value < 0) {
                                callback(new Error("收房佣金占比只能是0到1之间的数"));
                            } else {
                                callback();
                            }
                        }, trigger: 'blur'
                        }
                    ],
                    yjzbCf: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                        {
                            required: true, validator: (rule, value, callback) => {
                            if (value > 1 || value < 0) {
                                callback(new Error("出房佣金占比只能是0到1之间的数"));
                            } else {
                                callback();
                            }
                        }, trigger: 'blur'
                        }
                    ],
                    yjType: [
                        {required: true, message: '不能为空'},
                    ],
                },
                editVisible:true,
                bkNameloading: false,
                options1:[],
                optionsqddj:[],
                optionsywqy: [],//业务区域
                optionsdtqy: [],//地图区域
                optionsyslxr1:[],
                fristyslxrloading1:false,
                optionsyslxr2:[],
                fristyslxrloading2:false,
                optionsyslxr3:[],
                fristyslxrloading3:false,
                //房源数据初始化
                showeidt:true,
                options: [
                    {
                        value: 1,
                        label: '按月租金'
                    }, {
                        value: 2,
                        label: '按年租金'
                    },
                ],
                //编辑界面数据
                editLoading: false,
                editForm: {
                    tQdCompayId: 0,
                    shifouyouxiao: null,
                    xinxishifouzhunque: null,
                    shifouzhuanhang:null,
                    shuoming: '',
                },
                editFormRules: {
                    shifouyouxiao:[{required: true, message: '不能为空'},],
                    xinxishifouzhunque:[{required: true, message: '不能为空'},],
                    shifouzhuanhang:[{required: true, message: '不能为空'},],
                },
            }
        },
        methods: {
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
            openHistory(){
                window.open("/#/brokerUserHistory?id=" + this.$route.query.id);
            },
            fanhui(){
                this.$router.push('/brokerUser');
            },
            changehaoyou(){
                if (this.brokerCompanyUserForm.shifouweixin == true) {
                    this.ishy = true;

                } else {
                    this.ishy = false;
                }

            },
            changedaikan(){
                if (this.brokerCompanyUserForm.shifoudaikanyoushi == true) {
                    this.isdk = true;
                } else {
                    this.isdk = false;
                }

            },
            changeqianyue(){
                if (this.brokerCompanyUserForm.shifoudaikanyoushifang == true) {
                    this.isqy = true;
                } else {
                    this.isqy = false;
                }

            },
            //增加
            addFreeItem() {
                this.brokerCompanyUserForm.telList.push({
                    "tQdPersonTelId": 0,
                    "dianhua": '',
                    "qdType": '',
                    "personid": ''
                });
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
            checkPhone(rule, value, callback) {
                if (value != null && value != '') {
                    let para = {
                        phone: value,
                    };
                    if (value != '') {
                        checkPhone(para).then((res) => {
                            if (res.data.code != '200') {
                                callback(res.data.msg);
                            } else {
                                callback();
                            }
                        })
                    }
                } else {
                    callback();
                }

            },
            //显示和隐藏跟进记录
            change(){
                if (this.$route.path =='/brokerUser/view') {
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
            changedtqy(){
                for (var x in this.optionsdtqy) {
                    if (this.optionsdtqy[x].value == this.brokerCompanyUserForm.yewupianqvId) {
                        this.brokerCompanyUserForm.yewupianqv = this.optionsdtqy[x].label;
                    }
                }
            },
            //获取幼狮联系人列表
            remoteMethodyslxr1(query) {
                let para = {
                    uname: query
                };
                this.list = [];
                this.fristyslxrloading1 = true;
                getYSLXRDicList(para).then((res) => {
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
            //获取幼狮联系人列表
            remoteMethodyslxr2(query) {
                let para = {
                    uname: query
                };
                this.list = [];
                this.fristyslxrloading2 = true;
                getYSLXRDicList(para).then((res) => {
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
            //获取幼狮联系人列表
            remoteMethodyslxr3(query) {
                let para = {
                    uname: query
                };
                this.list = [];
                this.fristyslxrloading3 = true;
                getYSLXRDicList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[i] = res.data[i]
                    }
                    this.estate = arr;
                    this.fristyslxrloading3 = false;
                    this.list = this.estate.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.fristyslxrloading3 = true;
                        setTimeout(() => {

                            this.fristyslxrloading3 = false;
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
            //获取公司业务区域
            remoteMethodywqy() {
                let para = {
                    parentid: 0,
                };
                this.optionsywqy = [];
                getYWQYDicList(para).then((res) => {

                    if (res.status == '200') {
                        for (var item in res.data.data) {

                            this.optionsywqy.push({value: res.data.data[item].id, label: res.data.data[item].fdName});
                        }
                    } else {
                        this.$message({
                            message: '获取业务区域数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            //获取公司业务区域id获取地图区域列表
            remoteMethoddtqy() {

                let para = {
                    parentid: this.brokerCompanyUserForm.yewuqvyvId,
                };
                for (var x in this.optionsywqy) {
                    if (this.optionsywqy[x].value == this.brokerCompanyUserForm.yewuqvyvId) {
                        this.brokerCompanyUserForm.yewuqvyv = this.optionsywqy[x].label;
                    }
                }
                if(this.ischanged){
                    this.optionsdtqy = [];
                    this.brokerCompanyUserForm.yewupianqvId = null;//清除地图区域的缓存
                    getYWQYDicList(para).then((res) => {
                        if (res.status == '200') {
                            for (var item in res.data.data) {
                                this.optionsdtqy.push({value: res.data.data[item].id, label: res.data.data[item].fdName});
                            }
                        } else {
                            this.$message({
                                message: '获取行政区域数据失败',
                                type: 'error'
                            });
                        }
                    })
                }
            },
            //根据url得到的 ID，来获取数据
            getBrokerUser(id){
                getBrokerUserInfo(id).then((res) => {
                    if (res.data.code == '200') {
                        this.optionsyslxr1.push( {value: res.data.data.yslianxiren1Id,
                            label:res.data.data.yslianxiren1}) ;
                        this.optionsyslxr2.push( {value: res.data.data.yslianxiren2Id,
                            label:res.data.data.yslianxiren2}) ;
                        this.optionsyslxr3.push( {value: res.data.data.yslianxiren3Id,
                            label:res.data.data.yslianxiren3}) ;
                        this.optionsdtqy.push( {value: res.data.data.yewupianqvId,
                            label:res.data.data.yewupianqv}) ;
                        this.brokerCompanyUserForm= Object.assign({}, res.data.data );
                    } else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },

            changeyslxr1(){
                for (var x in this.optionsyslxr1) {
                    if (this.optionsyslxr1[x].value == this.brokerCompanyUserForm.yslianxiren1Id) {
                        this.brokerCompanyUserForm.yslianxiren1 = this.optionsyslxr1[x].label;
                    }
                }
            },
            changeyslxr2(){
                for (var x in this.optionsyslxr2) {
                    if (this.optionsyslxr2[x].value == this.brokerCompanyUserForm.yslianxiren2Id) {
                        this.brokerCompanyUserForm.yslianxiren2= this.optionsyslxr2[x].label;
                    }
                }
            },

            changeyslxr3(){
                for (var x in this.optionsyslxr3) {
                    if (this.optionsyslxr3[x].value == this.brokerCompanyUserForm.yslianxiren3Id) {
                        this.brokerCompanyUserForm.yslianxiren3 = this.optionsyslxr3[x].label;
                    }
                }
            },
            changeDJ()
            {
                // alert(this.brokerCompanyFrom.yjType );
                if (this.brokerCompanyUserForm.yjType == 2) {
                    this.brokerCompanyUserForm.yjzbSf = 0.08;
                    this.brokerCompanyUserForm.yjzbCf = 0.08;
                } else {
                    this.brokerCompanyUserForm.yjzbSf = 0.96;
                    this.brokerCompanyUserForm.yjzbCf = 0.96;
                }
            },
            save(){
                this.$refs.brokerCompanyUserForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            let para = Object.assign({}, this.brokerCompanyUserForm);

                            if (this.brokerCompanyUserForm.tQdZyPersonId!=''&&this.brokerCompanyUserForm.tQdZyPersonId!=null) {

                                editBrokerUser(para).then((res) => {
                                    if(res.data.code==200){
                                        this.$message({
                                            message: '提交成功',
                                            type: 'success'
                                        });
                                    }else{
                                        this.$message({
                                            message: res.data.msg,
                                            type: 'error'
                                        });

                                    };
                                });
                            }else{
                                addBrokerUser(para).then((res) => {
                                    if(res.data.code==200){
                                        this.$message({
                                            message: '提交成功',
                                            type: 'success'
                                        });
                                    }else{
                                        this.$message({
                                            message: res.data.msg,
                                            type: 'error'
                                        });

                                    };
                                    this.$router.push('/brokerUser');
                                });
                            }
                        });
                    }
                });
            },
            savehistory(){
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            let para = Object.assign({}, this.editForm);
                            para.tQdZyPersonId=this.$route.query.id;
                            addBrokerUserHistory(para).then((res) => {

                                if(res.data.code==200){
                                    this.$message({
                                        message: '提交成功',
                                        type: 'success'
                                    });
                                }else{
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
            hello(){
                this.ischanged=true;
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
                for (let i=0; i<allInputs.length; i++){
                    allInputs[i].disabled="true";
                    allInputs[i].parentNode.className += " is-disabled";
                }
                for (let i=0; i<textArea.length; i++){
                    textArea[i].disabled="true";
                    textArea[i].parentNode.className += " is-disabled";
                }
            },
        },
        mounted() {
            //根据url得到的渠道ID，来获取数据
            if (this.$route.query.id != null) {
                this.getBrokerUser(this.$route.query);
                this.isname = true;
            }
            //新增页面隐藏跟进记录
            if (this.$route.path == '/brokerUser/add') {
                this.showeidt = false;

            }
            //详情页面input禁用
            if (this.$route.path == '/brokerUser/view') {
                this.editVisible = false;
                this.disabledInput();
            }
            this.remoteMethodywqy();
            this.remoteMethodqddj();
            setTimeout(this.hello,1000);
        }

    }
</script>