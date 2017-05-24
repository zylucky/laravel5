
<template>
    <el-row >
        <div style="margin-top:30px"></div>
        <el-form :inline="true" :model="formInline" class="demo-form-inline">
            <el-form-item label="">
                <el-input v-model="formInline.user" placeholder="请输入项目"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" icon="search">搜索</el-button>
                <el-button type="primary" class="el-icon-plus" @click="onSubmit"> 新增</el-button>
                <el-button type="primary" class="el-icon-upload2" @click="uploadImg">上传</el-button>
            </el-form-item>
        </el-form>
        <el-table  highlight-current-row v-loading="listLoading" element-loading-text="拼命加载中" @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="" label="签约日期"  sortable>
            </el-table-column>
            <el-table-column prop="" label="房间"  :formatter="formatSex" sortable>
            </el-table-column>
            <el-table-column prop="" label="地址"  sortable>
            </el-table-column>
            <el-table-column prop="" label="标签"  sortable>
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div style="margin-top:30px"></div>
        <!-- 分页-->
        <el-col :span="24" class="toolbar" >
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[10, 20, 50, 100]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total=total
                    style="float:right"
            >
            </el-pagination>
        </el-col>
    </el-row>
</template>
<script>
    export default {
        data() {
            return {
                formInline: {
                    user: '',
                    region: ''
                },
                //分页类数据
                total:10000,
                currentPage:0,
                pageSize:10,
                users:[],
                listLoading: false,
                sels: [],//列表选中列
            }
        },
        methods: {
            onSubmit() {
                var _this = this;
                _this.$router.push('/purchaseContact/add');
            },
            uploadImg(){
                var _this = this;
                _this.$router.push('/purchaseContact/upload');
            },
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            }
        }
    }
</script>
