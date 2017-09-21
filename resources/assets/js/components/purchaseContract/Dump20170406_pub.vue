<template>
    <div class="whole">
        <p>
            <b>&nbsp;&nbsp;第十四条  补充条款</b> <br>
            &nbsp; 以下条款内容与本合同其它各条款具备同等法律效力,若补充条款与本合同不一致或发生冲突时，应以补充条款为准。<br>

            <input v-if="buchongtiaokuan==null||yingyezhizhao==''" type="text" name="" disabled style="width:600px;" value="以下空白">
            <br><br>

            <b> 业主方（甲方）：<input type="text" name="" style="width:119px;font-size:10px" value="">&nbsp;&nbsp;管理方（乙方）：<input type="text" name="" style="width:119px;font-size:10px" value=""></b>　<br>
            <b>委托代理人：<input type="text" name="" style="width:160px;font-size:10px" value=""></b><br>
            联系地址：<input type="text" name="" style="width:180px;font-size:10px" value="">&nbsp;&nbsp;联系地址：<input type="text" name="" style="width:185px" value="">
            <br>联系方式：<input type="text" name="" style="width:180px;" disabled value="">&nbsp;&nbsp;联系方式：<input type="text" name="" style="width:185px;font-size:10px" value=""><br>
            <font>_______年____月____日</font>
            <font style="margin-left: 6%" >_______年____月____日</font><br>
            <br>
            <p v-if="farenzhengjian=='s'">
                <b> 居间方（丙方）：<input type="text" name="" style="width:119px;font-size:10px" value=""></b><br>
                房地产经纪人：<input type="text" name="" style="width:140px;font-size:10px" value="">
                <br>资质证书号：<input type="text" name="" style="width:160px;font-size:10px" value="">
                <br>联系地址：<input type="text" name="" style="width:180px;font-size:10px" value="">
                <br>联系方式：<input type="text" name="" style="width:180px;font-size:10px" value=""><br>
                <font></font>
            </p>
        </p>
    </div>
</template>

<style>
    .whole{
        position: absolute;
        margin: auto;
        top: -650px;
        right: 0;
        left:0;
        bottom: 0;
        width: 85%;
        height: 20%;
    }
    .whole h1{
        font-size:40px;
    }
    .whole span {
        display: block;}
    .f22{
        font-size: 20px;
    }
    .whole p{
        font-size: 20px; text-align:left;
        line-height: 2;}
    .whole input{border: none;border-bottom: 1px solid#333333;outline: none; font-size: 20px!important;text-align:center}
    .whole u{
        font-size:20px!important;
    }
    .whole input[disabled]{
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
            document.title = '华亮房产 -- 先锋地产机构、专业人、信誉人';
        }

    }
</script>
