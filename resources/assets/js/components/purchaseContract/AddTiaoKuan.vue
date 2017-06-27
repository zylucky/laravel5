<template>
    <div>
        <div class="test">
            <el-row :gutter="5">
                <el-col :span="20">
                    <el-input  style="font-size:18px" size="large" v-show="tiaokuan[0].tiao.show" v-model="tiaokuan[0].tiao.content"></el-input>
                </el-col>
                <el-col :span="4" >
                    <el-button type="info" v-show="tiaokuan[0].tiao.show" @click="save(tiaokuan[0].tiao)">保存</el-button>
                    <el-button type="info" :plain="true" v-show="tiaokuan[0].tiao.show" @click="cancel(tiaokuan[0].tiao)">取消</el-button>
                </el-col>
            </el-row>
            <span class="tiao" v-show="!tiaokuan[0].tiao.show">{{tiaokuan[0].tiao.content}}</span>
            <a  href="javascript:;" v-show="!tiaokuan[0].tiao.show">
                <i class="el-icon-edit"  style="float:right;color:#20A0FF;display: none;"  @click="editFormVisible(tiaokuan[0].tiao)">编辑</i>
            </a>
        </div>

        <el-input  v-model="tiaokuan[0].kuan1" icon="edit" :on-icon-click="handleIconClick"></el-input>

        <el-input  v-model="tiaokuan[0].kuan2" type="textarea"
                   :on-icon-click="handleIconClick"
        ></el-input>
        <el-input  v-model="tiaokuan[0].xiang" icon="edit" :on-icon-click="handleIconClick"></el-input>
    </div>
</template>
<style>
    .test:hover{
            color: #21b88f;
            background-color:#FCFED5;
    }
    .test:hover>a>i{
        display:inline;
    }
    .tiao{
        font-size: 18px;
        height: 42px;
    }
</style>
<script>
    export default{
        data(){
            return{
                tiaokuan:[
                    {
                        tiao:{
                            content:'第五条 相关费用的承担方式',
                            show:false,
                        },
                        kuan1:'（一）甲方有下列情形之一的，乙方有权单方解除合同：',
                        kuan2:'（一）承租期内，如乙方需要对承租房屋进行装修或改动前应获得甲方书面同意，且装修或改动应符合国家相关法律法规规定以及物业管理规定，但乙方不得拆除、破坏承租区域建筑的主体结构。',
                        xiang:' 1、交付的房屋存在重大安全问题，导致乙方无法正常使用达15个工作日。'}
                ],
            }
        },
        methods:{
            handleIconClick(){
                this.tiaokuan[0].tiao.disabled = !this.tiaokuan[0].tiao.disabled
            },
            editFormVisible(tiao){
                tiao.show=true;
            },
            cancel(tiao){
                tiao.show=false;
            },
            save(){
                //发送条款的ID到后端

            }

        },

    }
</script>