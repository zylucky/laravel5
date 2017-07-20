<template>
    <div>
        <el-row>
            <div style="margin-bottom: 50px;"></div>
            <el-col :span="18">
                <add-property ref="property" :property="property" v-show="stepNum==1"></add-property>
                <add-renter ref="renter" :renter="renter" v-show="stepNum==2"></add-renter>
                <add-date ref="date" :addDate="addDate" v-show="stepNum==3"></add-date>
                <!--<add-tiaokuan ref="tiaokuan" v-show="stepNum==4"></add-tiaokuan>-->
            </el-col>
            <div style="margin-bottom:81px;"></div>
            <el-col :span="6">
                <div style="margin-left: 50%;">
                    <el-steps :space="100" direction="vertical" :active="stepNum">
                        <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
                        <a href="javascript:;" @click="stepNum=2"><el-step  title="租户信息"></el-step></a>
                        <a href="javascript:;" @click="stepNum=3"><el-step  title="租期信息"></el-step></a>
                        <!--<a href="javascript:;" @click="stepNum=4"><el-step  title="条款信息"></el-step></a>-->
                    </el-steps>
                    <el-input type="hidden" prop="id"  auto-complete="off"></el-input>
                    <el-button type="primary" v-show="!reviewVisible" @click="save" style="margin-top:100px;">保存</el-button>
                    <el-button type="primary" v-show="!reviewVisible" :disabled="btnType" @click="submit" >{{submsg}}</el-button>
                    <el-button type="primary" v-show="tonguo" @click="review(1)" style="margin-top:100px;">通&nbsp;&nbsp;&nbsp;过</el-button>
                    <el-button type="warning" v-show="tonguo" @click="review(0)" style="margin-top:100px;">不通过</el-button>

                </div>

            </el-col>
        </el-row>
        <el-dialog title="审核批注" :visible.sync="dialogFormVisible">
            <el-form>
                <el-form-item label="批注" label-width="50px">
                    <el-input type="textarea" v-model="content" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="review2">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
    import AddProperty from './AddProperty.vue'
    import AddRenter from './AddRenter.vue'
    import AddDate from './AddDate.vue'
    import AddTiaokuan from './AddTiaoKuan.vue'
    import {addSaleContractInfo,getSaleContractInfo,submitSaleContract,reviewSaleContract} from '../../api/api';
    export default{
        data(){
            return {
                btnType:true,
                submsg:'提交',
                shenhe:null,//审核数据
                reviewVisible:false,//审核显示
                tonguo:false,
                content:'',//审核批注
                dialogFormVisible:false,
                stepNum:1,
                id:'',
                bianhao:'',
                zhuangtai:'',
                property:{
                    flag:null,
                    xsOffice: [{
                        omcId:null,
                        loupanOmcId:null,
                        loudongOmcId:null,
                        loupanName:null,
                        loudongName:null,
                        fanghao:null,
                        weizhi: null,
                        chanquanzhenghao: null,
                        jianzhumianji: null,
                        qianyuemianji: null,
                        leixing: null,
                        hetongid:null,
                    }],
                },

                /* stepNum:1,
                 id:'',
                 property:{
                 officeList: [{
                 omcId:null,
                 loupanOmcId:null,
                 loudongOmcId:null,
                 loupanName:null,
                 loudongName:null,
                 fanghao:null,
                 weizhi: null,
                 chanquanzhenghao: null,
                 jianzhumianji: null,
                 qianyuemianji: null,
                 leixing: null,
                 hetongid:null,
                 }],
                 },*/


                renter:{
                    flag:null,
                    options1:[
                        {
                            value:null,
                            label:null,
                        }
                    ],
                    chengzufang:'华溯商贸',
                    jujianfangtype:1,
                    jujianfang:'',
                    jujianfangid:null,
                    zuhuleixing:1,
                    //产权人
                    chengzuren:[
                        {
                            faren:'',
                            name:'',
                            idNo:'',
                            tel:'',
                            sex:1,
                            hetongid:null,
                        },
                    ],
                    //收款人
                    shoukuanren:'',
                    zhanghao:'',
                    kaihuhang:'',
                    //代理人
                    dailirenName:'',
                    dailirenTel:'',
                    dailirenSex:1,
                    dailirenId:'',
                    //签约人
                    qianyuerenName:'',
                    qianyuerenTel:'',
                    qianyuerenSex:1,
                    qianyuerenId:'',
                },
                addDate: {
                    hetongtype:1,//合同类型
                    dikoujine:'',//合同金额
                    startdate:'',//租期开始时间
                    enddate:'',//租期结束时间
                    //xinjianshoufangdate: '',//收房日期
                    //xinjianqianyuedate: '',//签约日期
                    shoufangdate: '',//收房日期
                    qianyuedate: '',//签约日期
                    mianzufangshi: [],//免租方式
                    mianzuqiList: [{
                        startdate:'',//免租开始
                        enddate:'',//免租结束
                    }],
                    fukuanFangshiList:[{
                        startdate:'',//开始
                        enddate:'',//结束
                        yajinyue:'',
                        zujinyue:'',
                    }],
                    yajin:'',//押金
                    yingfuzongzujin:'',//总租金
                    hetongyongjin:'',//佣金
                    tiqianfukuantian:'',//提前付款天数
                    yajinfukuanriqi:'',//押金付款日
                    shouqifukuanri:'',//首期租金付款日
                    erqifukuanri:'',//二期付款
                    sanqifukuanri:'',//三期付款
                    buchongTiaokuanList:'',//补充条款
                    zujinList:[
                        {
                            startdate:'',
                            enddate:'',
                            yuezujin:'',
                            price:'',
                            dizengfangshi:'',
                            dizengliang:'',
                        },
                    ],
                    checkList: [],
                    jiafangfeiyong:[],
                },
            }
        },
        components:{
            AddProperty,
            AddRenter,
            AddDate,
            AddTiaokuan,
        },
        methods:{
            submit(){
                this.$refs.renter.valid();
                this.$refs.property.valid();
                this.$refs.date.valid();
                if(this.property.flag && this.renter.flag && this.addDate.flag) {
                    let  para = {
                        id: this.id,
                    }
                submitSaleContract(para).then((res)=>{
                    if(res.data.code == 200){
                        history.go(-1);
                        /*this.$message({//这是Vue中从后台返回来的数据的格式
                            message:'提交成功',
                            type:'success'
                        });*/
                        this.btnType = true;
                        this.submsg  = '已提交';
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                })
                }else{
                    console.log(this.property.flag);
                    console.log(this.renter.flag);
                    console.log(this.addDate.flag);
                    if(this.property.flag==false){this.stepNum = 3;}
                    if(this.renter.flag==false){this.stepNum = 2;}
                    if(this.addDate.flag==false){this.stepNum = 1;}
                    this.btnType = true;
                    this.$message({
                        message: '数据格式有问题，请检查',
                        type:'error'
                    })
                }
            },
            save:function () {
                this.btnType = false;
                this.submsg  = '提交';
                    var child_property = this.$refs.property.property;
                    var child_renter  = this.$refs.renter.renter;
                    var child_date = this.$refs.date.addDate;
                    var id = {
                        id: this.id
                    };
                    var bianhao = {
                        bianhao: this.bianhao,
                    };
                    let para = Object.assign({}, child_property,child_renter,child_date,id,bianhao);
                    //alert(para);
                    console.log(para);
                    addSaleContractInfo(para).then((res) => {
                        if(res.data.code == 200)　{
                            this.fuzhi(res);
                            this.$message({
                                message: '保存成功',
                                type: 'success'
                            });
                        } else {
                            this.$message({
                                message: res.data.msg,
                                type: 'error'
                            })
                        }

                    });
            },
            review(result){
                this.dialogFormVisible = true;
                //审核
                this.shenhe = {
                    hetongid:this.id,
                    content:this.content,
                    result:result,
                };
            },
            review2(){
                    reviewSaleContract(this.shenhe).then((res) => {
                    if(res.data.code == 200)　{
                        /*this.$message({
                            message: '保存成功',
                            type: 'success'
                        });*/
                        history.go(-1);
                        this.dialogFormVisible = false;
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                });
            },
            //根据url得到的合同ID，来获取数据
            getSaleContract(id){
                getSaleContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //console.log(res.data.data)
                        //把数据分别赋值给三个组件的变量
                        this.fuzhi(res);
                    }else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },
            fuzhi(res){
                this.id = res.data.data.id;
                this.property.xsOffice = res.data.data.xsOffice;
                if(res.data.data.chengzuren.length>0){
                    this.renter.chengzuren = res.data.data.chengzuren;
                }
                //this.renter.chengzuren = res.data.data.chengzuren;
                this.renter.chengzufang = res.data.data.chengzufang;
                /*this.renter.jujianfangtype = res.data.data.jujianfangtype;
                this.renter.jujianfang = res.data.data.jujianfang;*/
                this.renter.shoukuanren = res.data.data.shoukuanren;
                this.renter.kaihuhang = res.data.data.kaihuhang;
                this.renter.zhanghao = res.data.data.zhanghao;
                this.renter.jujianfangtype = res.data.data.jujianfangtype;
                this.renter.jujianfang = res.data.data.jujianfang;//
                this.renter.jujianfangid = res.data.data.jujianfangid;
                this.renter.options1[0].value = res.data.data.jujianfangid;
                this.renter.options1[0].label = res.data.data.jujianfang;
                /*this.renter.jujianfang = res.data.data.jujianfang;
                this.renter.jujianfang = res.data.data.jujianfang;
                this.renter.jujianfang = res.data.data.jujianfang;
                this.renter.jujianfang = res.data.data.jujianfang;
                this.renter.jujianfang = res.data.data.jujianfang;*/

                this.renter.zuhuleixing = res.data.data.zuhuleixing;
                this.renter.shoukuanren = res.data.data.shoukuanren;
                this.renter.zhanghao = res.data.data.zhanghao;
                /*this.renter.dailirenTel = res.data.data.dailirenTel;
                this.renter.dailirenSex = res.data.data.dailirenSex;
                this.renter.dailirenId = res.data.data.dailirenId;
                this.renter.dailirenName = res.data.data.dailirenName;*/
                this.renter.qianyuerenName = res.data.data.qianyuerenName;
                this.renter.qianyuerenTel = res.data.data.qianyuerenTel;
                this.renter.qianyuerenSex = res.data.data.qianyuerenSex;
                this.renter.qianyuerenId = res.data.data.qianyuerenId;
                this.addDate.hetongtype = res.data.data.hetongtype;
                this.addDate.startdate = res.data.data.startdate;
                this.addDate.enddate = res.data.data.enddate;
                this.addDate.shoufangdate = res.data.data.shoufangdate;
                this.addDate.qianyuedate = res.data.data.qianyuedate;
                this.addDate.mianzufangshi = res.data.data.mianzufangshi;
                this.addDate.mianzuqiList = res.data.data.mianzuqiList;
                this.addDate.fukuanFangshiList = res.data.data.fukuanFangshiList;
                this.addDate.yajin = res.data.data.yajin;
                this.addDate.yingfuzongzujin = res.data.data.yingfuzongzujin;
                this.addDate.hetongyongjin = res.data.data.hetongyongjin;
                this.addDate.tiqianfukuantian = res.data.data.tiqianfukuantian;
                this.addDate.yajinfukuanriqi = res.data.data.yajinfukuanriqi;
                this.addDate.shouqifukuanri = res.data.data.shouqifukuanri;
                this.addDate.erqifukuanri = res.data.data.erqifukuanri;
                this.addDate.sanqifukuanri = res.data.data.sanqifukuanri;
                this.addDate.buchongTiaokuanList = res.data.data.buchongTiaokuanList;
                this.addDate.zujinList = res.data.data.zujinList;
                this.addDate.checkList = res.data.data.checkList;
                this.addDate.jiafangfeiyong = res.data.data.jiafangfeiyong;
            },
            disabledInput(){
                this.reviewVisible = true;
                this.tonguo = true;
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
            seeDisabledInput(){
                this.reviewVisible = true;
                this.tonguo = false;
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
            //根据url得到的合同ID，来获取数据
            if(this.$route.query.id!=null){
                this.getSaleContract(this.$route.query);
            }
            //审核页面input禁用
            if(this.$route.path=='/saleContract/review'){
                this.disabledInput();
            }
            //查看页面input禁用
            if(this.$route.path=='/saleContract/see'){
                this.seeDisabledInput();
            }
        },

    }
</script>