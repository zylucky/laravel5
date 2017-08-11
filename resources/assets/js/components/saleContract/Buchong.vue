<template>
    <el-row class="">
        <div style="margin-bottom: 50px;"></div>
        <h3>编号：{{bianhao}}</h3>
        <div style="margin-bottom: 50px;"></div>
        <el-form :model="addDate" ref="editForm" :rules="editFormRules" label-width="80px" class="demo-dynamic">
            <!--免租期-->
            <el-form-item label="免租期" v-for="(item, index) in addDate.mianzuqiList"
                          :key="item.key"
            >
                <el-col  style="width:410px;">
                    <el-col :span="12">
                        <el-form-item >
                            <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item
                                :prop="'mianzuqiList.' + index + '.enddate'"
                                :rules="[
                                {  required:false,validator:
                                (rule,value,callback)=>{
                                    var d1= new Date( addDate.mianzuqiList[index].startdate);
                                    var d2= new Date(value);
                                    if(d2<d1){
                                        callback('结束日期不能小于开始日期');
                                    }else{
                                    callback();
                                    };
                                        }, trigger:'blur'}
                                ]">
                            <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate" >
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                </el-col>
                <!--免租期方式ddd-->
                <el-radio-group v-model="item.mianzufangshi">
                    <el-radio :label="1">期内免租</el-radio>
                    <el-radio :label="2">期外免租</el-radio>
                </el-radio-group>
                <el-button v-if="btnShow" v-show="index>0" @click.prevent="removeFreeItem(item)">删除</el-button>

            </el-form-item>
            <el-form-item>
                <el-button v-if="btnShow" @click="addFreeItem">新增免租期</el-button>
            </el-form-item>
            <!--租期-->
            <el-row>
                <el-col :span="9" style="width:510px;">
                    <el-form-item label="总租期">
                        <el-col :span="11">
                            <el-form-item prop="zuqistartdate">
                                <el-date-picker
                                        v-model="addDate.zuqistartdate"
                                        type="date"
                                        placeholder="开始时间"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="11">
                            <el-form-item prop="zuqienddate">
                                <el-date-picker
                                        v-model="addDate.zuqienddate"
                                        type="date"
                                        placeholder="结束时间"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--租期-->
            <el-row>
                <el-col :span="9" style="width:510px;">
                    <el-form-item label="生效时间" required="">
                        <el-col :span="11">
                            <el-form-item prop="xieyistartdate">
                                <el-date-picker
                                        v-model="addDate.xieyistartdate"
                                        type="date"
                                        placeholder="开始时间"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="11">
                            <el-form-item prop="xieyienddate">
                                <el-date-picker
                                        v-model="addDate.xieyienddate"
                                        type="date"
                                        placeholder="结束时间"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--付款方式-->
            <div  v-for="(item, index) in addDate.fukuanFangshiList">
                <el-row :gutter="5">
                    <el-col :span="12" style="width:560px;">
                        <el-form-item label="付款方式"
                                      :key="item.key"
                        >
                            <el-col :span="10">
                                <el-form-item  :prop="'fukuanFangshiList.' + index + '.startdate'">
                                    <el-date-picker type = "date"  placeholder="开始时间" v-model="item.startdate">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                            <el-col :span="10">
                                <el-form-item :prop="'fukuanFangshiList.' + index + '.enddate'" :rules="[
                                {  required: false,validator:
                                (rule,value,callback)=>{
                                    var d1= new Date( addDate.fukuanFangshiList[index].startdate);
                                    var d2= new Date(value);
                                    if(d2<d1){
                                        callback('结束日期不能小于开始日期');
                                    }else{
                                    callback();
                                    };
                                        }, trigger:'blur'}
                                ]">
                                    <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-form-item>
                    </el-col>
                    <el-col :span="1" :pull="1" style="width: 90px;margin-left:30px;">
                        <el-form-item label="押" label-width="20px">
                            <el-input v-model="item.yajinyue" placeholder="押几"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="1" :pull="1" style="margin-left: 0px;width: 90px;">
                        <el-form-item label="付" label-width="20px">
                            <el-input v-model="item.zujinyue" placeholder="付几"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1">
                        <el-button v-if="btnShow" v-show="index>0"  @click.prevent="removePayItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button v-if="btnShow" @click="addPayItem">新增付款方式</el-button>
            </el-form-item>
            <!--租金详细-->
            <div v-for="(item, index) in addDate.zujinList">
                <el-row :gutter="5">
                    <el-col :span="12" style="width:560px;">
                        <el-form-item :label="'租期' + index"
                                      :key="item.key"
                        >
                            <el-col :span="10">
                                <el-form-item  :prop="'zujinList.' + index + '.startdate' "
                                >
                                    <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                            <el-col :span="10">
                                <el-form-item :prop="'zujinList.' + index + '.enddate' " :rules="[
                                {  required: false,validator:
                                (rule,value,callback)=>{
                                    var d1= new Date( addDate.zujinList[index].startdate);
                                    var d2= new Date(value);
                                    if(d2<d1){
                                        callback('结束日期不能小于开始日期');
                                    }else{
                                    callback();
                                    };
                                        }, trigger:'blur'}
                                ]"
                                >
                                    <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 160px;margin-left:30px;">
                        <el-form-item label="月租金" label-width="55px">
                            <el-input v-model="item.yuezujin" placeholder="租金"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 120px;margin-left:10px;">
                        <el-form-item label="单价" label-width="40px">
                            <el-input v-model="item.price" placeholder="单价"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width:140px;">
                        <el-form-item label="递增方式" label-width="70px">
                            <el-input v-model="item.dizengliang" placeholder=""></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 70px;">
                        <el-select v-model="addDate.zujinList[index].dizengfangshi" placeholder="">
                            <el-option
                                    v-for="item in options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :span="2" :pull="1">
                        <el-button v-if="btnShow" v-show="index>0" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button v-if="btnShow"  @click="addRentItem">新增租期</el-button>
            </el-form-item>

        </el-form>
        <el-button v-if="btnShow"  @click="cancel" style="margin-top:80px;margin-left: 40%;">取消</el-button>
        <el-button v-if="btnShow" type="primary"  @click="save" style="margin-top:100px;">保存</el-button>
        <el-button v-if="btnShow" type="primary" :disabled="btnType"  @click="submit" style="margin-top:100px;">{{submsg}}</el-button>
    </el-row>
</template>
<script>
    import {optimizePurchaseContract,getOptimizePurchaseContract,buchongsbSaleContract} from  '../../api/api';
    export default{
        data(){
            return{
                editFormRules:{
                    xieyistartdate:[
                        { required: true, message:'不能为空'},
                    ],
                    xieyienddate:[
                        {  required: true,validator:
                            (rule,value,callback)=>{
                                var d1= new Date( this.addDate.xieyistartdate);
                                var d2= new Date(value);
                                if(value==null){
                                    callback('不能为空');
                                }
                                if(d2<d1){
                                    callback('结束日期不能小于开始日期');
                                }else{
                                    callback();
                                };
                            }, trigger:'blur'}
                    ],
                    zuqienddate:[
                        {  required: true,validator:
                            (rule,value,callback)=>{
                                var d1= new Date( this.addDate.zuqistartdate);
                                var d2= new Date(value);
                                if(d2<d1){
                                    callback('结束日期不能小于开始日期');
                                }else{
                                    callback();
                                };
                            }, trigger:'blur'}
                    ],
                },
                btnShow:true,
                btnType:true,
                submsg:'提交',
                options:[
                    {
                        value: 1,
                        label: '%'
                    }, {
                        value: 2,
                        label: '元'
                    },
                ],
                id:null,
                bianhao:null,
                /*owner:{
                    yezhuleixing:1,
                    //产权人
                    chanquanrenList:[
                        {
                            faren:'',
                            name:'',
                            zhengjian:'',
                            tel:'',
                            sex:0,
                            hetongid:null,
                        },
                    ],
                    //代理人
                    dailirenName:'',
                    dailirenTel:'',
                    dailirenSex:0,
                    dailirenId:'',
                    //签约人
                    qianyuerenName:'',
                    qianyuerenTel:'',
                    qianyuerenSex:0,
                    qianyuerenId:'',
                },*/
                addDate: {
                    zuqistartdate:'',//租期开始时间
                    zuqienddate:'',//租期结束时间
                    xieyistartdate:'',//协议开始时间
                    xieyienddate:'',//协议结束时间
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
                },
            }
        },
        methods:{
            //根据合同ID来查询协议
            getOptimize(){
                getOptimizePurchaseContract(this.$route.query).then((res)=>{
                    this.fuzhi(res);
                });
            },
            fuzhi(res){
                /*if(res.data.data.chanquanrenList.length>0){
                    this.owner.chanquanrenList = res.data.data.chanquanrenList;
                }*/
                this.id = res.data.data.id;
                //this.owner.yezhuleixing = res.data.data.yezhuleixing;
               /* this.owner.dailirenTel = res.data.data.dailirenTel;
                this.owner.dailirenSex = res.data.data.dailirenSex;
                this.owner.dailirenId = res.data.data.dailirenId;
                this.owner.dailirenName = res.data.data.dailirenName;
                this.owner.qianyuerenName = res.data.data.qianyuerenName;
                this.owner.qianyuerenTel = res.data.data.qianyuerenTel;
                this.owner.qianyuerenSex = res.data.data.qianyuerenSex;
                this.owner.qianyuerenId = res.data.data.qianyuerenId;*/
                this.addDate.zuqistartdate = res.data.data.zuqistartdate;
                this.addDate.zuqienddate = res.data.data.zuqienddate;
                this.addDate.shoufangdate = res.data.data.shoufangdate;
                this.addDate.qianyuedate = res.data.data.qianyuedate;
                this.addDate.mianzufangshi = res.data.data.mianzufangshi;
                this.addDate.mianzuqiList = res.data.data.mianzuqiList;
                this.addDate.fukuanFangshiList = res.data.data.fukuanFangshiList;
                this.addDate.zujinList = res.data.data.zujinList;
                this.addDate.xieyistartdate=res.data.data.xieyistartdate,
                    this.addDate.xieyienddate = res.data.data.xieyienddate
                console.log(res.data.data);
            },
            save(){
                if(this.$route.query.type!=1){
                    this.id = null;
                }
                let para = {
                    id:this.id,
                    hetongid:this.$route.query.hetongid,
                    zujinList:this.addDate.zujinList,
                    mianzuqiList:this.addDate.mianzuqiList,
                    fukuanFangshiList:this.addDate.fukuanFangshiList,
                    /*chanquanrenList:this.owner.chanquanrenList,
                    yezhuleixing :this.owner.yezhuleixing ,
                    dailirenTel : this.owner.dailirenTel,
                    dailirenSex : this.owner.dailirenSex  ,
                    dailirenId : this.owner.dailirenId  ,`
                    dailirenName : this.owner.dailirenName ,
                    qianyuerenName : this.owner.qianyuerenName  ,
                    qianyuerenTel : this.owner.qianyuerenTel  ,
                    qianyuerenSex :this.owner.qianyuerenSex  ,
                    qianyuerenId :  this.owner.qianyuerenId  ,*/
                    zuqistartdate:this.addDate.zuqistartdate,
                    zuqienddate:this.addDate.zuqienddate,
                    xieyistartdate:this.addDate.xieyistartdate,
                    xieyienddate:this.addDate.xieyienddate,
                }
                console.log(para);
                optimizePurchaseContract(para).then((res)=>{
                    if(res.data.code == 200)　{
                        this.fuzhi(res);
                        this.btnType=false,
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
                })


            },
            submit(){
                this.$refs['editForm'].validate((valid) => {
                    if(valid){
                        let para = {
                            hetongid:this.$route.query.hetongid,
                            xyid:this.id,
                        }
                        buchongsbSaleContract(para).then((res)=>{
                            if(res.data.code=='200'){
                                this.$router.push('/saleContract');
                            }
                        });
                    }else{
                        this.$message({
                            message:'数据格式有误',
                            type:'error'
                        })
                    }
                });
            },
            //增加免租期
            addFreeItem() {
                this.addDate.mianzuqiList.push({
                    startdate:'',//免租开始
                    enddate:'',//免租结束
                    mianzufangshi:'',
                    key: Date.now()
                });
            },
            //移除免租期
            removeFreeItem(item) {
                var index = this.addDate.mianzuqiList.indexOf(item)
                if (index !== -1) {
                    this.addDate.mianzuqiList.splice(index, 1)
                }
            },
            //增加租期租金
            addRentItem() {
                this.addDate.zujinList.push({
                    startdate:'',//租期开始时间
                    enddate:'',//租期结束时间
                    yuezujin:'',
                    price:'',
                    dizengfangshi:'',
                    dizengliang:'',
                    key: Date.now()
                });
            },
            //移除租期租金
            removeRentItem(item) {
                var index = this.addDate.zujinList.indexOf(item)
                if (index !== -1) {
                    this.addDate.zujinList.splice(index, 1)
                }
            },
            //新增付款方式
            addPayItem() {
                this.addDate.fukuanFangshiList.push({
                    startdate:'',//开始
                    enddate:'',//结束
                    yajinyue:'',
                    zujinyue:'',
                });
            },
            //移除付款方式
            removePayItem(item) {
                var index = this.addDate.fukuanFangshiList.indexOf(item)
                if (index !== -1) {
                    this.addDate.fukuanFangshiList.splice(index, 1)
                }
            },
            //新增产权人
            /*addOwnerItem() {
                this.owner.chanquanrenList.push({
                    Name:'',
                    Id:'',
                    Tel:'',
                    Sex:null,
                });
            },*/
            //移除产权人
            /*removeOwnerItem(item) {
                this.owner.chanquanrenList.pop();
                var index = this.owner.chanquanrenList.indexOf(item)
                if (index !== -1) {
                    this.owner.chanquanrenList.splice(index, 1)
                }
            },*/
            cancel(){
                history.go(-1);
            },
            disabledInput(){
                this.reviewVisible =true;
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
        mounted(){
            this.bianhao = this.$route.query.bianhao;
            //type==1的时候查看协议的内容
            if(this.$route.query.type==1){
                //查询
                alert(11111);
                this.getOptimize();
            }
            //审核页面input禁用
            if(this.$route.path=='/saleContract/checkBuchong'){
                this.disabledInput();
                this.btnShow=false;
            }
        }
    }
</script>