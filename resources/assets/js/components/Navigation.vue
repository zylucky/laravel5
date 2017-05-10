<template>
    <el-col :span="4">
       <!-- <el-menu default-active="2" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose"> -->
        <el-menu default-active="2" class="el-menu-vertical-demo" >
            <el-submenu index="1">
                <template slot="title"><i class="el-icon-message"></i>合同管理</template>
                <el-menu-item-group>
                    <template slot="title">幼狮科技</template>
                    <el-menu-item index="1-1">收房合同</el-menu-item>
                    <el-menu-item index="1-2">出房合同</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="华亮房产">
                    <el-menu-item index="1-3">选项3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="1-4">
                    <template slot="title">选项4</template>
                    <el-menu-item index="1-4-1">选项1</el-menu-item>
                </el-submenu>
            </el-submenu>
            <el-menu-item index="2"><i class="el-icon-menu"></i>导航二</el-menu-item>
            <el-menu-item index="3"><i class="el-icon-setting"></i>导航三</el-menu-item>
        </el-menu>
    </el-col>
</template>