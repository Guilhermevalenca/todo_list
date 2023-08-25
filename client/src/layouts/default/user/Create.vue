<template>
  <v-dialog width="600px">
    <v-card>
      <v-card-title>Criar usuário</v-card-title>
      <v-card-text>
        <v-row>
          <v-col>
            <v-text-field v-model="name" label="Nome" placeholder="Meu nome" :rules="nameRules" />
          </v-col>
          <v-col>
            <v-text-field v-model="email" type="email" label="Email" placeholder="example@gmail.com" :rules="emailRules" />
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field v-model="password" type="password" label="Senha" placeholder="digite uma senha" :rules="passwordRules" />
          </v-col>
          <v-col>
            <v-text-field  type="password" label="Confirme sua senha" :rules="rules.confirmPassword" />
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-select v-model="position" label="Cargo" :items="['Gerente','Funcionário']" />
          </v-col>
          <v-col />
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn :loading="loading" color="success" @click="loading = true;registerUser()">Salvar</v-btn>
        <v-btn @click="$emit('close');loading = false">Cancelar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios';
export default {
  name: "UserCreate",
  data() {
    const confirmPasswordRules = [
      value => {
        if(value) {
          return true;
        }
        return 'É necessário confirmar sua senha';
      },
      value => {
        if(value === this.password) {
          return true;
        }
        return 'Senhas diferentes';
      },
    ];
    return {
      name: '',
      email: '',
      password: '',
      position: '',
      rules: {
        confirmPassword: confirmPasswordRules
      },
      loading: false
    }
  },
  methods: {
    registerUser() {
      const data = {
        name: this.name,
        email: this.email,
        password: this.password,
        position: this.position
      };
      axios.post('users/create',data)
          .then(response => console.log(response))
          .catch(error => console.log(error))
    }
  },
  setup() {
    const nameRules = [
        value => {
          if(value) {
            return true
          }
          return 'Campo obrigatório';
        }
    ];
    const emailRules = [
        value => {
          if(value) {
            return true
          }
          return 'O email é obrigatório';
        },
        value => {
          if(/.+@.+\..+/.test(value)) {
            return true
          }
          return 'Email inválido';
        }
    ];
    const passwordRules = [
        value => {
          if(value) {
            return true;
          }
          return 'Senha obrigatória';
        },
        value => {
          if(/\d/.test(value) && /[a-zA-Z]/.test(value)) {
            return true;
          }
          return 'Senha precisa ter caracteres alfanuméricos (letras e números)';
        },
        value => {
          if(value.length >= 6) {
            return true;
          }
          return 'Senha precisa ter no mínimo 6 caracteres';
        }
    ];

    return {
      nameRules,
      emailRules,
      passwordRules
    };
  }
}
</script>


<style scoped>

</style>
