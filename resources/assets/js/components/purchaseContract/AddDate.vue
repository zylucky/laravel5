        <template>
        <el-row class="container">
            <el-form :model="addDate" ref="dynamicValidateForm" label-width="100px" class="demo-dynamic">
             <!--交房日、签约日-->
              <el-row>
                  <el-col :span="8">
                  <el-form-item label="交房日">
                          <el-date-picker type="date" placeholder="选择日期" v-model="addDate.date1" style="width: 100%;"></el-date-picker>
                  </el-form-item>
                  </el-col>
                  <el-col :span="8">
                  <el-form-item label="签约日">
                          <el-date-picker type="date" placeholder="选择日期" v-model="addDate.date2" style="width: 100%;"></el-date-picker>
                  </el-form-item>
                  </el-col>
              </el-row>
                <!--免租期方式-->
              <el-form-item label="免租方式">
                <el-radio-group v-model="addDate.radio2">
                    <el-radio :label="3">期内免租</el-radio>
                    <el-radio :label="6">期外免租</el-radio>
                    <el-radio :label="9">期内期外</el-radio>
                </el-radio-group>
              </el-form-item>
                <!--免租期-->
                  <el-form-item label="免租期">
                      <el-col :span="8">
                      <el-date-picker
                              v-for="(domain, index) in addDate.domains"
                              type = "daterange"
                              :key="domain.key"
                              :prop="'domains.' + index + '.value'"
                              :rules="{
                              required: true, message: '免租期不能为空', trigger: 'blur'
                            }"
                      >
                          <el-input  v-model="domain.value"></el-input><el-button @click.prevent="removeDomain(domain)">删除</el-button>
                      </el-date-picker>
                      <el-button  @click="addDomain">新增免租期</el-button>

                      </el-col>
                  <!--<el-date-picker-->
                          <!--style="float:left"-->
                          <!--v-model="date.value6"-->
                          <!--type="daterange"-->
                          <!--placeholder="选择日期范围">-->
                  <!--</el-date-picker>-->
                  </el-form-item>
                <!--租期-->
                 <el-form-item label="租期">
                    <el-date-picker
                            v-model="addDate.value7"
                            type="daterange"
                            placeholder="选择日期范围">
                    </el-date-picker>
                 </el-form-item>
                    <!--押金 总应付租金 合同佣金-->
                    <el-row>
                        <el-col :span="8">
                            <el-form-item label="押金">
                                <el-input v-model="addDate.money" placeholder="押金"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item label="总应付租金">
                                <el-input v-model="addDate.rent" placeholder="总应付押金"></el-input>
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
                                 <el-input placeholder="提前几天付款" v-model="addDate.day" style="width: 100%;"></el-input>
                             </el-form-item>
                         </el-col>
                         <el-col :span="8">
                             <el-form-item label="押金付款日期">
                                 <el-date-picker
                                         type="date"
                                         placeholder="选择日期"
                                         v-model="addDate.date2"
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
                                         v-model="addDate.first"
                                         placeholder="首期租金日期"
                                         style="width: 100%"
                                 ></el-date-picker>
                             </el-form-item>
                         </el-col>
                         <el-col :span="8">
                             <el-form-item label="二期租金日期">
                                 <el-date-picker
                                         type="date"
                                         v-model="addDate.second"
                                         placeholder="二期租金日期"
                                         style="width: 100%"
                                 ></el-date-picker>
                             </el-form-item>
                         </el-col>
                         <el-col :span="8">
                             <el-form-item label="三期租金日期">
                                 <el-date-picker
                                         tpye="date"
                                         v-model="addDate.third"
                                         placeholder="三期租金日期"
                                         style="width: 100%"
                                 ></el-date-picker>
                             </el-form-item>
                         </el-col>
                     </el-row>
                    <!--各种费用-->
                     <el-form-item label="费用">
                         <el-checkbox-group v-model="checkList">
                            <el-checkbox label="1">物业费</el-checkbox>
                            <el-checkbox label="2">取暖费</el-checkbox>
                            <el-checkbox label="3">制冷</el-checkbox>
                            <el-checkbox label="4">发票</el-checkbox>
                            <el-checkbox label="5">其它</el-checkbox>
                         </el-checkbox-group>
                     </el-form-item>
                    <!--补充条款-->
                    <el-col :span="12">
                        <el-form-item label="补充条款"  prop="desc">
                            <el-input type="textarea" rows="5px" v-model="addDate.desc"></el-input>
                        </el-form-item>
                    </el-col>
            </el-form>
        </el-row>

        </template>
        <script>
            export default {
                data() {
                    return {

                        addDate: {
                            date1: '',
                            date2: '',
                            radio2: '',
                            value6: '',
                            value7: '',
                            commission:'',
                            domains: [{
                                value:''
                            }],
                            rent:'',
                            many:'',
                            day:'',
                            value8:'',
                            first:'',
                            second:'',
                            third:'',

                            desc:'',
                        },
                        checkList: []
                    }
                },
                methods: {
                    onSubmit() {
                        console.log('submit!');
                    },
                    addDomain() {
                        this.addDate.domains.push({
                            value: '',
                            key: Date.now()
                        });
                    }
                }
            }
        </script>
