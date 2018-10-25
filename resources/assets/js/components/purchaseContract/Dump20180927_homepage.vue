<template>
    <div class="large"><br><br><br><br><br><br><br><br>
        <div class="tc">房屋资产管理服务合同</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <div class="jffone">业主方：<input type="text" style="width: 300px" disabled /></div><br><br><br>
        <div class="jffone">管理方：<input type="text" style="width: 300px" disabled /></div><br><br><br>
        <div v-if="farenzhengjian=='s'" class="jffone">居间方：<input type="text" style="width: 300px" disabled /></div><br>
    </div>
</template>
<style>
    body{
        text-align: center;
        height: 100%;
        position: relative;
    }
    .large{
        top: 0;
        right: 0;
        left:0;
        bottom: 0;
        width: 800px;
    }
    .tc{text-align:center;font-size:50px;letter-spacing: 15px;}
    .jffone{font-size:26px;letter-spacing: 10px;}
    h2{
        font-size:50px;
    }
    span {
        display: block;}
    p{
        font-size: 14px; text-align:left;
        line-height: 2;}
    input{border: none;border-bottom: 1px solid#333333;outline: none; font-size: 14px!important;text-align:center}
    u{
        font-size:14px!important;
    }
    input[disabled]{
        background-color:white;
        color:#000000;
    }
</style>
<script>
    import {getPurchaseContractInfo} from '../../api/api';
    export default {
        data(){
            return {
                buchongtiaokuan:null,
                farenzhengjian:null,
                jujianfang:null,
            }
        },
        methods:{
            //根据url得到的合同ID，来获取数据
            getPurchaseContract(id){
                getPurchaseContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //把数据分别赋值给三个组件的变量
                        this.buchongtiaokuan = res.data.data.yingyezhizhao;
                        this.farenzhengjian = res.data.data.farenzhengjian;
                        this.jujianfang = res.data.data.jujianfang;
                    }else {
                        this.$message({
                            message: '获取数据失败',
                            type: 'error'
                        });
                    }
                })
            },
        },
        mounted(){
            this.getPurchaseContract(this.$route.query);
            document.title = "合同编号"+this.$route.query.bianhao;
        }

    }
</script>

