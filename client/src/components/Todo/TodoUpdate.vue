<template>
<v-dialog width="800px">
  <v-card>
    <v-card-title>Informações da tarefa</v-card-title>
    <v-card-subtitle>Aqui estão todos os dados disponíveis para atualização</v-card-subtitle>
    <v-form>
      <v-card-text>
        <v-row>
          <v-col>
            <v-text-field label="Nome da tarefa" :disabled="true" :model-value="receivingTodo.name" />
          </v-col>
          <v-col>
            <v-text-field label="Novo nome da tarefa" v-model="todo.name" />
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field label="Responsável" :disabled="true" :model-value="responsible" />
          </v-col>
          <v-col>
            <v-autocomplete label="Novo responsável" v-model="user.name" />
          </v-col>
        </v-row>
      </v-card-text>
    </v-form>
  </v-card>
</v-dialog>
</template>

<script>
export default {
  name: "TodoInfo",
  props: {
    receivingTodo: Object
  },
  data() {
    return {
      todo: {
        name: this.receivingTodo.name,
      },
      user: this.receivingTodo.user,
      responsible: `Nome: ${this.receivingTodo.user.name} Email: ${this.receivingTodo.user.email}`
    }
  },
  methods: {

  },
}
</script>

<style scoped>

</style>
