<template>
  <v-dialog width="500px">
    <v-card>
      <v-form @submit.prevent="registerTodo()">
        <v-card-text>
          <v-row>
            <v-col>
              <v-text-field v-model="name" label="Nome" placeholder="Nome da tarefa" hint="tarefa" required />
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-autocomplete label="Responsável" :item-value="users.search" v-model="users.picked" :items="showUsers" placeholder="Selecione ..." required />
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
      axios.post('todo_list',{
        name: this.name,
        user_id: this.userResponsible.id
      })
        .then(response => {
          console.log(response);
        });
    },
    getUsers() {
      axios.post('users',{
        partialName: this.users.search
      })
        .then(response => console.log(response))
        .catch(error => console.log(error));
    },
    updateListUser() {
      if(this.users.search !== null) {
        if(this.users.search.length <= 2) {
          this.getUsers();
        } else if(this.users.search.length % 3 === 0) {
          this.getUsers();
        }
      }
    }
  },
  computed: {
    showUsers() {
      const dataUsers = this.users.all.map(users => {
        return `Nome: ${users.name} Email: ${users.email}`;
      });
      return dataUsers;
    },
    userResponsible() {
      const user = this.showUsers.find( (users, index) => {
        if(users === this.users.picked) {
          return this.users.all[index];
        }
      });
        return user;
    }
  },
  watch: {
    users: {
      handler($new) {
        console.log($new);
      },
      deep: true
    }
  }
}
</script>

<style scoped>

</style>
