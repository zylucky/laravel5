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
                <el-radio-group v-model="owner.Yezhuleixing">
                    <el-radio :label="1">个人</el-radio>
                    <el-radio :label="2">公司</el-radio>
                </el-radio-group>
            </el-form-item>

            <div v-if="owner.Yezhuleixing==1">
                <div v-for="(item, index) in owner.ChanquanrenList">
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="产权人" >
                            <el-input v-model="owner.ChanquanrenList[index].Name"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.ChanquanrenList[index].ID"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.ChanquanrenList[index].Tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.ChanquanrenList[index].Sex">
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
                    <el-button  @click="addRentItem">新增产权人</el-button>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="代理人" >
                            <el-input v-model="owner.DailirenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.DailirenID"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.DailirenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.DailirenSex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
            <div v-if="owner.Yezhuleixing==2">
                <el-form-item label="公司名称" >
                    <el-input v-model="owner.CompanyName"></el-input>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="法人" >
                            <el-input v-model="owner.FarenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.FarenZhanghao"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.FarenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.FarenSex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="签约人" >
                            <el-input v-model="owner.QianyuerenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.QianyuerenZhanghao"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.QianyuerenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.QianyuerenSex">
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
                    Chengzufang:'华溯商贸',
                    Jujianfang:'华亮房产',
                    Yezhuleixing:1,
                    //产权人
                    ChanquanrenList:[
                        {
                            Name:'李岳群',
                            ID:'37158119900124317X',
                            Tel:'18511909124',
                            Sex:1,
                        },
                    ],
                    //收款人
                    Shoukuanren:'彭亮',
                    Zhanghao:'1234 4567 7891 0123',
                    //代理人
                    DailirenName:'李朝晖',
                    DailirenTel:'18511909125',
                    DailirenSex:1,
                    DailirenID:'37158119900124317X',
                    //业主类型为公司
                    CompanyName:'北京大象群文化传媒有限公司',
                    FarenName:'刘总',
                    FarenZhanghao:'8341 5678 908 3451',
                    FarenTel:'18511909126',
                    FarenSex:1,
                    //业主类型为个人
                    QianyuerenName:'李岳群',
                    QianyuerenZhanghao:'8341 5678 908 3451',
                    QianyuerenTel:'18511909125',
                    QianyuerenSex:1,
                }

            }
        },
        methods: {
            //新增产权人
            addRentItem() {
                this.owner.ChanquanrenList.push({
                    Name:'',
                    Id:'',
                    Tel:'',
                    Sex:0,
                });
            },
            //移除产权人
            removeRentItem(item) {
                this.owner.ChanquanrenList.pop();
                var index = this.owner.ChanquanrenList.indexOf(item)
                if (index !== -1) {
                    this.owner.ChanquanrenList.splice(index, 1)
                }
            }
        }
    }
</script>