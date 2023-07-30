<template>
  <section v-if="showTodos" >
    <AddTodo @add_todo="get_todo()" v-once/>     
  </section>
  <section v-if="showTodos">
    <h1>Tarefas registradas:</h1>
    <!--
    <div class="all-todos">
      <AllTodos :todos="todos" @update_status="update_status" @delete_todo="delete_todo" 
      @show_update="(idParam) => {showTodos = false; id = idParam}" />
    </div>
    -->
    <div class="split-tasks">
      <div class="tasks-performed">
        <AllTodos :todos="tasks_performed" @update_status="update_status" @delete_todo="delete_todo" 
        @show_update="(idParam) => {showTodos = false; id = idParam}" />
      </div>

      <div class="tasks-not-performed">
        <AllTodos :todos="tasks_not_performed" @update_status="update_status" @delete_todo="delete_todo" 
        @show_update="(idParam) => {showTodos = false; id = idParam}" />
      </div>
    </div>
  </section>

  <section v-else v-once>
    <UpdateTodo :id="id" @show_todos="showTodos = true" @update_todos="get_todo()" />
  </section>
</template>
  
<script>
import AddTodo from '@/components/TodosView/AddTodo.vue';
import UpdateTodo from '@/components/TodosView/UpdateTodo.vue';
import AllTodos from '@/components/TodosView/AllTodos.vue';
import axios from 'axios';

export default {
  name: 'TodosView',
  functional: true,
  components: {
      AddTodo,
      UpdateTodo,
      AllTodos
  },
  data() {
      return {
        todos: [],
        showTodos: true,
        id: ''
      }
  },
  methods: {
      get_todo() {
          axios.get('todo')
          .then(response => this.todos = response.data.todos)
          .catch(error => console.log(error))
      },
      delete_todo(DATA_ID) {
        axios.delete('todo',{
          data: {
              id: DATA_ID
          }
        })
        .then(() => this.get_todo())
        .catch(error => console.log(error))
      },
      update_status(data) {
        const id = data.id;
        const status = data.status
      
        axios.patch('todo',{
            id: id,
            status: status
        })
        .then(() => this.get_todo())
        .catch(error => console.log(error));
      }
  },
  computed: {
      tasks_performed() {
          if(this.todos.length !== 0) {
              const tasks = [];

              this.todos.forEach(todo => {
                  if(todo.DATA_STATUS) {
                      tasks.push(todo)
                  }
              });
              return tasks
          }return null;
      },
      tasks_not_performed() {
          if(this.todos.length !== 0) {
              const tasks = [];
              this.todos.forEach(todo => {
                  if(!todo.DATA_STATUS) {
                      tasks.push(todo)
                  }
              });
              return tasks;
          }return null;
      }
  },
  created() {
    this.get_todo();
  },
  watch: {
    todos: {
      immediate: true,
      handler($new) {
        $new.reverse();
      },
      deep: false
    }
  }
}
</script>
  
  <style scoped>
.all-todos{
  display: flex;
  justify-content: center;
}
.split-tasks{
  display: flex;
}
  </style>