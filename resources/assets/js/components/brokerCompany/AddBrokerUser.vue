<template>

    <el-row >
        <div style="margin-bottom: 60px;"></div>
        <el-form label-Weizhi="right" ref="brokerCompanyUserForm" :rules="brokerCompanyUserFormRules" label-width="180px"
                 :model="brokerCompanyUserForm" class="demo-dynamic">
            <el-col :span="18">

                <el-row>
                    <el-col :span="8">
                        <el-form-item  label="姓名" prop="qdPername">
                            <el-input v-model="brokerCompanyUserForm.qdPername"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="职务" prop="yjType">
                            <el-input v-model="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

                <el-form-item label="联系电话" v-for="(item, index) in brokerCompanyUserForm.lxrGroup"
                              :key="item.key">
                    <el-col :span="8">
                        <el-form-item     >
                            <el-input v-model="brokerCompanyUserForm.lxrGroup[index].lxrphone"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-button v-if="index>0"  @click.prevent="removeFreeItem(item)">删除</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button v-show="editVisible" @click="addFreeItem">新增</el-button>
                </el-form-item>

                <el-row>
                    <el-col :span="8">
                        <el-form-item required label="所在业务区域" prop="qvyvId">
                            <el-select v-model="brokerCompanyUserForm.qvyvId" placeholder="">
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
                        <el-form-item   label-width="10px" prop="dituquyu">
                            <el-select v-model="brokerCompanyUserForm.dituquyu" placeholder="地图区域">
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
                <el-row>
                    <el-col :span="8">
                        <el-form-item  label="幼狮联系人1" prop="yjType">
                            <el-input v-model.number="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="幼狮联系人2" prop="yjType">
                            <el-input v-model.number="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="幼狮联系人3" prop="yjType">
                            <el-input v-model.number="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>

                    <el-col :span="8">
                        <el-form-item label="是否添加微信好友" prop="yjType">
                            <el-radio-group v-model="brokerCompanyUserForm.yjType">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="2">否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="添加好友人数" prop="yjType">
                            <el-input v-model.number="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="是否带看幼狮" prop="yjType">
                            <el-radio-group v-model="brokerCompanyUserForm.yjType">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="2">否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="带看次数" prop="leixing">
                            <el-input v-model.number="brokerCompanyUserForm.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="带看对接人数" prop="qianyuemianji">
                            <el-input v-model.number="brokerCompanyUserForm.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="是否签约过幼狮" prop="compayname">
                            <el-radio-group v-model="brokerCompanyUserForm.dailirenSex">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="2">否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="签约次数" prop="yjType">
                            <el-input v-model.number="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item  label="签约对接人数" prop="yjType">
                            <el-input v-model.number="brokerCompanyUserForm.yjType"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="渠道等级" prop="yjType">
                    <el-select v-model="brokerCompanyUserForm.yjType" placeholder="">
                        <el-option
                                v-for="item in optionsfw"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="佣金类型" prop="yjType">
                            <el-select v-model="brokerCompanyUserForm.yjType" placeholder="请输入佣金类型">
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
                <el-form-item label="备注" prop="bz">
                    <el-input type="textarea" v-model="brokerCompanyUserForm.bz"  auto-complete="off"></el-input>
                </el-form-item>
            </el-col>
        </el-form>
        <el-col>
            <div v-show="showeidt">
                <el-button @click.native="change">跟进记录</el-button>
            </div>
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
                    <a href="/#/brokerCompanyUserHistory">查看历史记录</a>
                </el-form>
            </div>
            <el-button type="primary" v-show="editVisible" @click="save" style="margin-top:20px;">保存</el-button>
            <el-button v-show="editVisible" @click.native="editFormVisible = false">取消</el-button>
        </el-col>
    </el-row>
</template>
<script>
    import {getbkNameList, getLoudongList, getFanghaoList, getPurchaseContractInfo,
        addBrokerUser,
        editBrokerUser,
        addBrokerUserHistory,
    } from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    export default {
        components: {
            ElRow
        },
        data() {
            return {
                dialogImageUrl: '',
                dialogVisible: false,
                showed: false,
                brokerCompanyUserForm: {
                    omcId: null,
                    loupanOmcId: null,
                    loudongOmcId: null,
                    loupanName: null,
                    loudongName: null,
                    fanghao: null,
                    weizhi: null,
                    chanquanzhenghao: null,
                    jianzhumianji: null,
                    qianyuemianji: null,
                    leixing: null,
                    hetongid: null,
                    quyu: '',
                    isdiya: 0,
                    diyaren: '',
                    value1: null,
                    qvDaoCompayXinxi:[{
                        compayname:'',}
                    ],
                    lxrGroup:[
                        {
                            lxrphone:'',
                        }
                    ],
                    tQdCompayId:'',
                },
                list:[],
                purchaseContract: {
                    type: 0,
                },
                brokerCompanyUserFormRules: {

                },
                editVisible:true,
                bkNameloading: false,
                options1:[],
                //房间类型
                optionsfw:[
                    {
                        value: 0,
                        label: '请选择'
                    }, {
                        value: 1,
                        label: '粘性渠道(A)'
                    }, {
                        value: 2,
                        label: '确定渠道(B)'
                    },{
                        value: 3,
                        label: '不确定渠道(C)'
                    },{
                        value: 4,
                        label: '沉默渠道(D)'
                    },
                ],
                //房源数据初始化
                showeidt:true,

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


                },
            }
        },
        methods: {
            //增加
            addFreeItem() {
                this.brokerCompanyUserForm.lxrGroup.push({
                    lxrphone:'',
                    key: Date.now()
                });
            },
            //移除
            removeFreeItem(item) {
                var index = this.brokerCompanyUserForm.lxrGroup.indexOf(item)
                if (index !== -1) {
                    this.brokerCompanyUserForm.lxrGroup.splice(index, 1)
                }
            },
            //显示和隐藏跟进记录
            change(){
                if (this.$route.path == '/brokerUser/view') {

                }else{
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
                this.list=[];
                getbkNameList(para).then((res) => {

                    for ( let i in res.data.data ){
                        this.list.push({ value: res.data.data[i].tQdCompayId, label: res.data.data[i].compayname,lpname:res.data.data[i].compaytest });
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
            getPurchaseContract(id){
                getPurchaseContractInfo(id).then((res) => {
                    if (res.data.code == '200') {
                        //把数据分别赋值给三个组件的变量
                        this.fuzhi(res);

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
                //渠道公司
                for (var x in this.options1) {

                    if (this.options1[x].value == this.brokerCompanyUserForm.tQdCompayId) {
                        //console.log(this.options1[x].lpname);
                        this.brokerCompanyUserForm.loupanName = this.options1[x].lpname;

                    }
                }
            },

            save(){
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
                // this.getPurchaseContract(this.$route.query);
                console.log( this.$route.query.stage);
                this.brokerCompanyUserForm= Object.assign({}, this.$route.query.stage );
                //console.log( this.brokerCompanyUserForm);
                //console.log( this.brokerCompanyUserForm)
            }
            //新增页面input禁用
            if (this.$route.path == '/brokerUser/add') {
                this.showeidt = false;

            }
            //详情页面input禁用
            if (this.$route.path == '/brokerUser/view') {
                this.editVisible = false;
                this.disabledInput();
            }


        }

    }
</script>