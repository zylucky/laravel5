<template>
    <el-form style="margin-top:2%">
        <el-form-item label="产权人身份证">
            <el-input v-show="false" v-model="form.name"></el-input>
            <br>
            <el-upload
                    action="http://127.0.0.1:8000/test/"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="chanquanrenList"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>

    </el-form>
</template>
<script>
    export default {
        data() {
            return {
                chanquanrenList: [
                    {id:2,name: 'food.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'},
                    {id:3,name: 'food2.jpeg', url: 'https://fuss10.elemecdn.com/3/63/4e7f3a15429bfda99bce42a18cdd1jpeg.jpeg?imageMogr2/thumbnail/360x360/format/webp/quality/100'}
                ],
                dialogImageUrl: '',
                dialogVisible: false,
                form:{
                    name:'',
                },
                headers:{
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                },
                data:{
                    id:null,
                    type:'chanquanren',
                },
            };
        },
        methods: {
            handleRemove(file, fileList) {
                console.log(file.id);
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleSuccess(response, file, fileList){
                //响应值
                console.log(response)
            }
        },
        mounted(){
            this.data.id = this.$route.query.id;
        }


    }
</script>