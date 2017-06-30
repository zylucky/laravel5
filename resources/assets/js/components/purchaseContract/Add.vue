<template>
    <div>
        <el-row>
            <div style="margin-bottom: 50px;"></div>
            <el-col :span="18">
                <add-property ref="property" :property="property" v-show="stepNum==1"></add-property>
                <add-owner ref="owner" :owner="owner" v-show="stepNum==2"></add-owner>
                <add-date ref="date" :addDate="addDate" v-show="stepNum==3"></add-date>
                <add-tiaokuan ref="tiaokuan" v-show="stepNum==4"></add-tiaokuan>
            </el-col>
            <div style="margin-bottom:81px;"></div>
            <el-col :span="6">
                <div style="margin-left: 50%;">
                <el-steps :space="100" direction="vertical" :active="stepNum">
                    <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=2"><el-step  title="业主信息"></el-step></a>
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
    import AddOwner from './AddOwner.vue'
    import AddDate from './AddDate.vue'
    import AddTiaokuan from './AddTiaoKuan.vue'
    import {addPurchaseContractInfo,getPurchaseContractInfo,submitPurchaseContract} from '../../api/api';
    export default{
        data(){
            return {
                stepNum:2,
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
                owner:{
                    chengzufang:'华溯商贸',
                    jujianfang:'',
                    yezhuleixing:1,
                    //产权人
                    chanquanrenList:[
                        {
                            faren:'',
                            name:'',
                            zhengjian:'',
                            tel:'',
                            sex:1,
                            hetongid:null,
                        },
                    ],
                    //收款人
                    shoukuanren:'彭亮',
                    zhanghao:'1234 4567 7891 0123',
                    kaihuhang:'',
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
                    qianyuedate: '',//签约日期
                    mianzufangshi: [],//免租方式
                    mianzuqiList: [{
                        startdate:'',//免租开始
                        enddate:'',//免租结束
                        mianzufangshi:'',
                    }],
                    fukuanFangshiList:[{
                        startdate:'',//开始
                        enddate:'',//结束
                        yajinyue:'',
                        zujinyue:'',
                    }],
                    yajin:'',//押金
                    zongyingfuzujin:'',//总租金
                    yongjin:'',//佣金
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
            AddOwner,
            AddDate,
            AddTiaokuan,
        },
        methods:{
            submit(){
                let  para = {
                    id:this.id,
                }
                submitPurchaseContract(para).then((res)=>{
                    if(res.data.code == 200)　{
                        this.$message({
                            message: '提交成功',
                            type: 'success'
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
                    var child_owner  = this.$refs.owner.owner;
                    var child_date = this.$refs.date.addDate;
                    var id = {
                       id: this.id
                    };
                    let para = Object.assign({}, child_property,child_owner,child_date,id);
                    addPurchaseContractInfo(para).then((res) => {
                    if(res.data.code == 200)　{
                        //保存完以后可以得到一个返回的ID
                        //把数据分别赋值给三个组件的变量
                        this.fuzhi(res);
                        this.$message({
                            message: '保存成功',
                            type: 'success'
                        });
                    }else{
                        this.$message({
                            message:res.data.msg,
                            type:'error'
                        })
                    }
                });
            },
            //根据url得到的合同ID，来获取数据
            getPurchaseContract(id){
                getPurchaseContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
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
                if(res.data.data.chanquanrenList.length>0){
                    console.log(res.data.data.chanquanrenList)
                    this.owner.chanquanrenList = res.data.data.chanquanrenList;
                }
                this.owner.chengzufang = res.data.data.chengzufang;
                this.owner.jujianfang = res.data.data.jujianfang;
                this.owner.yezhuleixing = res.data.data.yezhuleixing;
                this.owner.shoukuanren = res.data.data.shoukuanren;
                this.owner.kaihuhang = res.data.data.kaihuhang;
                this.owner.zhanghao = res.data.data.zhanghao;
                this.owner.dailirenTel = res.data.data.dailirenTel;
                this.owner.dailirenSex = res.data.data.dailirenSex;
                this.owner.dailirenId = res.data.data.dailirenId;
                this.owner.dailirenName = res.data.data.dailirenName;
                this.owner.qianyuerenName = res.data.data.qianyuerenName;
                this.owner.qianyuerenTel = res.data.data.qianyuerenTel;
                this.owner.qianyuerenSex = res.data.data.qianyuerenSex;
                this.owner.qianyuerenId = res.data.data.qianyuerenId;
                this.addDate.startdate = res.data.data.startdate;
                this.addDate.enddate = res.data.data.enddate;
                this.addDate.shoufangdate = res.data.data.shoufangdate;
                this.addDate.qianyuedate = res.data.data.qianyuedate;
                this.addDate.mianzufangshi = res.data.data.mianzufangshi;
                this.addDate.mianzuqiList = res.data.data.mianzuqiList;
                this.addDate.fukuanFangshiList = res.data.data.fukuanFangshiList;
                this.addDate.yajin = res.data.data.yajin;
                this.addDate.zongyingfuzujin = res.data.data.zongyingfuzujin;
                this.addDate.yongjin = res.data.data.yongjin;
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
            if(this.$route.query.id!=null){
                this.getPurchaseContract(this.$route.query);
            }
        },

    }
</script>