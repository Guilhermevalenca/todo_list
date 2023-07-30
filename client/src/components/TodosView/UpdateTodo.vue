<template>
    <button @click="$emit('show_todos')">voltar</button>
    <form @submit.prevent="update_todo()">
        <div>
            <label>Nome da tarefa:</label>
            <input type="text" v-model="todo.DATA_NAME">
        </div>
        <div>
            <label>Nome do responsavel:</label>
            <input type="text" v-model="todo.DATA_RESPONSIBLE">
        </div>
        <button>atualizar tarefa</button>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        id: Number
    },
    functional: true,
    data() {
        return {
            todo: {}
        }
    },
    methods: {
        get_todo() {
            axios.get(`todo`,{
                params: {
                    id: this.id
                }
            })
            .then(response =>  this.todo = response.data.todos[0])
            .catch(error => console.log(error))
        },
        update_todo() {
            axios.put('todo',{
                name: this.todo.DATA_NAME,
                responsible: this.todo.DATA_RESPONSIBLE,
                status: this.todo.DATA_STATUS,
                id: this.todo.DATA_ID
            })
            .then(() => {
                this.$emit('update_todos');
                this.$emit('show_todos');
            })
            .catch(error => console.log(error))
            
        }
    },
    created() {
        this.get_todo()
    }
}
</script>