<template>
  <v-dialog width="500px">
    <v-card>
      <v-card-title>Criar tarefa</v-card-title>
      <v-card-subtitle>Aqui você pode criar uma tarefa</v-card-subtitle>
      <v-form @submit.prevent="registerTodo()">
        <v-card-text>
          <v-row>
            <v-col>
              <v-text-field v-model="name" label="Nome da tarefa" placeholder="digite o nome da tarefa" hint="Tarefa" required />
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-autocomplete label="Responsável" v-model="users.picked" v-model:search="users.search" :items="showUsers" placeholder="Selecione..." required />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-btn type="submit" color="secondary">Criar tarefa</v-btn>
          <v-btn @click="$emit('close_todo_create')">cancelar</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from "axios";

export default {
  name: "TodoCreate",
  data() {
    return {
      name: '',
      users: {
        all: [],
        picked: '',
        search: ''
      }
    }
  },
  methods: {
    registerTodo() {
      //Procurando o indice equivalente ao resultado escolhido pelo usuario, sabendo o indice ele consegue saber qual user foi escolhido no outro array de usuarios
      const user = this.showUsers.findIndex( (elements) => {
        return elements === this.users.picked;
      });
      console.log(this.users.all);
      const id = this.users.all[user].id
      axios.post('todo_list',{
        name: this.name,
        user_id: id
      })
        .then(() => this.$emit('close_todo_create'))
        .catch(error => console.log(error));
    },
    getUsers() {
      axios.post('users',{
        partialName: this.users.search
      })
        .then(response => this.users.all = response.data)
        .catch(error => console.log(error));
    },
  },
  computed: {
    showUsers() {
      const dataUsers = this.users.all.map(users => {
        return `Nome: ${users.name} Email: ${users.email}`;
      });
      return dataUsers;
    }
  },
  watch: {
    users: {
      handler($new) {
        if($new.search !== null && $new.search.length >= 1) {
          if($new.search.length === 1) {
            this.getUsers();
          } else if($new.search.length === 3) {
            this.getUsers();
          } else if($new.search.length === 5) {
            this.getUsers();
          }
        }
      },
      deep: true
    }
  }
}
</script>

<style scoped>

</style>
