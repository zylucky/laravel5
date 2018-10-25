<template>
    <ul class="list-group">
        <li class="list-group-item"
            v-for="(todo,index) in todos"
            v-bind:class="{'completed':todo.completed}"
        >{{todo.title}}
            <button class="btn btn-warning btn-sm btn-xs pull-right"
                    v-on:click="deleteTodo(index)">delete</button>
            <button class="btn btn-sm btn-xs pull-right"
                    v-bind:class="[todo.completed?'btn-danger':'btn-success']"
                    v-on:click="toggleComplete(todo)">{{todo.completed?'undo':'completed'}}</button>
        </li>
    </ul>
</template>
<script>
    export default {
        mounted() {
            console.log('todos.vue;')
        },
        props:['todos'],

        methods:{
            deleteTodo(index){
                this.todos.splice(index,1)
            },
            toggleComplete(todo){
                todo.completed = ! todo.completed;
            }
        },
    }
</script>