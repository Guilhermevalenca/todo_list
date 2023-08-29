<template>
  <v-card>
    <div>
      {{ todos[0] }}
    </div>
    <v-card-title>Tarefas</v-card-title>
    <v-card-subtitle>Aqui você poderá vizualizar suas tarefas</v-card-subtitle>
    <v-table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Responsável</th>
          <th>status</th>
        </tr>
      </thead>
      <tbody>
      <tr v-for="(todo,index) in todos" :key="index">
        <td>{{ todo.name }}</td>
        <td>{{ todo.user.name }}</td>
        <td>{{ todo.status }}</td>
      </tr>
      </tbody>
    </v-table>
  </v-card>
</template>

<script>
import axios from 'axios';
export default {
  name: 'HomeView',
  data() {
    return {
      todos: []
    }
  },
  created() {
    axios.get('todo_list')
      .then(response => this.todos = response.data)
      .catch(error => console.log(error))
  }
}
</script>
