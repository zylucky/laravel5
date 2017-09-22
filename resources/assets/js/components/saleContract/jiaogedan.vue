<template>
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