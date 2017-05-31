<template>
    <div>
        <el-row>
            <div style="margin-bottom: 50px;"></div>
            <el-col :span="15">
                <add-property ref="property" v-show="stepNum==1"></add-property>
                <add-owner ref="owner" v-show="stepNum==2"></add-owner>
                <add-date ref="date" v-show="stepNum==3"></add-date>
            </el-col>
            <div style="margin-bottom:81px;"></div>
            <el-col :span="6">
                <div style="margin-left: 50%;">
                <el-steps :space="100" direction="vertical" :active="stepNum">
                    <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=2"><el-step  title="业主信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=3"><el-step  title="租期信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=4"><el-step  title="条款信息"></el-step></a>
                </el-steps>
                <el-button type="info" @click="save" style="margin-top:100px;">保存</el-button>
                </div>
            </el-col>
        </el-row>

    </div>
</template>
<script>
    import AddProperty from './AddProperty.vue'
    import AddOwner from './AddOwner.vue'
    import AddDate from './AddDate.vue'
    export default{
        data(){
            return {
                stepNum:1
            }
        },
        components:{
            AddProperty,
            AddOwner,
            AddDate,
        },
        methods:{
            save(){
                if(this.stepNum==1){
                    var child = this.$refs.property.property;
                }else if(this.stepNum==2){
                    var child = this.$refs.owner.owner;
                }else if(this.stepNum==3){
                    var child = this.$refs.date.addDate;
                }
                console.log(child)
                this.$message({
                    message: '保存成功',
                    type: 'success'
                });
            }
        },
        mounted() {

        },

    }
</script>