<template>
    <el-form style="margin-top:2%" :model="copyForm">
        <el-form-item label="合同">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.hetongList">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=1"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="hetongList"
                    :before-upload="beforeAvatarUpload"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <el-form-item label="承租人身份证">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.chengzuren">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=2"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="chengzuren"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <el-form-item label="营业执照">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.yingyezhizhao">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=3"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="yingyezhizhao"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <el-form-item label="法人证件">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.faren">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=4"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="faren"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <el-form-item label="承租人授权代理人委托书">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.chengzurenshouquan">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=5"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="chengzurenshouquan"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <el-form-item label="委托人身份证">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.weituoren">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=6"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="weituoren"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <el-form-item label="房屋交割单">
            <el-form-item label="" prop="" >
                <el-radio-group v-model="copyForm.jiaogedan">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="2">不全</el-radio>
                </el-radio-group>
            </el-form-item>
            <br>
            <el-upload
                    action="/saleContract/addCopyImage?type=7"
                    list-type="picture-card"
                    :headers="headers"
                    :data="data"
                    multiple
                    :on-preview="handlePictureCardPreview"
                    :on-remove="handleRemove"
                    :on-success="handleSuccess"
                    :file-list="jiaogedan"
            >
                <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog v-model="dialogVisible" size="tiny">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </el-form-item>
        <div style="position: fixed;right:10%;top:50%;">
            <el-button type="primary"   @click="save" style="margin-top:100px;">保存</el-button>
            <el-button type="warning"   @click="cansel" style="margin-top:100px;">取消</el-button>
        </div>
    </el-form>
</template>
<script>
    import {
        copySaleImageList,
        copySaleImageDelete,
        isCopySaleComplete,
    } from  '../../api/api';
    export default {
        data() {
            return {
                copyForm:{
                    hetongList:null,
                    chengzuren: null,
                    yingyezhizhao:null,
                    faren:null,
                    chengzurenshouquan:null,
                    weituoren:null,
                    jiaogedan:null,
                },
                hetongList:[],
                chengzuren: [],
                yingyezhizhao:[],
                faren:[],
                chengzurenshouquan:[],
                weituoren:[],
                jiaogedan:[],
                dialogImageUrl: [],
                dialogVisible: false,
                form:{
                    name:[],
                },
                headers:{
                    'X-CSRF-TOKEN':window.Laravel.csrfToken
                },
                data:{
                    id:null,
                },
            };
        },
        methods: {
            save(){
                let para = Object.assign({}, this.copyForm);
                isCopyComplete().then();
            },
            cansel(){},
            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isJPG) {
                    this.$message.error('上传头像图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            handleRemove(file, fileList) {
                let para ={
                    id :file.id,
                }
                copySaleImageDelete(para).then((res)=>{

                });
                //console.log(file.id);
            },
            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;
            },
            handleSuccess(response, file, fileList){
                //响应值
                console.log(response)
            },
            getCopyImageList(){
                let para = {
                    id:this.$route.query.id
                }
                copySaleImageList(para).then((res)=>{
                    if(res.data.code=='200'){
                        this.hetongList = res.data.data[1];//合同
                        this.chengzuren = res.data.data[2];//合同
                        this.yingyezhizhao = res.data.data[3];//合同
                        this.faren  = res.data.data[4];//合同
                        this.chengzurenshouquan = res.data.data[5];//合同
                        this.weituoren = res.data.data[6];//合同
                        this.jiaogedan = res.data.data[7];//合同
                    }
                })
            },
        },
        mounted(){
            this.data.id = this.$route.query.id;
            this.getCopyImageList();
        }
    }
</script>