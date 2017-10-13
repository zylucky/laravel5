<template>
    <el-form ref="form" :model="agreement" label-width="80px">
        <el-form-item label="活动名称">
            <el-input v-model="agreement.name"></el-input>
        </el-form-item>
    </el-form>
</template>
<style>

</style>
<script>
    export default{
        data(){
            return {
                agreement:{},
            }
        }
    }
</script>