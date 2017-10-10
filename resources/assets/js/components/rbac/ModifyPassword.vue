<template>
    <section>
            <el-form :model="editForm" label-width="120px" :rules="editFormRules" ref="editForm">
             <el-col :span="8">
                <el-form-item label="旧密码" prop="oldpassword">
                    <el-input type="password" v-model="editForm.oldpassword" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="新密码" prop="newpassword">
                    <el-input type="password" v-model="editForm.newpassword" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="确认密码" prop="surepassword">
                    <el-input type="password" v-model="editForm.surepassword" auto-complete="off"></el-input>
                </el-form-item>
                </el-col>
            </el-form>

            <div slot="footer" class="dialog-footer" style="clear: both">
                <el-button type="primary" @click.native="editSubmit"  >提交</el-button>
            </div>
    </section>
</template>
<script>
    import { setPassword,checkPassword} from '../../api/api';
    export default{
        data(){
            return {

                editFormRules: {
                    oldpassword: [
                        { required: true, message: '不能为空', trigger: 'blur' },
                        {required: true,validator:this.checkPass, trigger:'blur'  }
                    ],
                    newpassword:[
                        { required: true, message:'不能为空',trigger:'blur' },
                        {
                            validator: (rule, value, callback) => {
                                if (value != ''&&value != null&&this.editForm.surepassword!=''&&this.editForm.surepassword!=null) {
                                    if ( value != this.editForm.surepassword ) {
                                        callback(new Error("两次输入的密码不一致"));
                                    } else {
                                        callback();
                                    }
                                } else {
                                    callback();
                                }
                            }, trigger: 'blur'
                        }
                    ],
                    surepassword:[
                        { required: true, message:'不能为空',trigger:'blur' },
                        {
                            validator: (rule, value, callback) => {
                                if (value != ''&&value != null&&this.editForm.newpassword!=''&&this.editForm.newpassword!=null) {
                                    if ( value != this.editForm.newpassword) {
                                        callback(new Error("两次输入的密码不一致"));
                                    } else {
                                        callback();
                                    }
                                } else {
                                    callback();
                                }
                            }, trigger: 'blur'
                        }
                    ],

                },
                //编辑界面数据
                editForm: {
                    oldpassword: '',
                    newpassword: '',
                    surepassword: '',
                },

            }
        },
        methods: {
            checkPass(rule,value,callback){
                let para = {
                    oldPassword: this.editForm.oldpassword
                };
                checkPassword(para).then((res) => {
                    console.log(res);
                   if (res.data==2){
                       callback("原密码错误，请重新输入");
                   }else{
                       callback();
                   };
                });
            },

            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            let para = Object.assign({}, this.editForm);
                            setPassword(para).then((res) => {
                                this.$message({
                                    message: '保存成功',
                                    type: 'success'
                                });

                            });
                        });
                    }
                });
            },
        },

    }
</script>