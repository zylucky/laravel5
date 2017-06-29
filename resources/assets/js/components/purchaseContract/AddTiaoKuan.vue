<template>
    <div>
        <div  v-for="(tiao, index) in tiaoList"
             :key="tiao.index"
        >
            <el-row :gutter="5" class="txs">
                <!--条编辑-->
                <el-col :span="20">
                    <el-input  style="font-size:18px" size="large" v-show="tiao.show" v-model="tiao.title"></el-input>
                </el-col>
                <el-col :span="4" >
                    <el-button type="info" v-show="tiao.show" @click="save(tiao)">保存</el-button>
                    <el-button type="info" :plain="true" v-show="tiao.show" @click="cancel(tiao)">取消</el-button>
                </el-col>
                <!--条展示-->
                <span class="tiao" v-show="!tiao.show">{{tiao.title}}</span>
                <a  href="javascript:;" class="bjxs" v-show="!tiao.show">
                    <i class="el-icon-edit"    @click="editFormVisible(tiao)">编辑</i>
                </a>
            </el-row>
            <br>

            <div v-for="(kuan,index2) in tiao.kuanList"
                 :key="kuan.index2"
            >
                <el-row :gutter="5" class="txs kuan">
                    <!--款编辑-->
                    <el-col :span="20">
                        <el-input   type="textarea"
                                   autosize v-show="kuan.show" v-model="kuan.content"></el-input>
                    </el-col>
                    <el-col :span="4" >
                        <el-button type="info" v-show="kuan.show" @click="save(kuan)">保存</el-button>
                        <el-button type="info" :plain="true" v-show="kuan.show" @click="cancel(kuan)">取消</el-button>
                    </el-col>
                    <!--款展示-->
                    <span class="kuan" v-show="!kuan.show">{{kuan.content}}</span>
                    <a  href="javascript:;" class="bjxs"  v-show="!kuan.show">
                        <i class="el-icon-edit"  @click="editFormVisible(kuan)">编辑</i>
                    </a>
                </el-row>
                <div
                        v-for="(xiang,index3) in kuan.xiangList"
                        :key="xiang.index3"
                >
                    <el-row :gutter="5" class="txs xiang">
                        <!--款编辑-->
                        <el-col :span="20">
                            <el-input  type="textarea"
                                       autosize v-show="xiang.show" v-model="xiang.content"></el-input>
                        </el-col>
                        <el-col :span="4" >
                            <el-button type="info" v-show="xiang.show" @click="save(xiang)">保存</el-button>
                            <el-button type="info" :plain="true" v-show="xiang.show" @click="cancel(xiang)">取消</el-button>
                        </el-col>
                        <!--款展示-->
                        <span class="xiang" v-show="!xiang.show">{{xiang.content}}</span>
                        <a  href="javascript:;" class="bjxs"  v-show="!xiang.show">
                            <i class="el-icon-edit"   @click="editFormVisible(xiang)">编辑</i>
                        </a>
                    </el-row>
                </div>
            </div>
            <br>
        </div>
    </div>
</template>
<style>
    .txs:hover{
            color: #20A0FF;
            background-color:#FCFED5;
    }
    .txs:hover > .bjxs{
        display:inline;
    }
    .bjxs{
        float:right;
        color:#20A0FF;
        display: none;
    }
    .tiao{
        font-size: 20px;
        height: 42px;
        font-weight:bold;
    }
    .kuan{
        font-size: 16px;
    }
    .xiang{
        font-size: 16px;
    }
</style>
<script>
    export default{
        data(){
            return{
            }
        },
        props:['tiaoList'],
        methods:{
            editFormVisible(tiao){
                tiao.show=true;
            },
            cancel(tiao){
                tiao.show=false;
            },
            save(tiao){
                //发送条款的ID到后端
                console.log(tiao)
            }

        },
        mounted(){
            //console.log(this.tiaoList)
        }

    }
</script>