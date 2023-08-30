<template>
  <v-dialog width="600px">
    <v-card>
      <v-form @submit.prevent="registerTodo()">
        <v-card-text>
          <v-row>
            <v-col md="8">
              <v-text-field v-model="name" label="Nome" placeholder="Nome da tarefa" hint="tarefa" />
            </v-col>
          </v-row>
          <v-row>
            <v-col md="9">
              <v-select v-model="users.picked" label="Responsável" placeholder="escolha um responsável para tarefa" :items="userEmails" />
              <v-card v-if="infoUsers">
                <v-list>
                  <v-list-item>
                    Nome: {{ infoUsers.name }}
                  </v-list-item>
                  <v-list-item>
                    Cargo: {{ infoUsers.position }}
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
            <v-col>
              <v-row>
                <v-tooltip text="Próxima lista de usuários">
                  <template #activator="{ props }">
                    <v-btn v-bind="props" prepend-icon="mdi-plus" @click="users.page++;getUsers()">Ver mais</v-btn>
                  </template>
                </v-tooltip>
              </v-row>
              <v-row>
                <v-tooltip text="Voltar lista de usuários">
                  <template #activator="{ props }">
                    <v-btn v-bind="props" prepend-icon="mdi-minus" @click="users.page--;getUsers()">Ver menos</v-btn>
                  </template>
                </v-tooltip>
              </v-row>
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
        picked: null,
        page: 0
      },
      oldPage: this.page
    }
  },
  methods: {
    registerTodo() {
      axios.post('todo_list',{
        name: this.name,
        user_id: this.infoUsers.id
      })
        .then(response => {
          console.log(response);
        });
    },
    getUsers() {
      axios.get('users',{
        params: {
          page: this.users.page
        }
      })
        .then(response => {
          if(response.data) {
            this.users.all = response.data;
            this.oldPage = this.users.page;
          }else {
            this.users.page = this.oldPage;
          }
        })
        .catch(error => console.log(error));
    }
  },
  computed: {
      userEmails() {
        const emails = this.users.all.map(user => {
          return user.email;
        });
        return emails;
      },
      infoUsers() {
        const users = this.users.all.find(user => {
          if(user.email === this.users.picked) {
            return user;
          }
        });
        return users;
      }
  },
  mounted() {
    this.getUsers();
  },
  watch: {
    users: {
      handler($new) {
        if($new.page < 1) {
          this.users.page = 1;
        }
      },
      deep:true
    }
  }
}
</script>

<style scoped>

</style>
