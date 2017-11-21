<template>
    <el-form style="margin-top:2%" :model="copyForm" ref="copyForm" :rules="copyRules" label-position="top">
        <el-form-item label="合同" prop="iscompletehetong" >
            <el-radio-group v-model="copyForm.iscompletehetong">
                <el-radio :label="1">全</el-radio>
                <el-radio :label="0">不全</el-radio>
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
        <el-dialog v-model="dialogVisible" size="large">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
        <div v-if="zuhuleixing==1">
            <el-form-item label="承租人身份证" prop="" >
                <el-radio-group v-model="copyForm.iscompleteczrzj">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="0">不全</el-radio>
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
            <el-dialog v-model="dialogVisible" size="large">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </div>
        <div v-if="zuhuleixing==2">
            <el-form-item label="营业执照" prop="" >
                <el-radio-group v-model="copyForm.iscompleteyyzz">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="0">不全</el-radio>
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
            <el-dialog v-model="dialogVisible" size="large">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </div>
        <div v-if="zuhuleixing==2">
            <el-form-item label="法人证件" prop="" >
                <el-radio-group v-model="copyForm.iscompletefrzj">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="0">不全</el-radio>
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
            <el-dialog v-model="dialogVisible" size="large">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
        </div>
            <el-form-item label="承租人授权代理人委托书" prop="" >
                <el-radio-group v-model="copyForm.iscompleteczrsqdlrwts">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="0">不全</el-radio>
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
            <el-dialog v-model="dialogVisible" size="large">
                <img width="100%" :src="dialogImageUrl" alt="">
            </el-dialog>
            <el-form-item label="委托人身份证" prop="" >
                <el-radio-group v-model="copyForm.iscompletewtrsfz">
                    <el-radio :label="1">全</el-radio>
                    <el-radio :label="0">不全</el-radio>
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
        isCopySaleCompleteList,
        getSaleContractInfo,
    } from  '../../api/api';
    export default {
        data() {
            return {
                copyRules:{
                    iscompletehetong: [
                        { required: true, message: '不能为空' }
                    ],
                },
                copyForm:{
                    iscompletehetong:null,
                    iscompleteczrzj: null,
                    iscompleteyyzz:null,
                    iscompletefrzj:null,
                    iscompleteczrsqdlrwts:null,
                    iscompletewtrsfz:null,
                    iscompletefwjgd:null,
                },
                hetongList:[],
                chengzuren: [],
                yingyezhizhao:[],
                faren:[],
                chengzurenshouquan:[],
                weituoren:[],
                jiaogedan:[],
                zuhuleixing:null,
                dialogImageUrl: [],
                dialogVisible: false,
                /*form:{
                    name:[],
                },*/
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
                this.$refs.copyForm.validate((valid) => {
                    if(valid){
                        let para = Object.assign({}, this.copyForm,{id:parseInt(this.$route.query.id)});
                        isCopySaleComplete(para).then((res)=>{
                            if(res.data.code=='200'){
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });
                            }else{
                                this.$message({
                                    message: res.data.msg,
                                    type: 'error'
                                });
                            }

                        });
                    }
                });


            },
            cansel(){
                history.go(-1);
            },
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
                this.$confirm('确认删除吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    let para ={
                        id :file.id,
                    }
                    copySaleImageDelete(para).then((res)=>{});
                })

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
                        this.chengzuren = res.data.data[2];//承租人
                        this.yingyezhizhao = res.data.data[3];//营业支招
                        this.faren  = res.data.data[4];//法人证件
                        this.chengzurenshouquan = res.data.data[5];//承租人授权
                        this.weituoren = res.data.data[6];//委托人
                        this.jiaogedan = res.data.data[9];//交割单
                    }
                })
            },
        },
        mounted(){
            this.data.id = this.$route.query.id;
            getSaleContractInfo(this.$route.query).then((res)=>{
                //查数据，得租户leixing（得到租户类型就可以判断营业执照显不显示）
                this.zuhuleixing = res.data.data.zuhuleixing;
            }),
            isCopySaleCompleteList(this.$route.query).then((res)=>{
                //查数据，得租户leixing
                this.copyForm = res.data.data;
            })
            this.getCopyImageList();
        }
    }
</script>