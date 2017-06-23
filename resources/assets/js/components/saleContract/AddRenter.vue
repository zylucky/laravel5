<template>
    <div>
        <el-form :label-position="labelPosition" label-width="100px" :model="owner">
        <el-col :span="24">
            <el-form-item label="出租人">
                <el-radio-group v-model="owner.chengzufang">
                    <el-radio label="华塑商贸"></el-radio>
                    <el-radio label="幼狮科技"></el-radio>
                    <el-radio label="航远房地产"></el-radio>
                    <el-radio label="航远投资管理"></el-radio>
                    <el-radio label="彭昆"></el-radio>
                    <el-radio label="彭亮"></el-radio>
                </el-radio-group>

            </el-form-item>
            <el-form-item label="居间方">
                <el-input v-model="owner.jujianfang"></el-input>
            </el-form-item>
            <el-row>
                <el-col :span="8">
                    <el-form-item label="收款人" >
                        <el-input v-model="owner.shoukuanren"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="10">
                    <el-form-item label="开户行" >
                        <el-input v-model="owner.kaihuhang"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="8">
                    <el-form-item label="账号" >
                        <el-input v-model="owner.zhanghao"></el-input>
                    </el-form-item>
                </el-col>

            </el-row>
            <el-form-item label="租户类型">
                <el-radio-group v-model="owner.yezhuleixing">
                    <el-radio :label="1">个人</el-radio>
                    <el-radio :label="2">公司</el-radio>
                </el-radio-group>
            </el-form-item>

            <div v-if="owner.yezhuleixing==1">
                <div v-for="(item, index) in owner.chanquanrenList">
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="承租人" >
                            <el-input v-model="owner.chanquanrenList[index].Name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.chanquanrenList[index].zhengjian"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.chanquanrenList[index].Tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.chanquanrenList[index].Sex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button style="margin-left:6px;" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
                </div>
                <el-form-item>
                    <el-button  @click="addRentItem">新增承租人</el-button>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="代理人" >
                            <el-input v-model="owner.dailirenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.dailirenZhengjian"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.dailirenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.dailirenSex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
            <div v-if="owner.yezhuleixing==2">
                <el-form-item label="公司名称" >
                    <el-input v-model="owner.chanquanrenList[0].Name"></el-input>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="法人" >
                            <el-input v-model="owner.chanquanrenList[0].Faren"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.chanquanrenList[0].zhengjian"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.chanquanrenList[0].Tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.chanquanrenList[0].Sex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="签约人" >
                            <el-input v-model="owner.dailirenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.dailirenZhengjian"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.dailirenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.dailirenSex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
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
                    chengzufang:'华溯商贸',
                    jujianfang:'华亮房产',
                    yezhuleixing:1,
                    //承租人
                    chanquanrenList:[
                        {
                            Faren:'李岳群',
                            Name:'北京大象群文化传媒有限公司',
                            zhengjian:'37158119900124317X',
                            Tel:'18511909124',
                            Sex:1,
                        },
                    ],
                    //收款人
                    shoukuanren:'彭亮',
                    zhanghao:'1234 4567 7891 0123',
                    kaihuhang:'中国建设银行',
                    //代理人
                    dailirenName:'李朝晖',
                    dailirenTel:'18511909125',
                    dailirenSex:1,
                    dailirenZhengjian:'37158119900124317X',
                }

            }
        },
        methods: {
            //新增承租人
            addRentItem() {
                this.owner.chanquanrenList.push({
                    Name:'',
                    Id:'',
                    Tel:'',
                    Sex:0,
                });
            },
            //移除承租人
            removeRentItem(item) {
                this.owner.chanquanrenList.pop();
                var index = this.owner.chanquanrenList.indexOf(item)
                if (index !== -1) {
                    this.owner.chanquanrenList.splice(index, 1)
                }
            }
        }
    }
</script>