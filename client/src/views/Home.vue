<template>
  <v-card class="border pa-4">
    <v-card-title>Tarefas</v-card-title>
    <v-card-subtitle>Aqui você poderá visualizar suas tarefas</v-card-subtitle>
    <v-card-actions>
      <v-row>
        <v-col md="10">
          <TodoSearch />
        </v-col>
        <v-col v-if="logged">
          <v-btn prepend-icon="mdi-form-select" color="secondary" @click="createTodo.show = true">Criar tarefa</v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
    <v-card-text  class="d-flex justify-center">
      <v-table density="compact">
        <thead>
        <tr>
          <th>Nome da tarefa</th>
          <th>Responsável</th>
          <th>Email</th>
          <th>Cargo</th>
          <th>Situação atual</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(todo,index) in todos" :key="index">
          <td>{{ todo.name }}</td>
          <td>{{ todo.user.name }}</td>
          <td>{{ todo.user.email }}</td>
          <td>{{ todo.user.position }}</td>
          <td v-if="logged">
            <v-btn @click="updateStatus(todo.id)" :color="todo.status ? 'success' : 'warning'">{{ todo.status ? 'Concluida' : 'Não concluida'}}</v-btn>
          </td>
          <td v-if="!logged">{{ todo.status ? 'Concluida' : 'Não concluida' }}</td>
          <td v-if="logged" ><v-list>
            <v-list-item>
              <v-btn @click="todoInfo.currentTodo = todo; todoInfo.show = true;">atualizar tarefa</v-btn>
            </v-list-item>
            <v-list-item>
              <v-btn @click="deleteTodo(todo.id)">apagar tarefa</v-btn>
            </v-list-item>
          </v-list></td>
        </tr>
        </tbody>
      </v-table>
    </v-card-text>
    <v-card-actions>
      <v-row>
        <v-col md="10">
          <v-btn prepend-icon="mdi-page-previous-outline" @click="currentPage--" color="primary">Voltar pagina</v-btn>
          <v-btn prepend-icon="mdi-page-next-outline" @click="currentPage++" color="secondary">Próxima pagina</v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
  <TodoCreate v-model="createTodo.show" @close_todo_create="allTodos();createTodo.show = false" />
  <TodoUpdate v-if="todoInfo.show" v-model="todoInfo.show" :receivingTodo="todoInfo.currentTodo" @close_todo_info="todoInfo.show = false" />
</template>

<script>
import axios from 'axios';
import TodoUpdate from "@/components/Todo/TodoUpdate.vue";
import TodoCreate from "@/components/Todo/TodoCreate.vue";
import TodoSearch from "@/components/Todo/TodoSearch.vue";
export default {
  name: 'HomeView',
  components: {TodoSearch, TodoCreate, TodoUpdate},
  data() {
    return {
      todos: [],
      currentPage: 1,
      validPage : this.currentPage,
      todoInfo: {
        currentTodo: null,
        show: false
      },
      createTodo: {
        show: false
      },
      logged: localStorage.getItem('token') !== null
    }
  },
  created() {
    this.allTodos();
  },
  methods: {
    allTodos() {
      axios.get('todo_list',{
        params: {
          page: this.currentPage
        }
      })
        .then(response => {
          if(response.data.length !== 0) {
            this.todos = response.data
            this.validPage = this.currentPage;
          } else {
            this.currentPage = this.validPage;
          }
        })
        .catch(error => console.log(error))
    },
    updateStatus(id) {
      axios.patch(`todo_list/${id}`)
        .then(() => {
          this.allTodos();
        })
        .catch(error=> {
          console.log(error);
        });
    },
    deleteTodo(id) {
      axios.delete('todo_list',{
        data: {
          id: id
        }
      })
        .then(response => {
          if(response.data) {
            this.allTodos();
          }else {
            console.log(response);
          }
        })
        .catch(error => console.log(error));
    }
  },
  watch: {
    currentPage: {
      handler($new) {
        if($new < 1) {
          this.currentPage = 1;
        }
        // console.log($new);
        this.allTodos();
      },
      deep: false
    }
  }
}
</script>
