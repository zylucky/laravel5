<template>

    <el-row class="container">
        <div style="margin-bottom: 60px;"></div>
        <el-form label-Weizhi="right" ref="propertyForm" :rules="editPropertyRules" label-width="180px"
                 :model="officeList" class="demo-dynamic">
            <el-col :span="18">

                <el-row>
                    <el-col :span="8">
                        <el-form-item required label="姓名" prop="quyu">
                            <el-input v-model="officeList.quyu"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="职务" prop="quyu">
                            <el-input v-model="officeList.quyu"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="联系电话" prop="quyu">
                            <el-input v-model="officeList.quyu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item required label="渠道公司" prop="quyu">
                            <el-input v-model="officeList.quyu"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="公司所在楼盘" prop="quyu">
                            <el-input v-model="officeList.quyu"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="业务区域" prop="quyu">
                            <el-input v-model="officeList.quyu"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item required label="幼狮联系人1" prop="qianyuemianji">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="幼狮联系人2" prop="qianyuemianji">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="幼狮联系人3" prop="qianyuemianji">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>

                    <el-col :span="8">
                        <el-form-item label="是否添加微信好友" prop="compayname">
                            <el-radio-group v-model="editForm.dailirenSex">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="2">否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="添加好友人数" prop="leixing">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="是否带看幼狮" prop="compayname">
                            <el-radio-group v-model="editForm.dailirenSex">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="2">否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="带看次数" prop="leixing">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="带看对接人数" prop="qianyuemianji">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="是否签约过幼狮" prop="compayname">
                            <el-radio-group v-model="editForm.dailirenSex">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="2">否</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="签约次数" prop="leixing">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item required label="签约对接人数" prop="qianyuemianji">
                            <el-input v-model.number="officeList.qianyuemianji"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item label="渠道等级" prop="yjType">
                    <el-select v-model="officeList.yjType" placeholder="">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="佣金类型" prop="yjType">
                            <el-select v-model="officeList.yjType" placeholder="">
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
                            <el-input v-model.number="officeList.yjzbSf" value="" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="出房佣金占比" prop="yjzbCf">
                            <el-input v-model.number="officeList.yjzbCf" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>

            </el-col>
        </el-form>
        <el-col>
            <div v-show="showeidt">
                <el-button @click.native="change">跟进记录</el-button>
            </div>
            <div v-show="showed">
                <el-form :model="editForm" label-width="180px" :rules="editFormRules" ref="editForm" label-Weizhi="right" >
                    {{officeList.genjinjindo}}
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
            <el-button @click.native="editFormVisible = false">取消</el-button>
        </el-col>
    </el-row>
</template>
<script>
    import {getLoupanList, getLoudongList, getFanghaoList, getPurchaseContractInfo} from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    export default {
        components: {
            ElRow
        },
        props: ['property'],
        data() {
            return {
                dialogImageUrl: '',
                dialogVisible: false,
                showed: false,
                officeList: {
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
                },
                purchaseContract: {
                    type: 0,
                },
                editPropertyRules: {
                    loupanName: [
                        {required: true, message: '不能为空'}
                    ],
                    loudongName: [
                        {required: true, message: '不能为空'}
                    ],
                    fanghao: [
                        {required: true, message: '不能为空'}
                    ],
                    quyu: [
                        {required: true, message: '不能为空'}
                    ],
                    weizhi: [
                        {required: true, message: '不能为空'}
                    ],
                    chanquanzhenghao: [
                        {required: true, message: '不能为空'}
                    ],
                    jianzhumianji: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ],
                    leixing: [
                        {required: true, message: '不能为空'}
                    ],
                    qianyuemianji: [
                        {required: true, message: '不能为空'},
                        {type: 'number', message: '必须为数字'},
                    ]
                },
                editVisible: true,
                //楼盘数据
                options1: [],
                list1: [],
                loupanloading: false,
                estate: [],//服务器搜索的楼盘数据放入这个数组中
                // 楼栋数据
                options2: [],
                list2: [],
                loudongloading: false,
                building: [],//服务器搜索的楼盘数据放入这个数组中
                // 房间数据
                options3: [],
                list3: [],
                fanghaoloading: false,
                house: [],//服务器搜索的楼盘数据放入这个数组中
                houseData: [],
                //房间类型
                options: [
                    {
                        value: 0,
                        label: '请选择'
                    }, {
                        value: 1,
                        label: '公寓'
                    }, {
                        value: 2,
                        label: '写字楼'
                    }, {
                        value: 3,
                        label: '商铺'
                    }, {
                        value: 4,
                        label: '住宅'
                    }
                ],
                //房源数据初始化
                showeidt:true,

                //编辑界面数据
                editLoading: false,
                editForm: {
                    tQdCompayId: 0,
                    compayname: '',
                    yjzbSf: '',
                    yjzbCf: '',
                    compaytest: '',
                    yjType: 1,
                },
                editFormRules: {
                    compayname: [
                        {required: true, message: '请输入渠道公司名称', trigger: 'blur'},
                    ],

                },
            }
        },
        methods: {

            //显示和隐藏跟进记录
            change(){
                if (this.$route.path == '/brokerCompanyUserList/view') {

                }else{
                if (this.showed == false) {
                    this.showed = true;
                } else {
                    this.showed = false;
                }
                }
            },
            //获取楼盘
            remoteMethod1(query) {
                let para = {
                    str: query
                };
                this.loupanloading = true;
                getLoupanList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[i] = res.data [i];
                    }
                    this.estate = arr;
                    this.loupanloading = false;
                    this.list = this.estate.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.loupanloading = true;
                        setTimeout(() => {
                            this.loupanloading = false;
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
            //获取楼栋
            remoteMethod2(query) {
                let para = {
                    loupanOmcId: this.officeList[this.tabIndex - 1].loupanOmcId,
                };
                this.loupanloading = true;
                getLoudongList(para).then((res) => {
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[i] = res.data [i];
                    }
                    this.building = arr;
                    this.loupanloading = false;
                    this.list2 = this.building.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.loupanloading = true;
                        setTimeout(() => {
                            this.loupanloading = false;
                            this.options2 = this.list2.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options2 = [];
                    }
                });

            },
            //获取房号
            remoteMethod3(query) {
                let para = {
                    lpid: this.officeList[this.tabIndex - 1].loupanOmcId,
                    zdid: this.officeList[this.tabIndex - 1].loudongOmcId,
                };
                this.fanghaoloading = true;
                getFanghaoList(para).then((res) => {
                    this.houseData = res.data;
                    let arr = [];
                    arr[0] = '';
                    for (var i in res.data) {
                        arr[res.data[i].id] = res.data[i].fybh;
                    }
                    this.house = arr;
                    this.fanghaoloading = false;
                    this.list3 = this.house.map((item, index) => {
                        return {value: index, label: item};
                    });
                    if (query !== '') {
                        this.fanghaoloading = true;
                        setTimeout(() => {
                            this.fanghaoloading = false;
                            this.options3 = this.list3.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options3 = [];
                    }
                });

            },
            //得到房间号以后，提取OMC的对应信息
            change1(){
                //楼盘
                for (var x in this.options1) {
                    if (this.options1[x].label == this.officeList[this.tabIndex - 1].loupanName) {
                        this.officeList[this.tabIndex - 1].loupanOmcId = this.options1[x].value;
                        this.officeList[this.tabIndex - 1].loudongName = null;//清除楼栋和房号的缓存
                        this.officeList[this.tabIndex - 1].loudongOmcId = null;//清除楼栋和房号的缓存
                        this.officeList[this.tabIndex - 1].fanghao = null;//清除楼栋和房号的缓存
                        this.officeList[this.tabIndex - 1].omcId = null;//清除楼栋和房号的缓存
                    }
                }
            },
            change2(){
                //楼栋
                for (var x in this.options2) {
                    if (this.options2[x].label == this.officeList[this.tabIndex - 1].loudongName) {
                        this.officeList[this.tabIndex - 1].loudongOmcId = this.options2[x].value;
                        this.officeList[this.tabIndex - 1].fanghao = null;//清除楼栋和房号的缓存
                        this.officeList[this.tabIndex - 1].omcId = null;//清除楼栋和房号的缓存
                    }
                }
            },
            change3(){
                //房号
                for (var x in this.options3) {
                    if (this.options3[x].label == this.officeList[this.tabIndex - 1].fanghao) {
                        this.property.officeList[this.tabIndex - 1].omcId = this.options3[x].value;
                    }
                }
                for (var x in this.houseData) {
                    if (this.houseData[x].id == this.officeList[this.tabIndex - 1].omcId) {
                        this.officeList[this.tabIndex - 1].Jianzhumianji = this.houseData[x].fjmj;
                        this.officeList[this.tabIndex - 1].Qianyuemianji = this.houseData[x].fjmj;
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
                for (let i = 0; i < allInputs.length; i++) {
                    allInputs[i].disabled = "true";
                    allInputs[i].parentNode.className += " is-disabled";
                }
            },
        },
        mounted() {
            //根据url得到的渠道ID，来获取数据
            if (this.$route.query.id != null) {
                // this.getPurchaseContract(this.$route.query);
            }
            //新增页面input禁用
            if (this.$route.path == '/brokerCompanyUserList/add') {
                this.showeidt = false;

            }
            //详情页面input禁用
            if (this.$route.path == '/brokerCompanyUserList/view') {
                this.editVisible = false;
                this.disabledInput();
            }


        }

    }
</script>