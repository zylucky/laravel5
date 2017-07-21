<template>
    <el-row  >
            <div style="margin-bottom: 60px;"></div>
            <el-form label-Weizhi="right" ref="brokerCompanyFrom" :rules="brokerCompanyFromRules" label-width="180px"
                     :model="brokerCompanyFrom" class="demo-dynamic">
                <el-col :span="18">

                    <el-row>
                        <el-col :span="8">
                    <el-form-item required label="公司名称" prop="compayname">
                        <el-input v-model="brokerCompanyFrom.compayname" placeholder="请输入公司名称"></el-input>
                    </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="公司所在业务区域" prop="yewuquyu">
                                <el-select v-model="brokerCompanyFrom.yewuquyu" placeholder="">
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
                            <el-form-item required label-width="10px" prop="dituquyu">
                                <el-select v-model="brokerCompanyFrom.dituquyu" placeholder="地图区域">
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
                        <el-col :span="6">
                            <el-form-item required label="公司详细地址" prop="addr">
                                <el-input v-model="brokerCompanyFrom.addr"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="5">
                            <el-form-item required label-width="10px" prop="xingzhengqu">
                                <el-select v-model="brokerCompanyFrom.xingzhengqu" placeholder="行政区域">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="5">
                            <el-form-item required label-width="10px" prop="jiedao">
                                <el-select v-model="brokerCompanyFrom.jiedao" placeholder="街道">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="7">
                            <el-form-item required label-width="10px" prop="xiangxidizhi">
                                <el-input v-model="brokerCompanyFrom.xiangxidizhi" placeholder="请输入公司详细地址"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="8">
                            <el-form-item required label="公司所在楼盘" prop="loupanName">
                                <el-input v-model="brokerCompanyFrom.loupanname" placeholder="请输入公司所在楼盘"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="公司规模" prop="gongshiguimo">
                                <el-input v-model="brokerCompanyFrom.gongshiguimo" placeholder="请输入公司规模"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="公司成立时间" prop="chenglinianxian">
                                <el-date-picker type="date" placeholder="公司成立时间" v-model="brokerCompanyFrom.chenglinianxian">
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-form-item label="主做区域" prop="zhuzuoquyu">
                        <el-checkbox-group   v-model="checkedCities"  >
                            <el-checkbox v-for="city in cities" :label="city.label" :key="city.value" :value="city.value">{{city.label}}</el-checkbox>
                        </el-checkbox-group>
                    </el-form-item>
                    <el-row>
                        <el-col :span="8">
                    <el-form-item label="是否有过合作" prop="shifouyouguohezuo">
                        <el-radio-group v-model="brokerCompanyFrom.shifouyouguohezuo">
                            <el-radio :label=1>是</el-radio>
                            <el-radio :label=2>否</el-radio>
                        </el-radio-group>
                    </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="合作次数" prop="hezuocishu">
                                <el-input v-model="brokerCompanyFrom.hezuocishu"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                            <el-form-item label="是否签署合作协议" prop="shifouqianshuxieyi">
                                <el-radio-group v-model="brokerCompanyFrom.shifouqianshuxieyi">
                                    <el-radio :label=1>是</el-radio>
                                    <el-radio :label=2>否</el-radio>
                                </el-radio-group>
                            </el-form-item>
                    <el-row>
                        <el-col :span="8">
                            <el-form-item required label="签署合作协议时间" prop="qianshuriqi">
                                <el-date-picker type="date" placeholder="签署合作协议时间" v-model="brokerCompanyFrom.qianshuriqi">
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="合作协议等级" prop="xieyidengji">
                                <el-select v-model="brokerCompanyFrom.xieyidengji" placeholder="请输入合作协议等级">
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
                            <el-form-item required label="幼狮联系人1" prop="person1">
                                <el-select v-model="brokerCompanyFrom.person1" placeholder="请输入幼狮联系人">
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
                            <el-form-item required label="幼狮联系人2" prop="person2">
                                <el-select v-model="brokerCompanyFrom.person2" placeholder="请输入幼狮联系人">
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
                            <el-form-item required label="幼狮联系人3" prop="person3">
                                <el-select v-model="brokerCompanyFrom.person3" placeholder="请输入幼狮联系人">
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
                            <el-form-item required label="法人姓名" prop="farenxingming">
                                <el-input v-model="brokerCompanyFrom.farenxingming"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="法人联系方式" prop="farenphone">
                                <el-input v-model="brokerCompanyFrom.farenphone"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="8">
                            <el-form-item required label="负责人姓名" prop="fuzherenxingming">
                                <el-input v-model="brokerCompanyFrom.fuzherenxingming"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item required label="负责人联系方式" prop="fuzherenphone">
                                <el-input v-model="brokerCompanyFrom.fuzherenphone"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="8">
                            <el-form-item label="佣金类型" prop="yjType">
                                <el-select v-model="brokerCompanyFrom.yjType" placeholder="请输入佣金类型">
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
                                <el-input v-model.number="brokerCompanyFrom.yjzbSf"   auto-complete="off"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item label="出房佣金占比" prop="yjzbCf">
                                <el-input v-model.number="brokerCompanyFrom.yjzbCf" auto-complete="off"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-form-item label="公司经营属性" prop="jingyingshuxing">
                        <el-checkbox-group v-model="brokerCompanyFrom.jingyingshuxing"  >
                            <el-checkbox v-for="city in optionsgssx" :label="city.label" :key="city.value" :value="city.value">{{city.label}}</el-checkbox>
                        </el-checkbox-group>
                    </el-form-item>
                    <el-form-item label="服务对象" prop="fuwuduixiang">

                    </el-form-item>
                    <el-form-item required label="综合评价" prop="zonghepingjia">
                        <el-rate v-model="brokerCompanyFrom.zonghepingjia"></el-rate>
                    </el-form-item>
                    <el-form-item label="通讯录" prop="yjzbCf">
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
                    <el-form-item label="合作协议" prop="yjzbCf">
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
                    <el-form-item label="备注" prop="bz">
                        <el-input type="textarea" v-model="brokerCompanyFrom.bz"  auto-complete="off"></el-input>
                    </el-form-item>
                </el-col>
            </el-form>
            <el-col>
                <div v-show="showeidt">
                    <el-button @click.native="change">跟进记录</el-button>
                    <add-history v-show="showhistory"></add-history>
                    <div v-show="showed">
                        <el-form :model="editForm" label-width="180px" :rules="editFormRules" ref="editForm" label-Weizhi="right" >
                            {{brokerCompanyFrom.genjinjindo}}
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
                                    <el-input type="textarea" v-model="editForm.shuoming" auto-complete="off" style="width:1100px"></el-input>
                                </el-form-item>
                            </el-row>
                            <a href="/#/brokerCompanyHistory?id=" >查看历史记录</a>
                        </el-form>
                    </div>
                </div>
                <el-button type="primary" v-show="editVisible" @click="save" style="margin-top:100px;">保存</el-button>
                <el-button @click.native="">取消</el-button>
            </el-col>
        </el-row>
</template>

<script>
    import {getLoupanList, getLoudongList, getFanghaoList, getPurchaseContractInfo,addBrokerCompanyHistory,getGSSXDicList,getFWDXDicList} from '../../api/api';
    import ElRow from "element-ui/packages/row/src/row";
    import AddHistory from './HistoryList.vue'
    export default {
        components: {
            ElRow,
            AddHistory
        },
        data() {
            return {
                checkedCities: [ '元'],
                dialogImageUrl: '',
                dialogVisible: false,
                showed: false,
                showhistory:false,
                brokerCompanyFrom: {
                    loupanName: null,
                    compayname: null,
                    yewuquyu: [],
                    dituquyu: [],
                    gongshiguimo: '',
                    chenglinianxian: '',
                    qianshuriqi:null,
                    xieyidengji: [],
                    farenxingming: null,
                    farenphone:'',
                    fuzherenxingming:'',
                    jianzhumianji:null,
                    yjzbCf:'',
                    bz:'',
                    zonghepingjia:3,
                    fuwuduixiang:[],
                    yjzbSf:'',
                    yjType:null,
                    jingyingshuxing:[],
                    person1:'',
                    person2:'',
                    person3:'',
                    shifouqianshuxieyi:null,
                    hezuocishu:null,
                    shifouyouguohezuo:null,
                    xiangxidizhi:null,
                    jiedao:[],
                    xingzhengqu:[],
                    addr:null,
                    zhuzuoquyu:[],

                },
                purchaseContract: {
                    type: 0,
                },
                brokerCompanyFromRules: {

                },
                cities:[{
                    value: 1,
                    label: '%'
                }, {
                    value: 2,
                    label: '元'
                }],
                optionszzqy: [ {
                    value: 1,
                    label: '%'
                }, {
                    value: 2,
                    label: '元'
                },],
                showeidt:true,
                editVisible: true,
                optionsgssx: [  {
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
                }],
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
                ],

                //编辑界面数据
                editLoading: false,
                editForm: {
                    tQdCompayId: 0,
                    shifouyouxiao: null,
                    xinxishifouzhunque: null,
                    shuoming: '',
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
                if (this.$route.path == '/brokerCompany/view') {
                    if (this.showhistory == false) {
                        this.showhistory = true;
                    } else {
                        this.showhistory = false;
                    }
                }else{
                    if (this.showed == false) {
                        this.showed = true;
                    } else {
                        this.showed = false;
                    }
                }
            },
            //获取公司属性
            remoteMethodgssx() {
                let para = {
                    str: '华贸'
                };



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
                    loupanOmcId: this.brokerCompanyFrom.loupanOmcId,
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
                    lpid: this.brokerCompanyFrom.loupanOmcId,
                    zdid: this.brokerCompanyFrom.loudongOmcId,
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
                    if (this.options1[x].label == this.brokerCompanyFrom.loupanName) {
                        this.brokerCompanyFrom.loupanOmcId = this.options1[x].value;
                        this.brokerCompanyFrom.loudongName = null;//清除楼栋和房号的缓存
                        this.brokerCompanyFrom.loudongOmcId = null;//清除楼栋和房号的缓存
                        this.brokerCompanyFrom.fanghao = null;//清除楼栋和房号的缓存
                        this.brokerCompanyFrom.omcId = null;//清除楼栋和房号的缓存
                    }
                }
            },
            change2(){
                //楼栋
                for (var x in this.options2) {
                    if (this.options2[x].label == this.brokerCompanyFrom.loudongName) {
                        this.brokerCompanyFrom.loudongOmcId = this.options2[x].value;
                        this.brokerCompanyFrom.fanghao = null;//清除楼栋和房号的缓存
                        this.brokerCompanyFrom.omcId = null;//清除楼栋和房号的缓存
                    }
                }
            },
            change3(){
                //房号
                for (var x in this.options3) {
                    if (this.options3[x].label == this.brokerCompanyFrom.fanghao) {
                        this.brokerCompanyFrom.omcId = this.options3[x].value;
                    }
                }

            },
            save(){
                this.$refs.editForm.validate((valid) => {
                    //  alert(this.addForm.tQdCompayId);

                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {

                            //NProgress.start();
                            let para = Object.assign({}, this.editForm,this.brokerCompanyFrom);
console.log(para);
                            //para.yjType= this.addForm.yjType == '按月租金' ? 1 : 2;
                            //para.birth = (!para.birth || para.birth == '') ? '' : util.formatDate.format(new Date(para.birth), 'yyyy-MM-dd');
                            addBrokerCompanyHistory(para).then((res) => {

                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                /////this.$refs['addForm'].resetFields();
                               // this.getBrokerCompanyUser();
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
                for (let i = 0; i < allInputs.length; i++) {
                    allInputs[i].disabled = "true";
                    allInputs[i].parentNode.className += " is-disabled";
                }
            },
        },
        mounted() {
            //根据url得到的合同ID，来获取数据
            if (this.$route.query.id != null) {
                // this.getPurchaseContract(this.$route.query);
            }
            //详情页面input禁用
            if (this.$route.path == '/brokerCompany/add') {
                this.showeidt = false;

            }
            //详情页面input禁用
            if (this.$route.path == '/brokerCompany/view') {
                this.editVisible = false;
                this.disabledInput();
            }
           this.remoteMethodgssx();
        }

    }
</script>