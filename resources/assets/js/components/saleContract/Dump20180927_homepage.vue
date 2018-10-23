<template>
    <!--<div class="large"><br><br><br><br><br><br><br><br>-->
        <!--<div class="tc">北京市房屋租赁合同</div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
        <!--<div class="jffone">甲方：<input type="text" style="width: 300px" disabled /></div><br><br><br>-->
        <!--<div class="jffone">乙方：<input type="text" style="width: 300px" disabled /></div><br><br><br>-->
        <!--<div v-if="hetongtype==2" class="jffone">丙方：<input type="text" style="width: 300px" disabled /></div><br>-->
    <!--</div>-->
    <div class="big_box">
        <ul id="img_box">
            <li v-for="(item,index) in imgArr">
                <img :src="item" alt="">
            </li>
        </ul>
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


    #img_box{
        display: flex;
    }
    #img_box li{
        width: 146px;
        height: 146px;
        border-radius: 5px;
        overflow: hidden;
        margin-right: 10px;
    }
    #img_box li img{
        width: 100%;
        height: 100%;
    }
</style>
<script>
    import Viewer from 'viewerjs';
    import '../../../../../node_modules/viewerjs/dist/viewer.min.css';
    import {getSaleContractInfo} from '../../api/api';
    export default {
        data(){
            return {
                buchongtiaokuan:null,
                hetongtype:null,
                imgArr:[
                    'http://116.62.68.26/upload/2018-10-18/072b63012cd8e23b5cf70c84fd8a62a5.jpeg',
                    'http://116.62.68.26/upload/2018-10-18/b052165834e427615e2f6303e4ae6561.jpeg',
                    'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1538987750397&di=106be7a370b48812e9e7ed19e9c8eb16&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimage%2Fc0%253Dpixel_huitu%252C0%252C0%252C294%252C40%2Fsign%3D896dc4cbde62853586edda61f99713aa%2Fd009b3de9c82d158de82e7888b0a19d8bc3e4282.jpg',
                    'http://116.62.68.26/upload/2018-10-18/072b63012cd8e23b5cf70c84fd8a62a5.jpeg',
                    'http://116.62.68.26/upload/2018-10-18/b052165834e427615e2f6303e4ae6561.jpeg',
                    'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1538987750397&di=106be7a370b48812e9e7ed19e9c8eb16&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fimage%2Fc0%253Dpixel_huitu%252C0%252C0%252C294%252C40%2Fsign%3D896dc4cbde62853586edda61f99713aa%2Fd009b3de9c82d158de82e7888b0a19d8bc3e4282.jpg'
                ]
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
            document.title = '合同编号：'+this.$route.query.bianhao;
            function  hello() {
                window.print()
            }
            if(this.$route.query.isdump==1){
                setTimeout(hello,1000);
            }
            const ViewerDom = document.getElementById('img_box');
            const viewer = new Viewer(ViewerDom, {
                // 配置
            })
        }

    }
</script>

