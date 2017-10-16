<template>
    <div>
        <p>
            <b>&nbsp;&nbsp;第十二条  补充条款</b> <br>
            &nbsp; 以下条款内容与本合同其它各条款具备同等法律效力,若补充条款与本合同不一致或发生冲突时，应以补充条款为准。<br>
            <u>{{buchongtiaokuan}}</u>
            <br>
            <input v-if="buchongtiaokuan==null||iscompletefrzj==''" type="text" name="" disabled style="width:600px;" value="以下空白">
            <br><br>

            <b> 出租人（甲方）：<input type="text" name="" style="width:138px;font-size:10px" value="">承租人（乙方）：<input type="text" name="" style="width:143px;font-size:10px" value=""></b>　<br>
            联系地址：<input type="text" name="" style="width:180px;font-size:10px" value="">联系地址：<input type="text" name="" style="width:185px" value="">
            <br>联系方式：<input type="text" name="" style="width:180px;" disabled value="400-078-8800">联系方式：<input type="text" name="" style="width:185px;font-size:10px" value="">
            <br>委托代理人 ：<input type="text" name="" style="width:160px;font-size:10px" value="">委托代理人：<input type="text" name="" style="width:165px;font-size:10px" value=""><br>

            <font>_______年____月____日</font>&nbsp;&nbsp;
            <font style="margin-left: 93px;" >_______年____月____日</font><br>
            <br>
        <p v-if="hetongtype==2">
            <b> 居间方（丙方）：<input type="text" name="" style="width:135px;font-size:10px" value=""></b><br>
            房地产经纪人：<input type="text" name="" style="width:149px;font-size:10px" value="">
            <br>资质证书号：<input type="text" name="" style="width:162px;font-size:10px" value="">
            <br>联系地址：<input type="text" name="" style="width:176px;font-size:10px" value="">
            <br>联系方式：<input type="text" name="" style="width:176px;font-size:10px" value=""><br>
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
        margin: auto;
        top: 0;
        right: 0;
        left:0;
        bottom: 0;
        width: 90%;
        height: 20%;
    }
    .tc{text-align:center;}
    h1{
        font-size:28px;
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
    import {getSaleContractInfo} from '../../api/api';
    export default {
        data(){
            return {
                buchongtiaokuan:null,
                hetongtype:null,
            }
        },
        methods:{
            //根据url得到的合同ID，来获取数据
            getSaleContract(id){
                getSaleContractInfo(id).then((res)=>{
                    if(res.data.code=='200'){
                        //把数据分别赋值给三个组件的变量
                        this.buchongtiaokuan = res.data.data.jiafangfeiyong;
                        this.hetongtype = res.data.data.hetongtype;
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
            document.title = '北京幼狮科技有限公司 -- 为梦想、造支点 - - - - - - -  合同编号：'+this.$route.query.bianhao;
            function  hello() {
                window.print()
            }
            if(this.$route.query.isdump==1){
                setTimeout(hello,1000);
            }
        }

    }
</script>

