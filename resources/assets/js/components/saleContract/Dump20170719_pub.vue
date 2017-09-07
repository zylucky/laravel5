<template>
    <div>
        <p>
            <!--<b>&nbsp;&nbsp;第十二条  补充条款</b> <br>
            &nbsp; 以下条款内容与本合同其它各条款具备同等法律效力,若补充条款与本合同不一致或发生冲突时，应以补充条款为准。<br>
            <u>{{addDate.iscompletefrzj}}</u>
            <br>-->
           <!-- <input type="text" name="" disabled style="width:600px;" value="以下空白">-->
            <br><br>

            <b> 业主方（甲方）：<input type="text" name="" style="width:265px;font-size:10px" value="">&nbsp;&nbsp;<font style="margin-left: 150px;">管理方（乙方）：</font> <input type="text" name="" style="width:119px;font-size:10px" value=""></b>　<br>
            <b>委托代理人：<input type="text" name="" style="width:305px;font-size:10px" value=""></b><br>
            联系地址：<input type="text" name="" style="width:320px;font-size:10px" value="">&nbsp;&nbsp;<font style="margin-left: 150px;">联系地址：</font><input type="text" name="" style="width:320px" value="">
            <br>联系方式：<input type="text" name="" style="width:320px;" disabled value="">&nbsp;&nbsp;<font style="margin-left: 150px;">联系方式：</font><input type="text" name="" style="width:320px;font-size:10px" value=""><br>
            <font>_______年____月____日</font>&nbsp;&nbsp;
            <font style="margin-left: 150px" >_______年____月____日</font><br>
            <br>
            <b> 居间方（丙方）：</b><u>北京华亮房地产经纪有限公司</u>
            <br>联系地址：<input type="text" name="" style="width:315px;font-size:10px" value="">
            <br>联系方式：<input type="text" name="" style="width:315px;font-size:10px" value=""><br>
            <font>_______年____月____日</font>
        </p>
    </div>
</template>
<style>
    body{
        text-align: center;
        height: 100%;
        position: relative;
    }
    div{
        position: absolute;
        margin: auto;
        top: 0;
        right: 0;
        left:0;
        bottom: 0;
        width: 85%;
        height: 20%;
    }
    .tc{text-align:center;}
    h1{
        font-size:40px;
    }
    span {
        display: block;}
    .f22{
        font-size: 20px;
    }
    p{
        font-size: 20px; text-align:left;
        line-height: 2;}
    input{border: none;border-bottom: 1px solid#333333;outline: none; font-size: 20px!important;text-align:center}
    u{
        font-size:20px!important;
    }
    input[disabled]{
        background-color:white;
        color:#000000;
    }
</style>
<script>
    import {getSaleContractInfo} from '../../api/api';
    export default {
        data(){
            return {
                buchongtiaokuan:null,
            }
        },
        methods:{
            //根据url得到的合同ID，来获取数据
            getSaleContract(id){
                getSaleContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //把数据分别赋值给三个组件的变量
                        this.buchongtiaokuan = res.data.data.yingyezhizhao;
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
            this.getSaleContract(this.$route.query);
            document.title = '华亮房产 -- 先锋地产机构、专业人、信誉人';
            function  hello() {
                window.print()
            }
            if(this.$route.query.isdump==1){
                setTimeout(hello,1000);
            }
        }

    }
</script>

