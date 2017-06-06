<template>
    <div>
    <el-row class="container">
            <el-tabs v-model="editableTabsValue2" type="card" closable @tab-remove="removeTab">
                <el-button
                        size="small"
                        @click="addTab(editableTabsValue2)"
                >
                    添加房源
                </el-button>
                <el-tab-pane
                        v-for="(item, index) in editableTabs2"
                        :key="item.name"
                        :label="item.title"
                        :name="item.name"
                >
                    <el-form :label-position="labelPosition" label-width="100px" :model="property[index]">
                        <el-col :span="24">
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="楼盘" >
                                        <el-input v-model="property[index].loupan"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="楼栋" >
                                        <el-input v-model="property[index].loudong"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="房间号" >
                                        <el-input v-model="property[index].houseNumber"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-form-item label="位置" >
                                <el-input v-model="property[index].location"></el-input>
                            </el-form-item>
                            <el-form-item label="产权证编号" >
                                <el-input v-model="property[index].ownNumber"></el-input>
                            </el-form-item>
                            <el-row>
                                <el-col :span="8">
                                    <el-form-item label="承租面积" >
                                        <el-input v-model="property[index].rentArea"></el-input>
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <el-form-item label="签约面积" >
                                        <el-input v-model="property[index].signArea"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-form-item label="房屋类型">
                                <el-select v-model="property[index].houseType" placeholder="请选择">
                                    <el-option
                                            v-for="item in options"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value">
                                    </el-option>
                                </el-select>
                            </el-form-item>

                        </el-col>
                    </el-form>

                </el-tab-pane>
            </el-tabs>
    </el-row>
    </div>

</template>
<script>

    export default {
        components:{
        },
        data() {
            return {
                purchaseContract:{
                    type:0,
                },
                options: [{
                    value: '选项1',
                    label: '公寓'
                }, {
                    value: '选项2',
                    label: '写字楼'
                }, {
                    value: '选项3',
                    label: '商铺'
                }, {
                    value: '选项4',
                    label: '住宅'
                }],
                ruleForm:{
                    date1:0,
                    date2:0,
                },
                labelPosition: 'right',
                property: [{
                    estate: '建外Soho',
                    building: 'A',
                    houseNumber: '2902',
                    position: '东区',
                    ownNumber: '8345',
                    rentArea: '83.5',
                    signArea: '83.5',
                    houseType: '',
                }
                ],
                editableTabsValue2: '1',
                editableTabs2: [{
                    title: '房间1',
                    name: '1',
                    content: 'Tab 1 content'
                }],
                tabIndex: 1
            }
        },
        methods: {
            addTab(targetName) {
                this.$notify.success({
                    title: '成功',
                    message: '添加了一条新房源',
                    offset: 100
                });
                let newTabName = ++this.tabIndex + '';
                this.editableTabs2.push({
                    title: 'New Tab1',
                    name: newTabName,
                    content: 'New Tab content'
                });
                this.property.push({
                    estate: '',
                    building: '',
                    houseNumber: '',
                    position: '',
                    ownNumber: '',
                    rentArea: '',
                    signArea: '',
                    houseType: '',
                });
                this.editableTabsValue2 = newTabName;
            },
            removeTab(targetName) {
                let tabs = this.editableTabs2;
                let activeName = this.editableTabsValue2;
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1];
                            if (nextTab) {
                                activeName = nextTab.name;
                            }
                        }
                    });
                }

                this.editableTabsValue2 = activeName;
                this.editableTabs2 = tabs.filter(tab => tab.name !== targetName);
            }
        }
    }
</script>