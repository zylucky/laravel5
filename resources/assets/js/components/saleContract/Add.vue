<template>
    <div>
        <el-row>
            <div style="margin-bottom: 50px;"></div>
            <el-col :span="18">
                <add-property ref="property" v-show="stepNum==1"></add-property>
                <add-renter ref="owner" v-show="stepNum==2"></add-renter>
                <add-date ref="date" v-show="stepNum==3"></add-date>
            </el-col>
            <div style="margin-bottom:81px;"></div>
            <el-col :span="6">
                <div style="margin-left: 50%;">
                <el-steps :space="100" direction="vertical" :active="stepNum">
                    <a href="javascript:;" @click="stepNum=1"><el-step  title="房间信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=2"><el-step  title="租户信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=3"><el-step  title="租期信息"></el-step></a>
                    <a href="javascript:;" @click="stepNum=4"><el-step  title="条款信息"></el-step></a>
                </el-steps>
                <el-button type="primary" @click="save" style="margin-top:100px;">保存</el-button>
                </div>
            </el-col>
        </el-row>

    </div>
</template>
<script>
    import AddProperty from './AddProperty.vue'
    import AddRenter from './AddRenter.vue'
    import AddDate from './AddDate.vue'
    import {addPurchaseContractInfo} from '../../api/api';
    export default{
        data(){
            return {
                stepNum:2,
            }
        },
        components:{
            AddProperty,
            AddRenter,
            AddDate,
        },
        methods:{
            save:function () {
                    var child_property = this.$refs.property.property;
                    var child_owner  = this.$refs.owner.owner;
                    var child_date = this.$refs.date.addDate;

                    let para = Object.assign({}, child_property,child_owner,child_date);
                    addPurchaseContractInfo(para).then((res) => {

                        if(res.data.code == 200)　{
                            this.$message({
                                message: '保存成功',
                                type: 'success'
                            });
                        }

                    });
            }
        },
        mounted() {

        },

    }
</script>