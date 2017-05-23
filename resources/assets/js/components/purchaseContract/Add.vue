<template>
    <div>
        <el-row>
            <div style="margin-bottom: 50px;"></div>
            <el-col :span="12">
                <add-property v-if="stepNum==1"></add-property>
                <add-owner v-if="stepNum==2"></add-owner>
            </el-col>
            <div style="margin-bottom:81px;"></div>
            <el-col :span="6">
                <step :stepNum="stepNum" v-on:changeNum2="changeNum"></step>
            </el-col>
        </el-row>

    </div>
</template>
<script>
    import AddProperty from './AddProperty.vue'
    import AddOwner from './AddOwner.vue'
    import Step from './Step.vue'
    export default{
        data(){
            return {
                stepNum:1
            }
        },
        components:{
            AddProperty,
            AddOwner,
            Step
        },
        methods:{
            changeNum(){
                console.log(stepNum);
            }
        }

    }
</script>