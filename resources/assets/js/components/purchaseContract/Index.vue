<template>
    <el-button type="primary" class="el-icon-plus" @click="onSubmit"> 新增</el-button>
</template>
<script>
    export default {
        data() {
            return {
                formInline: {
                    user: '',
                    region: ''
                }
            }
        },
        methods: {
            onSubmit() {
                var _this = this;
                _this.$router.push('/purchaseContact/add');
            }
        }
    }
</script>

