<template>
  <v-card class="border pa-4">
    <v-card-title>Tarefas</v-card-title>
    <v-card-subtitle>Aqui você poderá visualizar suas tarefas</v-card-subtitle>
    <v-card-actions>
      <v-row>
        <v-col>
          <TodoSearch @dataSearch="(response) => searchLoading(response)" @notSearch="notSearch()" />
        </v-col>
      </v-row>
    </v-card-actions>
    <v-card-actions>
      <v-row>
        <v-col v-if="logged" md="2">
          <v-btn prepend-icon="mdi-form-select" color="secondary" @click="createTodo.show = true">Criar tarefa</v-btn>
        </v-col>
        <v-col>
          <v-btn prepend-icon="mdi-page-previous-outline" @click="currentPage--" color="primary">Voltar pagina</v-btn>
          <v-btn prepend-icon="mdi-page-next-outline" @click="currentPage++" color="secondary">Próxima pagina</v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
    <v-card-text  class="d-flex justify-center">
      <v-table density="comfortable">
        <thead>
        <tr>
          <th>Nome da tarefa</th>
          <th>Responsável</th>
          <th>Email</th>
          <th>Cargo</th>
          <th>Situação atual</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(todo,index) in todos" :key="index">
          <td>{{ todo.name }}</td>
          <td>{{ todo.user.name }}</td>
          <td>{{ todo.user.email }}</td>
          <td>{{ todo.user.position }}</td>
          <td v-if="logged">
            <v-tooltip text="Clique para alterar a situação atual da tarefa">
              <template #activator="{ props }">
                <v-btn v-bind="props" @click="updateStatus(todo.id)" :color="todo.status ? 'success' : 'warning'">{{ todo.status ? 'Concluida' : 'Não concluida'}}</v-btn>
              </template>
            </v-tooltip>
          </td>
          <td v-if="!logged">{{ todo.status ? 'Concluida' : 'Não concluida' }}</td>
          <td v-if="logged" >
            <v-row>
              <v-col />
              <v-col>
                <v-btn @click="todoInfo.currentTodo = todo; todoInfo.show = true;">atualizar tarefa</v-btn>
                <v-btn @click="deleteTodo(todo.id)">apagar tarefa</v-btn>
              </v-col>
              <v-col />
            </v-row>
          </td>
        </tr>
        </tbody>
      </v-table>
    </v-card-text>
    <v-row>
      <v-col md="5">
        <v-pagination :length="limitPage" v-model="currentPage" rounded="circle" :total-visible="7"  />
      </v-col>
      <v-col md="1" v-if="!mobileScreen">
        <v-text-field :clearable="false" @update:model-value="value => currentPage < limitPage" label="Pagina" type="number" persistent-placeholder placeholder="Digite..." v-model.number="currentPage" />
      </v-col>
    </v-row>
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
      limitPage: 1,
      validPage : this.currentPage,
      todoInfo: {
        currentTodo: null,
        show: false
      },
      createTodo: {
        show: false
      },
      logged: localStorage.getItem('token') !== null,
      searchPage: false,
      searchName: '',
      mobileScreen: window.innerWidth < 768
    }
  },
  created() {
    this.allTodos();
    window.addEventListener('token_changed',() => {
      this.logged = localStorage.getItem('token') !== null;
    });
  },
  methods: {
    allTodos() {
      if(!this.searchPage) {
        axios.get('todo_list',{
          params: {
            page: this.currentPage
          }
        })
          .then(response => {
            if(this.validateTodos(response.data.todos)) {
              this.todos = response.data.todos;
              this.limitPage = response.data.totalPage;

            }
          })
          .catch(error => console.log(error))
      } else {
        const data = {
          name: this.searchName
        };
        const config = {
          params: {
            page: this.currentPage
          }
        };
        axios.post('todo_list/search',data,config)
          .then(response => {
            if(this.validateTodos(response.data)) {
              this.todos = response.data;
              this.limitPage = response.data.TotalPage;
            }
          })
          .catch(error => console.log(error));
      }
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
    },
    searchLoading(response) {
      console.log(response);
      this.currentPage = 0;
      this.searchPage = true;
      this.todos = response.data;
      this.searchName = response.name
    },
    notSearch() {
      this.searchPage = false;
      this.currentPage = 0;
      this.allTodos();
    },
    validateTodos(todos) {
      if(todos.length !== 0) {
        this.validPage = this.currentPage;
        return true;
      }
      this.currentPage = this.validPage;
      return false
    }
  },
  watch: {
    currentPage: {
      handler($new) {
        if($new < 0) {
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
