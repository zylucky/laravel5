<template>
    <div>
        <el-row>
            <div style="margin-bottom: 50px;"></div>
            <el-col :span="18">
                <add-property ref="property" v-show="stepNum==1"></add-property>
                <add-renter ref="renter" :addRenter="addRenter" v-show="stepNum==2"></add-renter>
                <add-date ref="date" :addDate="addDate" v-show="stepNum==3"></add-date>
                <add-tiaokuan ref="tiaokuan" v-show="stepNum==4"></add-tiaokuan>
            </el-col>
            <div style="margin-bottom:81px;"></div>
            <el-col :span="6">
                <div style="margin-left: 50%;">
                    <el-steps :space="100" direction="vertical" :active="stepNum">
                        <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
                        <a href="javascript:;" @click="stepNum=2"><el-step  title="租户信息"></el-step></a>
                        <a href="javascript:;" @click="stepNum=3"><el-step  title="租期信息"></el-step></a>
                        <a href="javascript:;" @click="stepNum=4"><el-step  title="条款信息"></el-step></a>
                    </el-steps>
                    <el-button type="primary" @click="save" style="margin-top:100px;">保存</el-button>
                    <el-button type="primary" @click="submit" >提交</el-button>
                </div>

            </el-col>
        </el-row>

    </div>
</template>
<script>
    import AddProperty from './AddProperty.vue'
    import AddRenter from './AddRenter.vue'
    import AddDate from './AddDate.vue'
    import AddTiaokuan from './AddTiaoKuan.vue'
    import {addChufangPurchaseContractInfo,getChufangPurchaseContractInfo,submitSaleContract} from '../../api/api';
    export default{
        data(){
            return {
                stepNum:1,
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


                addRenter:{
                    chengzufang:'华溯商贸',
                    jujianfang:'',
                    yezhuleixing:1,
                    //产权人
                    chanquanrenList:[
                        {
                            Faren:'李岳群',
                            Name:'北京大象群文化传媒有限公司',
                            zhengjian:'37158119900124317X',
                            Tel:'18511909124',
                            Sex:1,
                            hetongid:null,
                        },
                    ],
                    //收款人
                    shoukuanren:'彭亮',
                    zhanghao:'1234 4567 7891 0123',
                    //代理人
                    dailirenName:'李朝晖',
                    dailirenTel:'18511909125',
                    dailirenSex:1,
                    dailirenId:'37158119900124317X',
                    //签约人
                    qianyuerenName:'lizhaohui',
                    qianyuerenTel:'18511909124',
                    qianyuerenSex:1,
                    qianyuerenId:'37158119900124317X',
                },
                addDate: {
                    startdate:'',//租期开始时间
                    enddate:'',//租期结束时间
                    shoufangdate: '',//收房日期
                    qianyueDate: '',//签约日期
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
                    zongzujin:'',//总租金
                    commission:'',//佣金
                    tiqianfukuantian:'',//提前付款天数
                    yajinfukuanri:'',//押金付款日
                    shouqifukuanri:'',//首期租金付款日
                    erqifukuanri:'',//二期付款
                    sanqifukuanri:'',//三期付款
                    buchongtiaokuan:'',//补充条款
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
                    checkList: []
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
                let para = {
                    id:this.id,
                }
                submitSaleContract(para).then((res)=>{
                    if(res.data.code == 200){
                        this.$message({//这是Vue中从后台返回来的数据的格式
                            message:'提交成功',
                            type:'success'
                        });
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                })
            },
            save:function () {
                    var child_property = this.$refs.property.property;
                    var child_renter  = this.$refs.renter.addRenter;
                    var child_date = this.$refs.date.addDate;
                    var id = {
                        id: this.id
                    };

                    let para = Object.assign({}, child_property,child_renter,child_date);
                    addChufangPurchaseContractInfo(para).then((res) => {

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
            //根据url得到的合同ID，来获取数据
            getPurchaseContract(id){
                getChufangPurchaseContractInfo(id).then((res)=>{
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
                this.property.officeList = res.data.data.officeList;
                this.addRenter.chanquanrenList = res.data.data.chanquanrenList;
                this.addRenter.chengzufang = res.data.data.chengzufang;
                this.addRenter.jujianfang = res.data.data.jujianfang;
                this.addRenter.yezhuleixing = res.data.data.yezhuleixing;
                this.addRenter.shoukuanren = res.data.data.shoukuanren;
                this.addRenter.zhanghao = res.data.data.zhanghao;
                this.addRenter.dailirenTel = res.data.data.dailirenTel;
                this.addRenter.dailirenSex = res.data.data.dailirenSex;
                this.addRenter.dailirenId = res.data.data.dailirenId;
                this.addRenter.dailirenName = res.data.data.dailirenName;
                this.addRenter.qianyuerenName = res.data.data.qianyuerenName;
                this.addRenter.qianyuerenTel = res.data.data.qianyuerenTel;
                this.addRenter.qianyuerenSex = res.data.data.qianyuerenSex;
                this.addRenter.qianyuerenId = res.data.data.qianyuerenId;
                this.addDate.startdate = res.data.data.startdate;
                this.addDate.enddate = res.data.data.enddate;
                this.addDate.shoufangdate = res.data.data.shoufangdate;
                this.addDate.qianyueDate = res.data.data.qianyueDate;
                this.addDate.mianzufangshi = res.data.data.mianzufangshi;
                this.addDate.mianzuqiList = res.data.data.mianzuqiList;
                this.addDate.fukuanFangshiList = res.data.data.fukuanFangshiList;
                this.addDate.yajin = res.data.data.yajin;
                this.addDate.zongzujin = res.data.data.zongzujin;
                this.addDate.commission = res.data.data.commission;
                this.addDate.tiqianfukuantian = res.data.data.tiqianfukuantian;
                this.addDate.yajinfukuanri = res.data.data.yajinfukuanri;
                this.addDate.shouqifukuanri = res.data.data.shouqifukuanri;
                this.addDate.erqifukuanri = res.data.data.erqifukuanri;
                this.addDate.sanqifukuanri = res.data.data.sanqifukuanri;
                this.addDate.buchongtiaokuan = res.data.data.buchongtiaokuan;
                this.addDate.zujinList = res.data.data.zujinList;
                this.addDate.checkList = res.data.data.checkList;

            },
        },
        mounted() {
            //根据url得到的合同ID，来获取数据
            this.getPurchaseContract(this.$route.query);
        },

    }
</script>