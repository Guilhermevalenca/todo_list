<template>
<table>
    <thead>
        <tr>
            <th>Nome da tarefa:</th>
            <th>Data de criação:</th>
            <th>Estado da tarefa:</th>
            <th>Quem está responsavel:</th>
            <th>Opções:</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(todo,index) in todos" :key="index">
          <td>{{ todo.DATA_NAME }}</td>
          <td>{{ todo.DATA_DATE }}</td>
            <td>
                <button 
                class="buttons"
                :style="color_button(todo.DATA_STATUS)"
                @click="update_status(todo.DATA_ID,todo.DATA_STATUS)">
                    {{ todo.DATA_STATUS == 0 ? 'Não concluida' : 'concluida' }}
                </button>
            </td>
          <td>{{ todo.DATA_RESPONSIBLE }}</td>
          <td>
            <button @click="delete_todo(todo.DATA_ID)">deletar</button>
            <button @click="show_update(todo.DATA_ID)">atualizar</button>
          </td>
        </tr>
    </tbody>
</table>
</template>

<script>
export default {
    name: 'AllTodos',
    props: {
        todos: Array,
    },
    methods: {
        update_status(id,status) {
            this.$emit('update_status',{
                id: id,
                status: status ? 0 : 1 //um e zero são respectivamente true e false
            })
        },
        delete_todo(id) {
            this.$emit('delete_todo',id);
        },
        show_update(id) {
            this.$emit('show_update',id)
        },
        color_button(status) {
            return status ? 'background-color: green;' : 'background-color: red;';
        }
    }
}
</script>

<style scoped>
td > .buttons{
    color: white;
    border-width: 0;
    
}
table {
    border-style: solid;
}

</style>