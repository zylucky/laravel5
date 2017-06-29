<template>
    <el-row class="container">
        <div style="margin-bottom: 50px;"></div>
        <h3>建外SOHO-A-2602</h3>
        <div style="margin-bottom: 50px;"></div>
        <el-form :model="addDate"  label-width="70px" class="demo-dynamic">
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
                <el-row :gutter="5">
                    <el-col :span="9" >
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
                        <el-button  @click.prevent="removePayItem(item)">删除</el-button>
                    </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button  @click="addPayItem">新增付款方式</el-button>
            </el-form-item>
            <!--租金-->
            <div v-for="(item, index) in addDate.zujinList">
                <el-row :gutter="5">
                    <el-col :span="9">

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
                        <el-col :span="2" :pull="1" style="width: 160px;">
                            <el-form-item label="月租金" label-width="55px">
                                <el-input v-model="item.yuezujin" placeholder="租金"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="2" :pull="1" style="width: 120px;">
                            <el-form-item label="单价" label-width="40px">
                                <el-input v-model="item.price" placeholder="单价"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="2" :pull="1">
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
                            <el-button @click.prevent="removeRentItem(item)">删除</el-button>
                        </el-col>
                </el-row>
            </div>
            <el-form-item>
                <el-button  @click="addRentItem">新增租期</el-button>
            </el-form-item>
        </el-form>
        <el-button type=""  @click="cancel" style="margin-top:100px;margin-left: 30%;">取消</el-button>
        <el-button type="primary"  @click="save" style="margin-top:100px;">保存</el-button>
    </el-row>
</template>
<script>
    export default{
        data(){
            return{
                options:[
                    {
                        value: 1,
                        label: '%'
                    }, {
                        value: 2,
                        label: '元'
                    },
                ],
                addDate: {
                    startdate:'',//租期开始时间
                    enddate:'',//租期结束时间
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
            save(){
                console.log('保存')
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
            cancel(){
                history.go(-1);
            },
        }
    }
</script>