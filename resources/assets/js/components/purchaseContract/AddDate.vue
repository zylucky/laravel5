<template>
    <el-row class="container">
        <el-form :model="addDate" ref="addDateForm" :rules="editDateRules"  label-width="100px" class="demo-dynamic">
            <!--免-->

            <el-form-item label="免租期" v-for="(item, index) in addDate.mianzuqiList"
                          :key="item.key"
                          >
                <el-col  style="width:410px;">

                <el-col :span="12">
                    <el-form-item >
                        <el-date-picker :disabled="lydisabled" type = "date" placeholder="开始时间" v-model="item.startdate">
                        </el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item

                            :prop="'mianzuqiList.' + index + '.enddate'"
                            :rules="[
                                {required: false,validator:
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
                        <el-date-picker :disabled="lydisabled" type = "date" placeholder="结束时间" v-model="item.enddate" >
                        </el-date-picker>
                    </el-form-item>
                </el-col>
                </el-col>

                <!--免方式ddd-->
                <el-radio-group v-model="item.mianzufangshi" :disabled="lydisabled">
                    <el-radio :label="1">期内免租</el-radio>
                    <el-radio :label="2">期外免租</el-radio>
                </el-radio-group>
                <el-button v-if="index>0" v-show="editVisible" @click.prevent="removeFreeItem(item)">删除</el-button>

            </el-form-item>

            <el-form-item>
                <el-button :disabled="lydisabled" v-show="editVisible"  @click="addFreeItem">新增免租期</el-button>
            </el-form-item>

            <!--总租期-->

            <el-row>
                <el-col :span="9" style="width:550px;">
                    <el-form-item label="总租期" required>
                        <el-col :span="11">
                            <el-form-item prop="startdate">
                                <el-date-picker
                                        v-model="addDate.startdate"
                                        type="date"
                                        placeholder="开始时间"
                                        @change="zqchange1()"
                                        :disabled="lydisabled"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="11">
                            <el-form-item prop="enddate">
                                <el-date-picker
                                        v-model="addDate.enddate"
                                        type="date"
                                        placeholder="结束时间"
                                        @change="zqchange2()"
                                        :disabled="lydisabled"
                                >
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--租金-->
            <div v-for="(item, index) in addDate.zujinList"
                 :key="item.key"
            >
                <el-row>
                    <el-col :span="9" style="width:550px;">

                        <el-form-item :label="'租期' + (index + 1)"
                                      required
                        >
                            <el-col :span="11">
                                <el-form-item  :prop="'zujinList.' + index + '.startdate' " :rules="[
                                {
                                    required: true, message: '不能为空'
                                }
                                ]"
                                >
                                    <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate" :disabled="lydisabled">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                            <el-col :span="11">
                                <el-form-item :prop="'zujinList.' + index + '.enddate' " :rules="[
                                {  required: true,validator:
                                (rule,value,callback)=>{
                                    var d1= new Date( addDate.zujinList[index].startdate);
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
                                ]"
                                >
                                    <el-date-picker  type = "date" placeholder="结束时间" v-model="item.enddate" :disabled="lydisabled">
                                    </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 130px;margin-left:-20px;">
                        <el-form-item label="月租金" label-width="55px"  :prop="'zujinList.' + index + '.yuezujin'" :rules="[{
                                    required: true, message: '不能为空'
                                },{ type: 'number', message: '必须为数字'}]" >
                            <el-input v-model.number="item.yuezujin" class="pulll10"
                                      placeholder="租金"
                                      @change="perPrice(index,item.yuezujin)"
                                      :disabled="lydisabled"
                            ></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 94px;margin-left:-10px;">
                        <el-form-item label="单价" label-width="40px"  :prop="'zujinList.' + index + '.price' " :rules="[{
                                    required: true, message: '不能为空'
                                },{ type: 'number', message: '必须为数字'}]">
                            <el-input v-model.number="item.price" class="pulll10" placeholder="单价" :disabled="lydisabled"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="3" :pull="1" style="margin-left:-10px;">
                        <el-form-item label="递增方式" label-width="70px">
                            <el-input v-model="item.dizengliang" class="pulll10" placeholder="" :disabled="lydisabled"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2"  style="width: 70px;margin-left:-50px;">
                        <el-select v-model="addDate.zujinList[index].dizengfangshi"   placeholder="">
                            <el-option
                                    v-for="item in options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :span="2" style="margin-left:5px;">
                        <el-button v-if="index>0" v-show="editVisible" @click.prevent="removeRentItem(item)">删除</el-button>
                        <el-button v-if="index==0" v-show="editVisible" @click="addRentItem">新增</el-button>
                    </el-col>
                </el-row>
            </div>
            <!--付款方式-->
            <div  v-for="(item, index) in addDate.fukuanFangshiList">
                <el-row :gutter="5">
                    <el-col :span="14" style="width:550px;">
                        <el-form-item label="付款方式"
                                      :key="item.key"
                                      required
                        >
                            <el-col :span="11">
                                <el-form-item  :prop="'fukuanFangshiList.' + index + '.startdate'" :rules="{
                                    required: true, message: '不能为空'
                                }">
                            <el-date-picker type = "date"  placeholder="开始时间" v-model="item.startdate" :disabled="lydisabled">
                            </el-date-picker>
                                </el-form-item>
                            </el-col>
                            <el-col :span="11">
                                <el-form-item :prop="'fukuanFangshiList.' + index + '.enddate'" :rules="[
                                {  required: true,validator:
                                (rule,value,callback)=>{
                                    var d1= new Date( addDate.fukuanFangshiList[index].startdate);
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
                                ]">
                            <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate" :disabled="lydisabled">
                            </el-date-picker>
                                </el-form-item>
                            </el-col>
                        </el-form-item>
                    </el-col>
                    <el-col :span="1" :pull="1" style="width: 150px;">
                        <el-form-item label="押" label-width="40px" :prop="'fukuanFangshiList.' + index + '.yajinyue'" :rules="[{
                                    required: true, message: '不能为空'
                                },{ type: 'number', message: '必须为数字'}]">
                            <el-input v-model.number="item.yajinyue" placeholder="押几" @change="yajin(index,item.yajinyue)" :disabled="lydisabled" style="margin-left:0"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="1" :pull="1" style="margin-left: 15px;width: 150px;">
                        <el-form-item label="付" label-width="40px" :prop="'fukuanFangshiList.' + index + '.zujinyue'" :rules="[{
                                    required: true, message: '不能为空'
                                },{ type: 'number', message: '必须为数字'}]">
                            <el-input v-model.number="item.zujinyue" placeholder="付几" style="margin-left:0" :disabled="lydisabled"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1">
                        <el-button v-if="index>0" v-show="editVisible"  @click.prevent="removePayItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button v-show="editVisible"  @click="addPayItem">新增付款方式</el-button>
            </el-form-item>

            <!--押金 总应付租金 合同佣金-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="押金" prop="yajin" required>
                        <el-input v-model.number="addDate.yajin" placeholder="押金" :disabled="lydisabled"></el-input>
                    </el-form-item>
                </el-col>
                <!--<el-col :span="8">-->
                    <!--<el-form-item label="总应付租金" prop="zongyingfuzujin" required>-->
                        <!--<el-input v-model.number="addDate.zongyingfuzujin" placeholder="总应付租金"></el-input>-->
                    <!--</el-form-item>-->
                <!--</el-col>-->
                <el-col :span="8">
                    <el-form-item label="合同佣金" prop="yongjin" required>
                        <el-input v-model.number="addDate.yongjin" placeholder="合同佣金" :disabled="lydisabled"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="实际月租金" prop="actualrent" >
                        <el-input v-model.number="addDate.actualrent" placeholder="实际月租金" :disabled="lydisabled"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--提前几天付款 押金付款日期-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="提前几天付款" prop="tiqianfukuantian" required>
                        <el-input placeholder="提前几天付款" v-model.number="addDate.tiqianfukuantian" :disabled="lydisabled" style="width: 100%;"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="备案期限" prop="beianqixian" required>
                        <el-input placeholder="备案期限" v-model.number="addDate.beianqixian" style="width: 100%;" :disabled="lydisabled"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="押金付款日期" prop="yajinfukuanri" required>
                        <el-date-picker
                                type="date"
                                placeholder="选择日期"
                                v-model="addDate.yajinfukuanri"
                                style="width: 100%;"
                                :disabled="lydisabled"
                        >
                        </el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--交房日、签约日-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="收房日" prop="shoufangdate" >
                        <el-date-picker :disabled="lydisabled" type="date" placeholder="选择日期" v-model="addDate.shoufangdate" style="width: 100%;" ></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="签约日" prop="qianyuedate" >
                        <el-date-picker :disabled="lydisabled" type="date" placeholder="选择日期" v-model="addDate.qianyuedate" style="width: 100%;" ></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="延长期租金">
                        <el-input :disabled="lydisabled" placeholder="延长期租金" v-model.number="addDate.yanqizujin" style="width: 100%;"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--首期支付 二期支付 三期支付-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="首期租金日期" prop="shouqifukuanri" required>
                        <el-date-picker
                                type="date"
                                v-model="addDate.shouqifukuanri"
                                placeholder="首期租金日期"
                                style="width: 100%"
                                :disabled="lydisabled"
                        ></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="二期租金日期" prop="erqifukuanri" required>
                        <el-date-picker
                                type="date"
                                v-model="addDate.erqifukuanri"
                                placeholder="二期租金日期"
                                style="width: 100%"
                                :disabled="lydisabled"
                        ></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="三期租金日期" prop="sanqifukuanri" required>
                        <el-date-picker
                                tpye="date"
                                v-model="addDate.sanqifukuanri"
                                placeholder="三期租金日期"
                                style="width: 100%"
                                :disabled="lydisabled"
                        ></el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--各种费用-->
            <el-form-item label="甲方承担" prop="jiafangfeiyong" >
                <el-checkbox-group
                        v-model="addDate.jiafangfeiyong"
                        @change="changeOnCheck(1)"
                        :disabled="lydisabled"
                >
                    <el-checkbox label="（1）供暖费"></el-checkbox>
                    <el-checkbox label="（2）制冷费"></el-checkbox>
                    <el-checkbox label="（3）物业管理费"></el-checkbox>
                    <el-checkbox label="（4）水费"></el-checkbox>
                    <el-checkbox label="（5）电费"></el-checkbox>
                    <el-checkbox label="（6）燃气费"></el-checkbox>
                    <el-checkbox label="（7）电话费"></el-checkbox>
                    <el-checkbox label="（8）电视收视费"></el-checkbox>
                    <el-checkbox label="（9）上网费"></el-checkbox>
                    <el-checkbox label="（10）卫生费"></el-checkbox>
                    <el-checkbox label="（11）车位费"></el-checkbox>
                    <el-checkbox label="（12）其他"></el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item label="乙方承担" prop="yifangfeiyong"  >
                <el-checkbox-group v-model="addDate.yifangfeiyong" @change="changeOnCheck(2)" :disabled="true">
                    <el-checkbox label="（1）供暖费"></el-checkbox>
                    <el-checkbox label="（2）制冷费"></el-checkbox>
                    <el-checkbox label="（3）物业管理费"></el-checkbox>
                    <el-checkbox label="（4）水费"></el-checkbox>
                    <el-checkbox label="（5）电费"></el-checkbox>
                    <el-checkbox label="（6）燃气费"></el-checkbox>
                    <el-checkbox label="（7）电话费"></el-checkbox>
                    <el-checkbox label="（8）电视收视费"></el-checkbox>
                    <el-checkbox label="（9）上网费"></el-checkbox>
                    <el-checkbox label="（10）卫生费"></el-checkbox>
                    <el-checkbox label="（11）车位费"></el-checkbox>
                    <el-checkbox label="（12）其他"></el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <!--补充条款-->
            <el-col :span="24">
                <el-form-item label="补充条款"  prop="buchongtiaokuan">
                    <el-input type="textarea" :rows="12" v-model="addDate.yingyezhizhao"></el-input>
                </el-form-item>
            </el-col>
        </el-form>
        <el-form :model="property"></el-form>
    </el-row>

</template>
<style>
    .pulll10{
        margin-left: -10px;
    }
</style>
<script>
    import ElCol from "element-ui/packages/col/src/col";
    export default {
        components: {ElCol},
        data() {
            return {
                checkList : [
                    "（1）供暖费",
                    "（2）制冷费",
                    "（3）物业管理费",
                    "（4）水费",
                    "（5）电费",
                    "（6）燃气费",
                    "（7）电话费",
                    "（8）电视收视费",
                    "（9）上网费",
                    "（10）卫生费",
                    "（11）车位费",
                    "（12）其他"
                ],
                editVisible:true,
                lydisabled:false,
                options:[
                    {
                        value: 1,
                        label: '%'
                    }, {
                        value: 2,
                        label: '元'
                    },
                ],
                editDateRules :{
                    startdate:[
                        { required: true, message: '不能为空' },
                    ],
                    enddate:[
                        {  required: true,validator:
                            (rule,value,callback)=>{
                                var d1= new Date( this.addDate.startdate);
                                var d2= new Date(value);
                                if(d2<d1){
                                    callback('结束日期不能小于开始日期');
                                }else{
                                    callback();
                                };
                            }, trigger:'blur'}
                    ],
                    yajin: [
                        { required: true, message: '不能为空' },
                        { type: 'number', message: '必须为数字'},
                    ],
                    zongyingfuzujin: [
                        { required: true, message: '不能为空' },
                        { type: 'number', message: '必须为数字'},
                    ],
                    yongjin: [
                        { required: true, message: '不能为空' },
                        { type: 'number', message: '必须为数字'},
                    ],
                    actualrent: [
                        { type: 'number', message: '必须为数字'},
                    ],
                    tiqianfukuantian: [
                        { required: true, message: '不能为空' },
                        { type: 'number', message: '必须为数字'},
                    ],
                    beianqixian: [
                        { required: true, message: '不能为空' },
                        { type: 'number', message: '必须为数字'},
                    ],yajinfukuanri: [
                        { required: true, message: '不能为空' },
                    ],
//                    shoufangdate: [
//                        { required: true, message: '不能为空' }
//                    ],qianyuedate: [
//                        { required: true, message: '不能为空' }
//                    ],
                    shouqifukuanri: [
                        { required: true, message: '不能为空' }
                    ],erqifukuanri: [
                        { required: true, message: '不能为空' }
                    ],sanqifukuanri: [
                        { required: true, message: '不能为空' }
                    ],
//                    jiafangfeiyong: [
//                        { required: true, message: '不能为空' }
//                    ],yifangfeiyong: [
//                        { required: true, message: '不能为空' }
//                    ],

                },
            }
        },
        props:['addDate','property'],
        methods: {
            changeDate(value){
                var newDate = new Date();
                newDate.setTime(value);
                value= newDate.getFullYear()+'-'+newDate.getMonth()+'-'+newDate.getDay();
            },
            changeOnCheck(index){
                let jafangs =  this.addDate.jiafangfeiyong;
                let yifangs =  this.addDate.yifangfeiyong;
                console.log(this.addDate.jiafangfeiyong)

                if(index==1){
                    //点击甲方的时候
                    if(this.addDate.jiafangfeiyong[0]==""){
                        this.addDate.jiafangfeiyong.splice(0,1);
                    }
                    this.addDate.yifangfeiyong = [];
                    this.checkList.forEach((check,index)=>{
                        if(jafangs.indexOf(check)==-1){
                            //如果列表内的数据不存在于甲方的，就属于乙方
                            this.addDate.yifangfeiyong.push(check);
                        }
                    })
                }else if(index==2){
                    this.addDate.jiafangfeiyong = [];
                    this.checkList.forEach((check,index)=>{
                        if(yifangs.indexOf(check)==-1){
                            //如果列表内的数据不存在于甲方的，就属于乙方
                            this.addDate.jiafangfeiyong.push(check);
                        }
                    })
                }
            },

            valid(){
                this.$refs['addDateForm'].validate((valid) => {
                    this.addDate.flag = valid;
                });
            },
            onSubmit() {

            },
            zqchange1(){
                if(this.$route.path=='/purchaseContract/add'){
                    //时间一改变就对zujinList的日期进行填充
                    //先获取的开始和结束时间
                    var d1=new Date(this.addDate.startdate);
                    var d2=new Date(this.addDate.enddate);
                    var cha = (parseInt(d2.getFullYear())-parseInt(d1.getFullYear()))/2;
                    //每次变数据清空当前的列表
                    this.addDate.zujinList.splice(0,this.addDate.zujinList.length);//清空数组
                    for(var i =0;i<cha;i++){
                        this.addRentItem();
                        if(i==0){
                            this.addDate.zujinList[i].startdate = d1.setFullYear(d1.getFullYear());
                            let dx = new Date(this.addDate.zujinList[i].startdate);//将时间复制，然后加一年
                            this.addDate.zujinList[i].enddate = dx.setFullYear(dx.getFullYear()+2);
                            let dy = new Date(this.addDate.zujinList[i].enddate);//将时间复制，然后减一天
                            this.addDate.zujinList[i].enddate = dy.setDate(dx.getDate()-1);
                        }
                        if(i>0){
                            this.addDate.zujinList[i].startdate = d1.setFullYear(d1.getFullYear()+2);
                            let dx = new Date(this.addDate.zujinList[i].startdate);//将时间复制，然后加一年
                            this.addDate.zujinList[i].enddate = dx.setFullYear(dx.getFullYear()+2);
                            let dy = new Date(this.addDate.zujinList[i].enddate);//将时间复制，然后减一天
                            this.addDate.zujinList[i].enddate = dy.setDate(dx.getDate()-1);
                        }
                    }
                    }
            },
            zqchange2(){
                if(this.$route.path=='/purchaseContract/add') {
                    //时间一改变就对zujinList的日期进行填充
                    //先获取的开始和结束时间
                    var d1 = new Date(this.addDate.startdate);
                    var d2 = new Date(this.addDate.enddate);
                    var cha = (parseInt(d2.getFullYear()) - parseInt(d1.getFullYear()))/2;
                    //每次变数据清空当前的列表
                    this.addDate.zujinList.splice(0, this.addDate.zujinList.length);//清空数组
                    for (var i = 0; i < cha; i++) {
                        this.addRentItem();
                        if (i == 0) {
                            this.addDate.zujinList[i].startdate = d1.setFullYear(d1.getFullYear());
                            let dx = new Date(this.addDate.zujinList[i].startdate);//将时间复制，然后加一年
                            this.addDate.zujinList[i].enddate = dx.setFullYear(dx.getFullYear() + 2);
                            let dy = new Date(this.addDate.zujinList[i].enddate);//将时间复制，然后减一天
                            this.addDate.zujinList[i].enddate = dy.setDate(dx.getDate() - 1);
                        }
                        if (i > 0) {
                            this.addDate.zujinList[i].startdate = d1.setFullYear(d1.getFullYear() + 2);
                            let dx = new Date(this.addDate.zujinList[i].startdate);//将时间复制，然后加一年
                            this.addDate.zujinList[i].enddate = dx.setFullYear(dx.getFullYear() + 2);
                            let dy = new Date(this.addDate.zujinList[i].enddate);//将时间复制，然后减一天
                            this.addDate.zujinList[i].enddate = dy.setDate(dx.getDate() - 1);
                        }
                    }
                }
            },
            //增加免
            addFreeItem() {
                this.addDate.mianzuqiList.push({
                    startdate:'',//免租开始
                    enddate:'',//免租结束
                    mianzufangshi:'',
                    key: Date.now()
                });
            },
            //移除免
            removeFreeItem(item) {
                var index = this.addDate.mianzuqiList.indexOf(item)
                if (index !== -1) {
                    this.addDate.mianzuqiList.splice(index, 1)
                }
            },
            //增加租金
            addRentItem() {
                this.addDate.zujinList.push({
                    startdate:'',//开始时间
                    enddate:'',//结束时间
                    yuezujin:'',
                    price:'',
                    dizengfangshi:'',
                    dizengliang:'',
                });
            },
            //移除租金
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
            //计算单价
            perPrice(index,value){
                //1.先计算面积综合
                var areaToal = 0;
                this.property.officeList.forEach((property,index)=>{
                    areaToal += property.qianyuemianji;
                })
                //2.计算单价
                var perPrice = (value*12/365/areaToal).toFixed(2);
                this.addDate.zujinList[index].price = parseFloat(perPrice);
            },
            yajin(index,value){
                this.addDate.yajin = this.addDate.fukuanFangshiList[0].yajinyue*(this.addDate.zujinList[0].yuezujin)
            }

        },
        mounted(){
            //审核页面input禁用
            if(this.$route.path=='/purchaseContract/review'){
                this.editVisible   =false;
            }
            if(this.$route.path=='/purchaseContract/view'){
                this.editVisible   =false;
            }
            if(this.$route.path=='/purchaseContract/edit'&&this.$route.query.status>=6){
                this.lydisabled = true;
                this.editVisible=false;
            }

        }
    }
</script>
