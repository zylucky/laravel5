<template>
    <el-form ref="form" :model="agreement" label-width="80px">
        <el-row>
            <el-col :span="12">
                <el-form-item label="活动名称">
                    <el-input v-model="agreement.name"></el-input>
                </el-form-item>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="8">
                <el-form-item label="楼盘" required prop="loupanName">
                    <el-select
                            v-model="property.officeList[index].loupanName"
                            filterable
                            default-first-option
                            remote
                            @change="change1"
                            placeholder="楼盘"
                            :remote-method="remoteMethod1"
                            :loading="loupanloading"
                            :disabled="lydisabled"
                    >
                        <el-option
                                v-for="item in options1"
                                :key="item.value"
                                :label="item.label"
                                :value="item.label">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="8">
                <el-form-item required label="楼栋" prop="loudongName" >
                    <el-select
                            v-model="property.officeList[index].loudongName"
                            filterable
                            default-first-option
                            remote
                            @change="change2"
                            placeholder="楼栋"
                            :remote-method="remoteMethod2"
                            :loading="loupanloading"
                            :disabled="lydisabled"

                    >
                        <el-option
                                v-for="item in options2"
                                :key="item.value"
                                :label="item.label"
                                :value="item.label">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
            <el-col :span="8">
                <el-form-item required label="房间号" prop="fanghao">
                    <el-select
                            v-model="property.officeList[index].fanghao"
                            filterable
                            allow-create
                            default-first-option
                            remote
                            @change="change3"
                            :placeholder="gzys"
                            :remote-method="remoteMethod3"
                            :loading="fanghaoloading"
                            :disabled="lydisabled"
                    >
                        <el-option
                                v-for="item in options3"
                                :key="item.value"
                                :label="item.label"
                                :value="item.label">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-col>
        </el-row>


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