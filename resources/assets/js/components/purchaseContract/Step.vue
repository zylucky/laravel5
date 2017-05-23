<template>
    <el-steps :space="100" direction="vertical" :active="stepNum" style="margin-left: 50%;">
        <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
        <a href="javascript:;" @click="stepNum=2"><el-step  title="业主信息"></el-step></a>
        <a href="javascript:;" @click="stepNum=3"><el-step  title="租期信息"></el-step></a>
        <a href="javascript:;" @click="stepNum=4"><el-step  title="签约信息"></el-step></a>
        <a href="javascript:;" @click="stepNum=5"><el-step  title="条款信息"></el-step></a>
    </el-steps>
</template>
<script>
    export default{
        props:['stepNum'],
        data(){
          return {
              stepNum:0,
          }
        },
        methods:{
            changeNum2(){
                this.$emit('changeNum2')
            }
        }
    }
</script>