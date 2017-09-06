<template>
    <el-row>
        <div style="margin-bottom: 60px;"></div>
        <el-form label-Weizhi="right" ref="brokerCompanyFrom" :rules="brokerCompanyFromRules" label-width="180px"
                 :model="brokerCompanyFrom" class="demo-dynamic">
            <el-col :span="18">

                <el-row>
                    <el-col :span="8">
                        <el-form-item label="公司名称" prop="compayname"   >
                            <el-input v-model="brokerCompanyFrom.compayname"  :disabled="iscompayname" placeholder="请输入公司名称"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="公司所在业务区域" prop="yewuqvyvid">
                            <el-select v-model="brokerCompanyFrom.yewuqvyvid" placeholder="请选择区域"
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
                        <el-form-item label-width="10px" prop="yewupianqvid">
                            <el-select v-model="brokerCompanyFrom.yewupianqvid" placeholder="请选择地图区域"
                                       @change="changedtqy">
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
                        <el-form-item required label="公司详细地址" prop="addr">
                            <el-input value="北京市" disabled="disabled"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="5">
                        <el-form-item label-width="10px" prop="dzXingzhengqvyvId">
                            <el-select v-model="brokerCompanyFrom.dzXingzhengqvyvId" placeholder="请选择行政区"
                                       @change="remoteMethodJD">
                                <el-option
                                        v-for="item in optionszzqy"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="5">
                        <el-form-item label-width="10px" prop="dzJiedaoId">
                            <el-select v-model="brokerCompanyFrom.dzJiedaoId" placeholder="请选择街道"
                                       @change="changejdqy">
                                <el-option
                                        v-for="item in optionsjdqy"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="7">
                        <el-form-item label-width="10px" prop="dzXiangxi">
                            <el-input v-model="brokerCompanyFrom.dzXiangxi" placeholder="请输入公司详细地址"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="公司所在楼盘" prop="gsLoupan">
                            <el-input v-model="brokerCompanyFrom.gsLoupan" placeholder="请输入公司所在楼盘"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="公司规模" prop="gsGuimo">
                            <el-input v-model.number="brokerCompanyFrom.gsGuimo" placeholder="请输入公司规模"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="公司成立时间" prop="gsChenglishijian">
                            <el-date-picker type="date" placeholder="请输入公司成立时间"
                                            v-model="brokerCompanyFrom.gsChenglishijian">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="主做区域" prop="zhuzuoqvyv">
                    <el-checkbox-group v-model="brokerCompanyFrom.zhuzuoqvyv" :disabled="isckdis">
                        <el-checkbox v-for="city in optionszzqy" :label="city.label" :key="city.value"
                                     :value="city.value"  :disabled="isckdis">{{city.label}}
                        </el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="是否有过合作" prop="shifouhezuoguo">
                            <el-radio-group v-model="brokerCompanyFrom.shifouhezuoguo"
                                            @change="changeHeZuoCiShu">
                                <el-radio :label=true>是</el-radio>
                                <el-radio :label=false>否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="合作次数" prop="hezuocishu"  v-if="isdis">
                            <el-input v-model.number="brokerCompanyFrom.hezuocishu"   placeholder="请输入合作次数" ></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                <el-col :span="8">
                <el-form-item label="是否签署合作协议" prop="shifouhezuoxieyi">
                    <el-radio-group v-model="brokerCompanyFrom.shifouhezuoxieyi"
                    @change="changeHeZuoxieyi"  >
                        <el-radio :label=true>是</el-radio>
                        <el-radio :label=false>否</el-radio>
                    </el-radio-group>
                </el-form-item>
                </el-col>
                    <el-col :span="8">
                        <el-form-item label="签署合作协议时间" prop="qianxieyishijian" v-if="isqydis">
                            <el-date-picker type="date" placeholder="请输入签署合作协议时间"
                                            v-model="brokerCompanyFrom.qianxieyishijian"  >
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="合作协议等级" prop="hezuoxieyidengji"  v-if="isqydis">
                            <el-select v-model="brokerCompanyFrom.hezuoxieyidengji" placeholder="请输入合作协议等级"
                                       @change="changeDJ">
                                <el-option
                                        v-for="item in optionsxydj"
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
                        <el-form-item label="幼狮联系人1" prop="yslianxiren1Id">
                            <el-select
                                    v-model="brokerCompanyFrom.yslianxiren1Id"
                                    filterable
                                    remote
                                    @change="changeyslxr1"
                                    placeholder="请选择幼狮联系人"
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
                        <el-form-item label="幼狮联系人2" prop="yslianxiren2Id">
                            <el-select
                                    v-model="brokerCompanyFrom.yslianxiren2Id"
                                    filterable
                                    remote
                                    @change="changeyslxr2"
                                    placeholder="请选择幼狮联系人"
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
                        <el-form-item label="幼狮联系人3" prop="yslianxiren3Id">
                            <el-select
                                    v-model="brokerCompanyFrom.yslianxiren3Id"
                                    filterable
                                    remote
                                    @change="changeyslxr3"
                                    placeholder="请选择幼狮联系人"
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
                        <el-form-item label="法人姓名" prop="farenxingming">
                            <el-input v-model="brokerCompanyFrom.farenxingming"  placeholder="请输入法人姓名"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="法人联系方式" prop="farenlianxifangshi">
                            <el-input v-model="brokerCompanyFrom.farenlianxifangshi" placeholder="请输入法人联系方式"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="负责人姓名" prop="fuzeren">
                            <el-input v-model="brokerCompanyFrom.fuzeren" placeholder="请输入负责人姓名"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="负责人联系方式" prop="fuzerenlianxifangshi">
                            <el-input v-model="brokerCompanyFrom.fuzerenlianxifangshi"  placeholder="请输入负责人联系方式"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="佣金类型" prop="yjType">
                            <el-select v-model="brokerCompanyFrom.yjType" placeholder="请选择佣金类型"
                                       @change="changeDJ">
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
                            <el-input v-model.number="brokerCompanyFrom.yjzbSf" auto-complete="off" placeholder="请输入收房佣金占比"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="出房佣金占比" prop="yjzbCf">
                            <el-input v-model.number="brokerCompanyFrom.yjzbCf" auto-complete="off" placeholder="请输入出房佣金占比"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="公司经营属性" prop="gongsijingyingshuxing">
                    <el-checkbox-group v-model="brokerCompanyFrom.gongsijingyingshuxing" >
                        <el-checkbox  v-for="city in optionsgssx" :label="city.label" :key="city.value"
                                     :value="city.value"  :disabled="isckdis">{{city.label}}
                        </el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-form-item label="服务对象" prop="fuwuduixiang">
                    <el-checkbox-group v-model="brokerCompanyFrom.fuwuduixiang"   >
                        <el-checkbox v-for="city in optionsfwdx" :label="city.label" :key="city.value"
                                     :value="city.value"  :disabled="isckdis">
                        </el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-form-item label="综合评价" prop="zonghepingjia">
                    <el-rate v-model="brokerCompanyFrom.zonghepingjia" :disabled="isckdis"   ></el-rate>
                </el-form-item>
                <el-form-item label="通讯录" prop="tongxunlu">
                    <el-upload
                            action="https://jsonplaceholder.typicode.com/posts/"
                            list-type="picture-card"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemove">
                        <i class="el-icon-plus"></i>
                    </el-upload>
                </el-form-item>
                <el-dialog v-model="dialogVisible" size="tiny">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>
                <el-form-item label="合作协议" prop="hezuoxieyi">
                    <el-upload
                            action="https://jsonplaceholder.typicode.com/posts/"
                            list-type="picture-card"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemove">
                        <i class="el-icon-plus"></i>
                    </el-upload>
                </el-form-item>
                <el-dialog v-model="dialogVisible" size="tiny">
                    <img width="100%" :src="dialogImageUrl" alt="">
                </el-dialog>
                <el-form-item label="备注" prop="beizhu">
                    <el-input type="textarea" v-model="brokerCompanyFrom.beizhu" auto-complete="off"></el-input>
                </el-form-item>
                <el-button type="primary" v-show="editVisible" @click="save" style="margin-left:50%;">提交</el-button>
                <el-button v-show="editVisible" @click.native="fanhui">返回</el-button>
            </el-col>

        </el-form>

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
                                    <el-radio :label=1>有效</el-radio>
                                    <el-radio :label=2>无效</el-radio>
                                    <el-radio :label=3>无法取得联系</el-radio>
                                </el-radio-group>
                            </el-form-item>
                        </el-row>
                        <el-row :span="18">
                            <el-form-item label="信息是否准确" prop="xinxishifouzhunque">
                                <el-radio-group v-model="editForm.xinxishifouzhunque">
                                    <el-radio :label=1>上报信息准确</el-radio>
                                    <el-radio :label=2>上报信息不准确</el-radio>
                                </el-radio-group>
                            </el-form-item>
                        </el-row>
                        <el-row :span="18">
                            <el-form-item label="内容" prop="shuoming">
                                <el-input type="textarea" v-model="editForm.shuoming" auto-complete="off"
                                          style="width:1100px"></el-input>
                            </el-form-item>
                        </el-row>
                        <a href='javascript:;'  @click="openHistory">查看历史记录</a>
                    </el-form>
                    <el-button type="primary" v-show="editVisible" @click="savehistory" style="margin-left:37%;">保存
                    </el-button>
                    <el-button @click.native="fanhui">返回</el-button>
                </div>

            </div>

        </el-col>
    </el-row>
</template>

<script>
    import {
        getLoupanList,
        checkbkNameList,
        getbkNameList,
        getPurchaseContractInfo,
        addBrokerCompanyHistory,
        getGSSXDicList,
        getFWDXDicList,
        getYWQYDicList,
        getXZQYDicList,
        getJDDicList,
        getXYDJDicList,
        getYSLXRDicList,
        addBrokerCompany,
        getBrokerCompanyInfo,
        editBrokerCompany
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    import AddHistory from './HistoryList.vue'
    export default {
        components: {
            ElRow,
            AddHistory
        },
        data() {
            return {
                isdis:true,
                iscompayname:false,
                isqydis:true,
                dialogImageUrl: '',
                isckdis:false,
                dialogVisible: false,
                showed: false,
                showhistory: false,
                brokerCompanyFrom: {
                    tQdCompayId: '',
                    compayname: '',
                    compaytest: '',
                    tbPersonIdCreate: '',
                    yjzbSf: '',
                    yjzbCf: '',
                    yjType: 2,
                    yewuqvyv: '',
                    yewuqvyvid: '',
                    yewupianqv: '',
                    yewupianqvid: '',
                    dzXingzhengqvyv: '',
                    dzXingzhengqvyvId: '',
                    dzJiedao: '',
                    dzJiedaoId: '',
                    dzXiangxi: '',
                    gsLoupan: '',
                    gsGuimo: '',
                    gsChenglishijian: '',
                    zhuzuoqvyv: [],
                    zhuzuoqvyvids: '',
                    shifouhezuoguo: true,
                    hezuocishu: '',
                    shifouhezuoxieyi: true,
                    qianxieyishijian: '',
                    hezuoxieyidengji: '',
                    yslianxiren1: '',
                    yslianxiren1Id: '',
                    yslianxiren2: '',
                    yslianxiren2Id: '',
                    yslianxiren3: '',
                    yslianxiren3Id: '',
                    farenxingming: '',
                    farenlianxifangshi: '',
                    gongsijingyingshuxingid: '',
                    gongsijingyingshuxing: [],
                    fuwuduixiang: [],
                    zonghepingjia: null,
                    tongxunlu: '',
                    hezuoxieyi: '',
                    beizhu: '',
                    zhuangtai: '',
                    fuzerenlianxifangshi:'',
                    fuzeren:'',
                },
                purchaseContract: {
                    type: 0,
                },
                brokerCompanyFromRules: {
                    compayname: [
                        {required: true, message: '不能为空'},
                    ],
                    yewuqvyvid: [
                        {required: true, message: '不能为空'},
                    ],
                    yewupianqvid: [
                        {required: true, message: '不能为空'},
                    ],
                    dzXingzhengqvyvId: [
                        {required: true, message: '不能为空'},
                    ],
                    dzJiedaoId: [
                        {required: true, message: '不能为空'},
                    ],
                    dzXiangxi: [
                        {required: true, message: '不能为空'},
                    ],
                    zhuzuoqvyv: [
                        {required: true, message: '不能为空'},
                    ],
                    shifouhezuoguo: [
                        {required: true, message: '不能为空'},
                    ],
                    shifouhezuoxieyi: [
                        {required: true, message: '不能为空'},
                    ],
                    gongsijingyingshuxing: [
                        {required: true, message: '不能为空'},
                    ],
                    fuwuduixiang: [
                        {required: true, message: '不能为空'},
                    ],
                    hezuoxieyidengji: [
                        {required: true, message: '不能为空'},
                    ],
                    yslianxiren1Id: [
                        {required: true, message: '不能为空'},
                    ],
                    gsGuimo: [{
                        validator: (rule, value, callback) => {
                            if (value != ''&&value != null) {
                                if (/^\d+$/.test(value) == false) {
                                    callback(new Error("必须为数字"));
                                } else {
                                    callback();
                                }
                            } else {
                                callback();
                            }
                        }, trigger: 'blur'
                    }
                    ],
                    farenlianxifangshi: [{
                        validator: (rule, value, callback) => {
                            if (value != ''&&value != null) {
                                if (/^\d+$/.test(value) == false) {
                                    callback(new Error("必须为数字"));
                                } else {
                                    callback();
                                }
                            } else {
                                callback();
                            }
                        }, trigger: 'blur'
                    }
                    ],
                    fuzerenlianxifangshi: [{
                        validator: (rule, value, callback) => {
                            if (value != ''&&value != null) {
                                if (/^\d+$/.test(value) == false) {
                                    callback(new Error("必须为数字"));
                                } else {
                                    callback();
                                }
                            } else {
                                callback();
                            }
                        }, trigger: 'blur'
                    }
                    ],
                    hezuocishu:[{required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'}],
                    qianxieyishijian:[{required: true, message: '不能为空'}],
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
                options: [
                    {
                        value: 1,
                        label: '按月租金'
                    }, {
                        value: 2,
                        label: '按年租金'
                    },
                ],
                optionszzqy: [],//主做区域、行政区域
                showeidt: true,
                editVisible: true,
                optionsgssx: [],//公司属性
                optionsfwdx: [],//服务对象
                optionsywqy: [],//业务区域
                optionsdtqy: [],//地图区域
                optionsjdqy: [],//街道区域
                optionsyslxr1: [],
                fristyslxrloading1: false,
                optionsyslxr2: [],
                fristyslxrloading2: false,
                optionsyslxr3: [],
                fristyslxrloading3: false,
                optionsxydj: [],//协议等级
                fristyslxrloading: false,
                //楼盘数据
                options1: [],
                list1: [],
                ischanged: false,


                //编辑界面数据
                editLoading: false,
                editForm: {
                    tQdCompayId: 0,
                    shifouyouxiao: null,
                    xinxishifouzhunque: null,
                    shuoming: '',
                },
                editFormRules: {
                    shifouyouxiao:[{required: true, message: '不能为空'},],
                    xinxishifouzhunque:[{required: true, message: '不能为空'},],

                },
            }
        },
        methods: {
             fanhui(){
              this.$router.push('/brokerCompany');
             },
            //显示和隐藏跟进记录
            change(){
                if (this.$route.path == '/brokerCompany/view') {
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
            changeHeZuoCiShu(){
                if (this.brokerCompanyFrom.shifouhezuoguo == true) {
                    this.isdis=true;
                } else {
                    this.isdis=false;
                }

            },
            changeHeZuoxieyi(){
                if (this.brokerCompanyFrom.shifouhezuoxieyi == true) {
                    this.isqydis=true;
                } else {
                    this.isqydis=false;
                }

            },
            //获取公司属性
            remoteMethodgssx() {
                getGSSXDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsgssx.push({
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

            changeyslxr1(){
                for (var x in this.optionsyslxr1) {
                    if (this.optionsyslxr1[x].value == this.brokerCompanyFrom.yslianxiren1Id) {
                        this.brokerCompanyFrom.yslianxiren1 = this.optionsyslxr1[x].label;
                    }
                }
            },
            changeyslxr2(){
                for (var x in this.optionsyslxr2) {
                    if (this.optionsyslxr2[x].value == this.brokerCompanyFrom.yslianxiren2Id) {
                        this.brokerCompanyFrom.yslianxiren2 = this.optionsyslxr2[x].label;
                    }
                }
            },
            changeyslxr3(){
                for (var x in this.optionsyslxr3) {
                    if (this.optionsyslxr3[x].value == this.brokerCompanyFrom.yslianxiren3Id) {
                        this.brokerCompanyFrom.yslianxiren3 = this.optionsyslxr3[x].label;
                    }
                }
            },
            changedtqy(){
                for (var x in this.optionsdtqy) {
                    if (this.optionsdtqy[x].value == this.brokerCompanyFrom.yewupianqvid) {
                        this.brokerCompanyFrom.yewupianqv = this.optionsdtqy[x].label;
                    }
                }
            },
            changejdqy(){
                for (var x in this.optionsjdqy) {
                    if (this.optionsjdqy[x].value == this.brokerCompanyFrom.dzJiedaoId) {
                        this.brokerCompanyFrom.dzJiedao = this.optionsjdqy[x].label;
                    }
                }
            },
            //获取公司服务对象
            remoteMethodfwdx() {
                getFWDXDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsfwdx.push({
                                value: res.data.data[item].enumValue,
                                label: res.data.data[item].enumKey
                            });
                        }
                    } else {
                        this.$message({
                            message: '获取公司服务对象数据失败',
                            type: 'error'
                        });
                    }
                })
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
            //获取公司行政区域/主做区域
            remoteMethodzzqy() {
                let para = {
                    code: 110000,
                };
                this.optionszzqy = [];
                getXZQYDicList(para).then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionszzqy.push({
                                value: res.data.data[item].fdcode,
                                label: res.data.data[item].fdname
                            });
                        }
                    } else {
                        this.$message({
                            message: '获取行政区域数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            //获取公司业务区域id获取地图区域列表
            remoteMethoddtqy() {
                let para = {
                    parentid: this.brokerCompanyFrom.yewuqvyvid,
                };
                for (var x in this.optionsywqy) {
                    if (this.optionsywqy[x].value == this.brokerCompanyFrom.yewuqvyvid) {
                        this.brokerCompanyFrom.yewuqvyv = this.optionsywqy[x].label;
                    }
                }
                if (this.ischanged) {
                    this.optionsdtqy = [];
                    this.brokerCompanyFrom.yewupianqvid = null;//清除地图区域的缓存
                    getYWQYDicList(para).then((res) => {
                        if (res.status == '200') {
                            for (var item in res.data.data) {
                                this.optionsdtqy.push({
                                    value: res.data.data[item].id,
                                    label: res.data.data[item].fdName
                                });
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
            //获取行政区域id获取街道列表
            remoteMethodJD() {
                let para = {
                    code: this.brokerCompanyFrom.dzXingzhengqvyvId,
                };
                if (this.ischanged) {
                    this.brokerCompanyFrom.dzJiedaoId = null;//清除街道的缓存
                    this.optionsjdqy = [];
                    getJDDicList(para).then((res) => {
                        if (res.status == '200') {

                            for (var item in res.data.data) {
                                this.optionsjdqy.push({
                                    value: res.data.data[item].fdcode,
                                    label: res.data.data[item].fdname
                                });
                            }
                        } else {
                            this.$message({
                                message: '获取街道数据失败',
                                type: 'error'
                            });
                        }
                    })
                }
            },

            //获取协议等级
            remoteMethodXYDJ() {
                this.optionsxydj = [];
                getXYDJDicList().then((res) => {
                    if (res.status == '200') {
                        for (var item in res.data.data) {
                            this.optionsxydj.push({
                                value: res.data.data[item].enumValue,
                                label: res.data.data[item].enumKey,
                                yjvalue: parseFloat(res.data.data[item].enumValues)
                            });
                        }
                    } else {
                        this.$message({
                            message: '获取协议等级数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            changeDJ()
            {
                // alert(this.brokerCompanyFrom.yjType );
                if (this.brokerCompanyFrom.yjType == 2) {
                    for (var x in this.optionsxydj) {
                        if (this.optionsxydj[x].label == this.brokerCompanyFrom.hezuoxieyidengji) {
                            this.brokerCompanyFrom.yjzbSf = this.optionsxydj[x].yjvalue;
                            this.brokerCompanyFrom.yjzbCf = this.optionsxydj[x].yjvalue;
                        }
                    }
                } else {
                    this.brokerCompanyFrom.yjzbSf = null;
                    this.brokerCompanyFrom.yjzbCf = null;
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
            //根据url得到的合同ID，来获取数据
            getBrokerCompany(id){
                getBrokerCompanyInfo(id).then((res) => {
                    if (res.data.code == '200') {
                        this.optionsyslxr1.push({
                            value: res.data.data.yslianxiren1Id,
                            label: res.data.data.yslianxiren1
                        });
                        this.optionsyslxr2.push({
                            value: res.data.data.yslianxiren2Id,
                            label: res.data.data.yslianxiren2
                        });
                        this.optionsyslxr3.push({
                            value: res.data.data.yslianxiren3Id,
                            label: res.data.data.yslianxiren3
                        });
                        this.optionsdtqy.push({
                            value: res.data.data.yewupianqvid,
                            label: res.data.data.yewupianqv
                        });
                        this.optionsjdqy.push({
                            value: res.data.data.dzJiedaoId,
                            label: res.data.data.dzJiedao
                        });
                        this.brokerCompanyFrom = Object.assign({}, res.data.data);
                        this.brokerCompanyFrom.gongsijingyingshuxing = this.brokerCompanyFrom.gongsijingyingshuxing == null ? [] : this.brokerCompanyFrom.gongsijingyingshuxing.split(',');
                        this.brokerCompanyFrom.fuwuduixiang = this.brokerCompanyFrom.fuwuduixiang == null ? [] : this.brokerCompanyFrom.fuwuduixiang.split(',');
                        this.brokerCompanyFrom.zhuzuoqvyv = this.brokerCompanyFrom.zhuzuoqvyv == null ? [] : this.brokerCompanyFrom.zhuzuoqvyv.split(',');
                    } else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },


            getGSSX(){
                var str = '';
                for (var x in this.optionsgssx) {
                    for (var y in this.brokerCompanyFrom.gongsijingyingshuxing) {
                        if (this.optionsgssx[x].label == this.brokerCompanyFrom.gongsijingyingshuxing[y]) {
                            str += this.optionsgssx[x].label + ',';
                            this.brokerCompanyFrom.gongsijingyingshuxingid += this.optionsgssx[x].value + ',';
                        }
                    }
                }
                this.brokerCompanyFrom.gongsijingyingshuxing = str;
            },
            getFWDX(){
                var str = '';
                for (var x in this.optionsfwdx) {
                    for (var y in this.brokerCompanyFrom.fuwuduixiang) {
                        if (this.optionsfwdx[x].label == this.brokerCompanyFrom.fuwuduixiang[y]) {
                            str += this.optionsfwdx[x].label + ',';
                        }
                    }
                }
                this.brokerCompanyFrom.fuwuduixiang = str;
            },
            getZZQY(){
                var str = '';
                for (var x in this.optionszzqy) {
                    for (var y in this.brokerCompanyFrom.zhuzuoqvyv) {
                        if (this.optionszzqy[x].label == this.brokerCompanyFrom.zhuzuoqvyv[y]) {
                            str += this.optionszzqy[x].label + ',';
                            this.brokerCompanyFrom.zhuzuoqvyvids += this.optionszzqy[x].value + ',';
                        }
                    }
                }
                this.brokerCompanyFrom.zhuzuoqvyv = str;
            },
            save(){
                this.$refs.brokerCompanyFrom.validate((valid) => {
                    if((this.brokerCompanyFrom.fuzeren!=''&& this.brokerCompanyFrom.fuzerenlianxifangshi!='')||(this.brokerCompanyFrom.farenlianxifangshi!=''&& this.brokerCompanyFrom.farenxingming!='')){
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.getGSSX();
                            this.getFWDX();
                            this.getZZQY();
                            let para = Object.assign({}, this.brokerCompanyFrom);
                            if (this.brokerCompanyFrom.tQdCompayId != '' && this.brokerCompanyFrom.tQdCompayId != null) {
                                editBrokerCompany(para).then((res) => {
                                    this.brokerCompanyFrom.gongsijingyingshuxing = this.brokerCompanyFrom.gongsijingyingshuxing == null ? [] : this.brokerCompanyFrom.gongsijingyingshuxing.split(',');
                                    this.brokerCompanyFrom.fuwuduixiang = this.brokerCompanyFrom.fuwuduixiang == null ? [] : this.brokerCompanyFrom.fuwuduixiang.split(',');
                                    this.brokerCompanyFrom.zhuzuoqvyv = this.brokerCompanyFrom.zhuzuoqvyv == null ? [] : this.brokerCompanyFrom.zhuzuoqvyv.split(',');
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
                            } else {
                                addBrokerCompany(para).then((res) => {
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
                                this.$router.push('/brokerCompany');
                            }
                        });
                    }
                }else{
                        alert("法人姓名法人联系方式与负责人姓名负责人联系方式必须填其中一组");
                    }
                    }
                );
            },
            savehistory(){
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            let para = Object.assign({}, this.editForm);
                            para.tQdCompayId = this.$route.query.id;
                            addBrokerCompanyHistory(para).then((res) => {

                                if(res.data.code==200){
                                    this.$message({
                                        message: '提交成功',
                                        type: 'success'
                                    });
                                    this.editForm={
                                        tQdCompayId: this.$route.query.id,
                                        shifouyouxiao: null,
                                        xinxishifouzhunque: null,
                                        shuoming: '',
                                    };
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
                this.isckdis=true;
            },
            hello(){
                this.ischanged = true;
            },
            openHistory(){
                window.open("/#/brokerCompanyHistory?id="+this.$route.query.id );
            },
        },
        mounted() {
            //根据url得到的合同ID，来获取数据
            if (this.$route.query.id != null) {
                this.iscompayname=true;
                this.getBrokerCompany(this.$route.query);
            } else {
                this.brokerCompanyFromRules.compayname.push({
                    validator: (rule, value, callback) => {
                        let para = {
                            name: value
                        };
                        if (this.brokerCompanyFrom.tQdCompayId != '' && this.brokerCompanyFrom.tQdCompayId != null) {
                            callback();
                        } else {
                            if (value != '') {
                                checkbkNameList(para).then((res) => {
                                    //alert( JSON.stringify(res));
                                    if (res.data.code != '200') {
                                        callback(new Error(res.data.msg));
                                    } else {
                                        callback();
                                    }
                                })
                            }
                        }

                    }, trigger: 'blur'
                });

            }
            //新增页面隐藏跟进记录
            if (this.$route.path == '/brokerCompany/add') {
                this.showeidt = false;
            }
            //详情页面input禁用
            if (this.$route.path == '/brokerCompany/view') {
                this.editVisible = false;
                this.disabledInput();
            }
            this.remoteMethodgssx();
            this.remoteMethodywqy();
            this.remoteMethodzzqy();
            this.remoteMethodfwdx();
            this.remoteMethodXYDJ();
            setTimeout(this.hello, 1000);
        }
    }
</script>