<template>
    <el-row class="container">
        <el-form :model="addDate"  label-width="100px" class="demo-dynamic">
            <!--交房日、签约日-->
            <el-row>
                <el-col :span="8">
                    <el-form-item label="收房日">
                        <el-date-picker type="date" placeholder="选择日期" v-model="addDate.shoufangDate" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="签约日">
                        <el-date-picker type="date" placeholder="选择日期" v-model="addDate.qianyueDate" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <!--免租期方式-->
            <el-form-item label="免租方式">
                <el-radio-group v-model="addDate.mianzufangshi">
                    <el-radio :label="1">期内免租</el-radio>
                    <el-radio :label="2">期外免租</el-radio>
                    <el-radio :label="3">期内期外</el-radio>
                </el-radio-group>
            </el-form-item>
            <!--免租期-->
            <el-form-item label="免租期" v-for="(item, index) in addDate.mianzuqiList"
                          :key="item.key"
                          :prop="'mianzuqiList.' + index + '.value'"
                          >
                <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                </el-date-picker>
                <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                </el-date-picker>
                <el-button @click.prevent="removeFreeItem(item)">删除</el-button>

            </el-form-item>
            <el-form-item>
                <el-button  @click="addFreeItem">新增免租期</el-button>
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
                        placeholder="结束时间">
                </el-date-picker>
            </el-form-item>
            <!--付款方式-->
            <div  v-for="(item, index) in addDate.fukuanFangshiList">
                <el-form-item label="付款方式"
                              :key="item.key"
                              :prop="'fukuanFangshiList.' + index + '.value'"
                >
                    <el-row>
                        <el-col :span="13">
                            <el-date-picker type = "date" placeholder="开始时间" v-model="item.startdate">
                            </el-date-picker>
                            <el-date-picker type = "date" placeholder="结束时间" v-model="item.enddate">
                            </el-date-picker>
                        </el-col>
                        <el-col :span="3">
                            <el-form-item label="" label-width="10px">
                                <el-input v-model="item.yajinyue" placeholder="押几"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="3">
                            <el-form-item label="" label-width="10px">
                                <el-input v-model="item.zujinyue" placeholder="付几"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="2">
                            <el-button  @click.prevent="removePayItem(item)">删除</el-button>
                        </el-col>
                    </el-row>
                </el-form-item>
            </div>
            <el-form-item>
                <el-button  @click="addPayItem">新增付款方式</el-button>
            </el-form-item>
            <!--租金-->
            <div v-for="(item, index) in addDate.zujinList">
                <el-row>
                    <el-col :span="9">
                        <el-form-item :label="'租期' + index"
                                      :key="item.key"
                                      :prop="'zujinList.' + index + '.value'"
                        >
                            <el-date-picker type = "daterange" placeholder="租期范围" v-model="item.zuqiDate">
                            </el-date-picker>
                        </el-form-item>
                    </el-col>
                    <el-col :span="3">
                        <el-form-item label="" label-width="10px">
                            <el-input v-model="item.yuezujin" placeholder="租金/元"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="3">
                        <el-form-item label="" label-width="10px">
                            <el-input v-model="item.price" placeholder="单价"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="3">
                        <el-form-item label="" label-width="10px">
                            <el-select v-model="addDate.zujinList[index].dizengfangshi" placeholder="递增方式">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="3">
                        <el-form-item label="" label-width="10px">
                            <el-input v-model="item.dizengliang" placeholder="递增量"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button style="margin-left:6px;" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button  @click="addRentItem">新增租期</el-button>
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
                        <el-input v-model="addDate.zongzujin" placeholder="总应付押金"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="合同佣金">
                        <el-input v-model="addDate.commission" placeholder="合同佣金"></el-input>
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
            <el-form-item label="费用">
                <el-checkbox-group v-model="addDate.checkList">
                    <el-checkbox label="1">物业费</el-checkbox>
                    <el-checkbox label="2">取暖费</el-checkbox>
                    <el-checkbox label="3">制冷</el-checkbox>
                    <el-checkbox label="4">发票</el-checkbox>
                    <el-checkbox label="5">其它</el-checkbox>
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
<script>
    import ElCol from "element-ui/packages/col/src/col";
    export default {
        components: {ElCol},
        data() {
            return {
                options:[
                    {
                        value: '1',
                        label: '%'
                    }, {
                        value: '2',
                        label: '元'
                    },
                ],
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
                            zuqiDate:'',
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
        methods: {
            onSubmit() {

            },
            //增加免租期
            addFreeItem() {
                this.addDate.mianzuqiList.push({
                    startdate:'',//免租开始
                    enddate:'',//免租结束
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
                    zuqiDate:'',
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

        }
    }
</script>
