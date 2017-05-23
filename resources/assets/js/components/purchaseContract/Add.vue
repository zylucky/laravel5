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
                <el-steps :space="100" direction="vertical" :active="stepNum" style="margin-left: 50%;">
                    <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=2"><el-step  title="业主信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=3"><el-step  title="租期信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=4"><el-step  title="签约信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=5"><el-step  title="条款信息"></el-step></a>
                </el-steps>
            </el-col>
        </el-row>

    </div>
</template>
<script>
    import AddProperty from './AddProperty.vue'
    import AddOwner from './AddOwner.vue'
    export default{
        data(){
            return {
                stepNum:1
            }
        },
        components:{
            AddProperty,
            AddOwner,
        },
        methods:{

        }

    }
</script>