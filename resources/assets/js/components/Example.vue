<template :todos ="todos">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">VUE实践</div>

                    <div class="panel-body">
                        <div class="panel-body">
                            <h1>{{message}}   {{todosCount}}</h1>
                            <todos :todos="todos"></todos>
                            <formtodo :todos="todos"></formtodo>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .completed{
        color: green;
        text-decoration:line-through;
    }
</style>
<script>
    import todos from './Todos.vue'
    import formtodo from './FormTodo.vue'

    export default {
        mounted() {
            console.log('example vue.')
        },
        components:{
          todos,formtodo
        },

        data(){
            return {
                message:'second practicing',
                todos:[
                    {id:1,title:'todo1',completed:true},
                ],
            }
        },
        computed:{
            todosCount(){

                return this.todos.length;
            }
        }
    }
</script>
