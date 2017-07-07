<template>
    <div>
        <el-form :label-position="labelPosition" label-width="100px" :model="owner">
        <el-col :span="24">
            <el-form-item label="承租人">
                <el-radio-group v-model="owner.chengzufang">
                    <el-radio label="华塑商贸"></el-radio>
                    <el-radio label="幼狮科技"></el-radio>
                    <el-radio label="航远房地产"></el-radio>
                    <el-radio label="航远投资管理"></el-radio>
                    <el-radio label="彭昆"></el-radio>
                    <el-radio label="彭亮"></el-radio>
                </el-radio-group>

            </el-form-item>
            <el-form-item label="居间方"  >
                <el-select
                        v-model="owner.jujianfangid"
                        filterable
                        remote
                        placeholder="渠道公司名称"
                        :remote-method="remoteMethod1"
                        :loading="bkNameloading">
                    <el-option
                            v-for="item in options1"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
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
            <el-form-item label="业主类型">
                <el-radio-group v-model="owner.yezhuleixing">
                    <el-radio :label="1">个人</el-radio>
                    <el-radio :label="2">公司</el-radio>
                </el-radio-group>
            </el-form-item>

            <div v-if="owner.yezhuleixing==1">
                <div v-for="(item, index) in owner.chanquanrenList">
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="产权人" >
                            <el-input v-model="owner.chanquanrenList[index].name"></el-input>
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
                            <el-input v-model="owner.chanquanrenList[index].tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.chanquanrenList[index].sex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button v-show="editVisible" style="margin-left:6px;" @click.prevent="removeRentItem(item)">删除</el-button>
                    </el-col>
                </el-row>
                </div>
                <el-form-item>
                    <el-button v-show="editVisible"  @click="addRentItem">新增产权人</el-button>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="代理人" >
                            <el-input v-model="owner.dailirenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.dailirenId"></el-input>
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
                    <el-input v-model="owner.chanquanrenList[0].name"></el-input>
                </el-form-item>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="法人" >
                            <el-input v-model="owner.chanquanrenList[0].faren"></el-input>
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
                            <el-input v-model="owner.chanquanrenList[0].tel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.chanquanrenList[0].sex">
                                <el-radio :label="1">男</el-radio>
                                <el-radio :label="2">女</el-radio>
                            </el-radio-group>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="签约人" >
                            <el-input v-model="owner.qianyuerenName"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="10">
                        <el-form-item label="身份证号" >
                            <el-input v-model="owner.qianyuerenId"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="8">
                        <el-form-item label="联系方式" >
                            <el-input v-model="owner.qianyuerenTel"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="8">
                        <el-form-item label="性别">
                            <el-radio-group v-model="owner.qianyuerenSex">
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
    import {getbkNameList} from '../../api/api';;
    export default{
        data(){
            return {
                labelPosition:'right',
                bkNameloading:false,
                options1:[
                    {
                        value: 7,
                        label: '幼狮科技'
                    },
                ],
                estate: [],//服务器搜索的渠道公司数据放入这个数组中
                editVisible:true,

            }
        },
        props:['owner'],
        methods: {
            //获取渠道公司名称
            remoteMethod1(query) {

                let para = {
                    name: query
                };
                this.bkNameloading = true;
                getbkNameList(para).then((res) => {

                    let arr = [];
                    arr[0] = '';
                    for ( var i in res.data ){
                        arr[i]=res.data[i]
                    }
                    this.estate = arr;
                    this.bkNameloading = false;
                    this.list = this.estate.map((item,index) => {
                        return { value: index, label: item };
                    });
                    if (query !== '') {
                        this.bkNameloading = true;
                        setTimeout(() => {

                            this.bkNameloading = false;
                            this.options1 = this.list.filter(item => {
                                return item.label.toLowerCase()
                                        .indexOf(query.toLowerCase()) > -1;
                            });
                        }, 200);
                    } else {
                        this.options1 = [];
                    }
                });

            },
            //编辑选择渠道公司将id赋值给隐藏字段
            change(){
                if(!isNaN(this.editForm.tQdCompayId)){
                    this.editForm.tQdCompayName= this.editForm.tQdCompayId;
                }
            },
            //新增产权人
            addRentItem() {
                this.owner.chanquanrenList.push({
                    Name:'',
                    Id:'',
                    Tel:'',
                    Sex:null,
                });
            },
            //移除产权人
            removeRentItem(item) {
                this.owner.chanquanrenList.pop();
                var index = this.owner.chanquanrenList.indexOf(item)
                if (index !== -1) {
                    this.owner.chanquanrenList.splice(index, 1)
                }
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

        }
    }
</script>