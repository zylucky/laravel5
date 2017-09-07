<template>
    <div>
        <!--列表页-->
        <el-table :data="youhuaList" highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="expand">
                <template scope="props">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <el-form-item label="协议生效时间">
                            <span>{{ changedate(props.row.xieyistartdate)  }}</span>
                        </el-form-item>
                        <el-form-item label="协议结束时间">
                            <span>{{ changedate(props.row.xieyienddate)  }}</span>
                        </el-form-item>
                    </el-form>
                    <el-form label-position="left" inline class="demo-table-expand"
                             v-if="props.row.chanquanrenList[0].name!=null"
                             v-for=" (item,index) in props.row.chanquanrenList"
                             :key="index">
                        <el-form-item label="产权人姓名">
                            <span>{{ item.name }}</span>
                        </el-form-item>
                        <el-form-item label="性别">
                            <span>{{ changeSex(item.sex) }}</span>
                        </el-form-item>
                        <el-form-item label="联系方式" style="width:25%">
                            <span>{{ item.tel }}</span>
                        </el-form-item>
                        <el-form-item label="身份证" style="width:30%">
                            <span>{{ item.zhengjian }}</span>
                        </el-form-item>

                    </el-form>
                    <el-form label-position="left" inline class="demo-table-expand"
                             v-if="props.row.mianzuqiList[0].startdate!=null"
                             v-for=" (item,index) in props.row.mianzuqiList"
                             :key="index">
                        <el-form-item label="免租期开始时间">
                            <span>{{ changedate(item.startdate) }}</span>
                        </el-form-item>
                        <el-form-item label="免租期结束时间">
                            <span>{{ changedate(item.enddate) }}</span>
                        </el-form-item>
                    </el-form>
                    <el-form label-position="left"
                             v-if="props.row.zuqistartdate!=null"
                             inline class="demo-table-expand">
                        <el-form-item label="总租期开始时间">
                            <span>{{ changedate(props.row.zuqistartdate)  }}</span>
                        </el-form-item>
                        <el-form-item label="总租期结束时间">
                            <span>{{ changedate(props.row.zuqienddate)  }}</span>
                        </el-form-item>
                    </el-form>
                    <el-form label-position="left" inline class="demo-table-expand"
                             v-if="props.row.fukuanFangshiList[0].startdate!=null "
                             v-for=" (item,index) in props.row.fukuanFangshiList"
                             :key="index">
                        <el-form-item label="开始时间">
                            <span>{{ changedate(item.startdate)  }}</span>
                        </el-form-item>
                        <el-form-item label="结束时间">
                            <span>{{ changedate(item.enddate)  }}</span>
                        </el-form-item>
                        <el-form-item label="押" style="width:15%">
                            <span>{{ item.yajinyue  }}</span>
                        </el-form-item>
                        <el-form-item label="付" style="width:15%">
                            <span>{{ item.zujinyue  }}</span>
                        </el-form-item>
                    </el-form>
                    <el-form label-position="left" inline class="demo-table-expand"
                             v-if="props.row.zujinList[0].startdate!=null "
                             v-for=" (item,index) in props.row.zujinList"
                             :key="index">
                        <el-form-item label="开始时间">
                            <span>{{ changedate(item.startdate)  }}</span>
                        </el-form-item>
                        <el-form-item label="结束时间">
                            <span>{{ changedate(item.enddate)  }}</span>
                        </el-form-item>
                        <el-form-item label="月租(元)" style="width:20%">
                            <span>{{ item.yuezujin }}</span>
                        </el-form-item>
                        <el-form-item label="单价" style="width:15%">
                            <span>{{ item.price }}</span>
                        </el-form-item>
                        <el-form-item label="递增量" style="width:15%">
                            <span>{{ item.dizengliang }}{{ fangshi(item.dizengfangshi)  }}</span>
                        </el-form-item>
                    </el-form>
                </template>
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="bianhao" label="编号"   sortable>
            </el-table-column>
            <el-table-column prop="loupanName" label="楼盘"   sortable>
            </el-table-column>
            <el-table-column prop="loudongName" label="楼栋"   >
            </el-table-column>
            <el-table-column prop="fanghao" label="房间号" :formatter="fangjia"  >
            </el-table-column>
            <el-table-column prop="createtime" label="优化时间" :formatter="changeDate"   sortable>
            </el-table-column>
        </el-table>
    </div>
</template>

<style>
    .demo-table-expand {
        font-size: 0;
    }
    .demo-table-expand label {
        width: 120px;
        color: #99a9bf;
    }
    .demo-table-expand .el-form-item {
        margin-right: 0;
        margin-bottom: 0;
        width: 20%;
    }
</style>
<script>
    import {buchongSaleContractList} from '../../api/api.js';
    export default{
        data(){
            return {
                youhuaList:[],
                //分页类数据
                total:15,
                currentPage:0,
                pageSize:10,
                pageSizes:[10, 20, 30, 40, 50, 100],
                users:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        methods:{
            fangjia(row, column){
                if(row.subleaseno == null){
                    //console.log(row.fanghao);
                    return  row.fanghao;
                }else{
                    return  row.fanghao+"-"+row.subleaseno;//在这里面拼接数据的时候，在js中拼接
                }
            },
            fangshi(fangshi){
                return fangshi==1?'%':'元';
            },
            changeSex(sex){
                if(sex==1){
                    return '男';
                }else if(sex==2){
                    return '女';
                }else {
                    return '';
                }
            },
            getList(){
                buchongSaleContractList(this.$route.query).then((res)=>{
                    //alert(22);
                    this.youhuaList = res.data.data;
                    this.total = res.total;
                    //console.log(this.$route.query);
                    console.log(res.data.data);
                });
            },
            handleView(index,row){
                this.$router.push('/saleContract/checkBuchong?id='+row.id+'&type=1');//查看
            },
            //页面跳转后
            handleCurrentChange(val) {
                this.page = val;
                this.getList();
            },
            //更改每页显示数据
            handleSizeChange(val){
                this.pageSize =val;
                this.getList();
            },
            //时间戳转日期格式
            changeDate(row, column){
                var newDate = new Date();
                newDate.setTime(row.createtime);
                if(row.createtime!=null){
                    return newDate.toLocaleDateString()
                }
            },
            //转化日期格式
            changedate(time){
                var newDate = new Date();
                newDate.setTime(time);
                if(time!=null){
                    return newDate.toLocaleDateString()
                }
            },
            selsChange: function (sels) {
                this.sels = sels;
            },

        },
        mounted(){
            this.getList();
        }
    }
</script>