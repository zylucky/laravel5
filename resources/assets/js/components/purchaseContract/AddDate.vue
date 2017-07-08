<template>
    <el-row class="container">
        <el-form :model="addDate"  label-width="100px" class="demo-dynamic">
            <!--免租期-->
            <el-form-item label="免租期" v-for="(item, index) in addDate.mianzuqiList"
                          :key="item.key"
                          :prop="'mianzuqiList.' + index + '.value'"
                          >
                <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                </el-date-picker>
                <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                </el-date-picker>
                <!--免租期方式ddd-->
                    <el-radio-group v-model="item.mianzufangshi">
                        <el-radio :label="1">期内免租</el-radio>
                        <el-radio :label="2">期外免租</el-radio>
                    </el-radio-group>
                <el-button v-show="editVisible" @click.prevent="removeFreeItem(item)">删除</el-button>

            </el-form-item>
            <el-form-item>
                <el-button v-show="editVisible"  @click="addFreeItem">新增免租期</el-button>
            </el-form-item>

            <!--租期-->
            <el-form-item label="总租期">
                <el-date-picker
                        v-model="addDate.startdate"
                        type="date"
                        placeholder="开始时间">
                </el-date-picker>
                <el-date-picker
                        v-model="addDate.enddate"
                        type="date"
                        placeholder="结束时间"
                        @change="zqchange()"
                >
                </el-date-picker>
            </el-form-item>
            <!--租金-->
            <div v-for="(item, index) in addDate.zujinList">
                <el-row>
                    <el-col :span="9" style="width:550px;">

                        <el-form-item :label="'租期' + index"
                                      :key="item.key"
                                      :prop="'zujinList.' + index + '.value'"
                        >
                            <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                            </el-date-picker>
                            <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 130px;margin-left:-20px;">
                        <el-form-item label="月租金" label-width="55px">
                            <el-input v-model="item.yuezujin" class="pulll10" placeholder="租金"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1" style="width: 94px;margin-left:-10px;">
                        <el-form-item label="单价" label-width="40px">
                            <el-input v-model="item.price" class="pulll10" placeholder="单价"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="3" :pull="1" style="margin-left:-10px;">
                        <el-form-item label="递增方式" label-width="70px">
                            <el-input v-model="item.dizengliang" class="pulll10" placeholder=""></el-input>
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
                        <el-button v-show="editVisible" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button  v-show="editVisible" @click="addRentItem">新增租期</el-button>
            </el-form-item>
            <!--付款方式-->
            <div  v-for="(item, index) in addDate.fukuanFangshiList">
                <el-row :gutter="5">
                    <el-col :span="14" style="width:550px;">
                        <el-form-item label="付款方式"
                                      :key="item.key"
                                      :prop="'fukuanFangshiList.' + index + '.value'"
                        >
                            <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                            </el-date-picker>
                            <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="1" :pull="1" style="width: 90px;">
                        <el-form-item label="押" label-width="20px">
                            <el-input v-model="item.yajinyue" placeholder="押几"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="1" :pull="1" style="margin-left: 15px;width: 90px;">
                        <el-form-item label="付" label-width="20px">
                            <el-input v-model="item.zujinyue" placeholder="付几"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2" :pull="1">
                        <el-button v-show="editVisible"  @click.prevent="removePayItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button v-show="editVisible"  @click="addPayItem">新增付款方式</el-button>
            </el-form-item>

            <!--押金 总应付租金 合同佣金-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="押金">
                        <el-input v-model="addDate.yajin" placeholder="押金"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="总应付租金">
                        <el-input v-model="addDate.zongyingfuzujin" placeholder="总应付押金"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="合同佣金">
                        <el-input v-model="addDate.yongjin" placeholder="合同佣金"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--提前几天付款 押金付款日期-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="提前几天付款">
                        <el-input placeholder="提前几天付款" v-model="addDate.tiqianfukuantian" style="width: 100%;"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="备案期限">
                        <el-input placeholder="备案期限" v-model="addDate.beianqixian" style="width: 100%;"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="押金付款日期">
                        <el-date-picker
                                type="date"
                                placeholder="选择日期"
                                v-model="addDate.yajinfukuanri"
                                style="width: 100%;"
                        >
                        </el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--交房日、签约日-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="收房日">
                        <el-date-picker type="date" placeholder="选择日期" v-model="addDate.shoufangdate" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="签约日">
                        <el-date-picker type="date" placeholder="选择日期" v-model="addDate.qianyuedate" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="延长期租金">
                        <el-input placeholder="延长期租金" v-model="addDate.yanqizujin" style="width: 100%;"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--首期支付 二期支付 三期支付-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="首期租金日期">
                        <el-date-picker
                                type="date"
                                v-model="addDate.shouqifukuanri"
                                placeholder="首期租金日期"
                                style="width: 100%"
                        ></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="二期租金日期">
                        <el-date-picker
                                type="date"
                                v-model="addDate.erqifukuanri"
                                placeholder="二期租金日期"
                                style="width: 100%"
                        ></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="三期租金日期">
                        <el-date-picker
                                tpye="date"
                                v-model="addDate.sanqifukuanri"
                                placeholder="三期租金日期"
                                style="width: 100%"
                        ></el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--各种费用-->
            <el-form-item label="甲方承担">
                <el-checkbox-group v-model="addDate.jiafangfeiyong">
                    <el-checkbox label="（一）供暖费"></el-checkbox>
                    <el-checkbox label="（二）制冷费"></el-checkbox>
                    <el-checkbox label="（三）物业管理费"></el-checkbox>
                    <el-checkbox label="（四）水费"></el-checkbox>
                    <el-checkbox label="（五）电费"></el-checkbox>
                    <el-checkbox label="（六）燃气费"></el-checkbox>
                    <el-checkbox label="（七）电话费"></el-checkbox>
                    <el-checkbox label="（八）电视收视费"></el-checkbox>
                    <el-checkbox label="（九）上网费"></el-checkbox>
                    <el-checkbox label="（十）卫生费"></el-checkbox>
                    <el-checkbox label="（十一）车位费"></el-checkbox>
                    <el-checkbox label="（十二）其他"></el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item label="乙方承担">
                <el-checkbox-group v-model="addDate.yifangfeiyong">
                    <el-checkbox label="（一）供暖费"></el-checkbox>
                    <el-checkbox label="（二）制冷费"></el-checkbox>
                    <el-checkbox label="（三）物业管理费"></el-checkbox>
                    <el-checkbox label="（四）水费"></el-checkbox>
                    <el-checkbox label="（五）电费"></el-checkbox>
                    <el-checkbox label="（六）燃气费"></el-checkbox>
                    <el-checkbox label="（七）电话费"></el-checkbox>
                    <el-checkbox label="（八）电视收视费"></el-checkbox>
                    <el-checkbox label="（九）上网费"></el-checkbox>
                    <el-checkbox label="（十）卫生费"></el-checkbox>
                    <el-checkbox label="（十一）车位费"></el-checkbox>
                    <el-checkbox label="（十二）其他"></el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <!--补充条款-->
            <el-col :span="24">
                <el-form-item label="补充条款"  prop="buchongtiaokuan">
                    <el-input type="textarea" row="5px" v-model="addDate.buchongtiaokuan"></el-input>
                </el-form-item>
            </el-col>
        </el-form>
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
                editVisible:true,
                options:[
                    {
                        value: 1,
                        label: '%'
                    }, {
                        value: 2,
                        label: '元'
                    },
                ],
            }
        },
        props:['addDate'],
        methods: {
            onSubmit() {

            },
            zqchange(){
                //时间一改变，我就对zujinList的日期进行填充
                //先获取租期的开始和结束时间
                var d1=new Date(this.addDate.startdate);
                d1.setFullYear(d1.getFullYear()+1);
                d1.setDate(d1.getDate()-1);
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

        },
        mounted(){
            //审核页面input禁用
            if(this.$route.path=='/purchaseContract/review'){
                this.editVisible   =false;
            }
            if(this.$route.path=='/purchaseContract/view'){
                this.editVisible   =false;
            }
        }
    }
</script>
