<template>
    <form action="" v-on:submit.prevent="">
        <div class="form-group">
            <input type="text" class="form-control" v-model="newtodo.title">
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-block" v-on:click="addTodo(newtodo)">add</button>
        </div>
    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('form vue.')
        },
        props:['todos'],

        data(){
            return {
                newtodo:{id:null,title:'',completed:false}
            }
        },
        methods:{
            addTodo(newtodo){
                this.todos.push(newtodo)
                this.newtodo = {id:null,title:'',completed:false}
            },

        },
    }
</script>