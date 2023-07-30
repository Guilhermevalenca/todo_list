<template>
    <form @submit.prevent="add_todo()">
        <div>
            <label>Nome da tarefa:</label>
            <input type="text" v-model="name" placeholder="tarefa" required>
        </div>
        <div>
            <label>Nome do responsavel:</label>
            <input type="text" v-model="responsible" placeholder="responsavel" required>
        </div>
        <button>adicionar</button>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    name: 'AddTodo',
    data() {
        return {
            name: '',
            responsible: ''
        }
    },
    methods: {
        add_todo() {
            axios.post('todo',{
                name: this.name,
                responsible: this.responsible
            })
            .then(() => this.$emit('add_todo'))
            .catch(error => console.log(error))
            .finally(() => this.clear())
        },
        clear() {
            this.name = '';
            this.responsible = '';
        }
    }
}
</script>