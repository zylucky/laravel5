<template>
    <div>
        <el-form :label-position="labelPosition" label-width="100px" :model="owner">
        <el-col :span="24">
            <el-form-item label="承租人">
                <el-radio-group v-model="owner.Chengzufang">
                    <el-radio label="华塑商贸"></el-radio>
                    <el-radio label="幼狮科技"></el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item label="居间方">
                <el-input v-model="owner.Jujianfang"></el-input>
            </el-form-item>
            <el-row>
                <el-col :span="8">
                    <el-form-item label="收款人" >
                        <el-input v-model="owner.Shoukuanren"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="10">
                    <el-form-item label="账号" >
                        <el-input v-model="owner.Zhanghao"></el-input>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="业主类型">
                <el-radio-group v-model="owner.ownerType">
                    <el-radio label="1">个人</el-radio>
                    <el-radio label="2">公司</el-radio>
                </el-radio-group>
            </el-form-item>

            <div v-if="owner.ownerType==1">
                <div v-for="(item, index) in owner.Chanquanren">
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="产权人" >
                            <el-input v-model="owner.Chanquanren_name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.Chanquanren_ID"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button style="margin-left:6px;" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.Chanquanren_Tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.Chanquanren_Sex">
                                <el-radio label="男"></el-radio>
                                <el-radio label="女"></el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                </div>
                <el-form-item>
                    <el-button  @click="addRentItem">新增产权人</el-button>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="代理人" >
                            <el-input v-model="owner.Dailiren_Name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.Dailiren_ID"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.Dailiren_Tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.ownerType">
                                <el-radio label="男"></el-radio>
                                <el-radio label="女"></el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
            <div v-if="owner.ownerType==2">
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="法人" >
                            <el-input v-model="owner.payee"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.bankAccount"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.payee"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.ownerType">
                                <el-radio label="男"></el-radio>
                                <el-radio label="女"></el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="签约人" >
                            <el-input v-model="owner.payee"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.bankAccount"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.payee"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.ownerType">
                                <el-radio label="男"></el-radio>
                                <el-radio label="女"></el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>


        </el-col>
    </el-form>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                labelPosition:'right',
                owner:{
                    Chengzufang:'华溯商贸',
                    Jujianfang:'华亮房产',
                    ownerType:1,
                    //产权人
                    Chanquanren_name:'彭亮',
                    Chanquanren_Tel:'1864521578',
                    Chanquanren_Sex:'',
                    //收款人
                    Shoukuanren:'ha',
                    Zhanghao:'123 456 789',
                    //代理人
                    Dailiren_Name:'彭坤',
                    Dailiren_Tel:'123456',
                    Dailiren_ID:'123 123 123',
                    payee:'彭亮',
                    bankAccount:'834 5678 908 345',
                    Chanquanren:[
                        {value:'',Chanquanren:''},
                    ],
                }

            }
        },
        methods: {
            //新增产权人
            addRentItem() {
                this.owner.Chanquanren.push({
                    value: '',
                    key: Date.now()
                });
            },
            //移除产权人
            removeRentItem(item) {
                var index = this.owner.Chanquanren.indexOf(item)
                if (index !== -1) {
                    this.owner.Chanquanren.splice(index, 1)
                }
            }
        }
    }
</script>