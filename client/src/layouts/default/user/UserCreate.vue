<template>
  <v-dialog width="600px">
    <v-card v-if="!alert.show">

      <v-card-title>Criar usuário</v-card-title>

      <v-form @submit.prevent="registerUser()">
        <v-card-text>
          <v-row>
            <v-col>

              <v-text-field prepend-inner-icon="mdi-account-outline" v-model="name" type="text" label="Nome" placeholder="Meu nome" hint="Digite seu nome" :rules="rules.name" />

            </v-col>
            <v-col>

              <v-text-field prepend-inner-icon="mdi-email-outline" v-model="email" type="email" label="Email" hint="Digite seu email" placeholder="example@gmail.com" :rules="rules.email" />

            </v-col>
          </v-row>
          <v-row>
            <v-col>

              <v-text-field prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showIcon.password ? 'mdi-eye' : 'mdi-eye-off'" :type="showIcon.password ? 'text' : 'password'" v-model="password" @click:append-inner="showIcon.password = !showIcon.password" hint="Digite Sua senha" label="Senha" placeholder="digite uma senha" :rules="rules.password" />

            </v-col>
            <v-col>

              <v-text-field prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showIcon.confirmPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showIcon.confirmPassword ? 'text' : 'password'" @click:append-inner="showIcon.confirmPassword = !showIcon.confirmPassword" label="Confirme sua senha" hint="Confirme sua senha" :rules="rules.confirmPassword" />

            </v-col>
          </v-row>
          <v-row>
            <v-col>

              <v-select prepend-inner-icon="mdi-briefcase-outline" v-model="position" label="Cargo" type="text" :items="['Gerente','Funcionário']" />

            </v-col>
            <v-col />
          </v-row>
        </v-card-text>

        <v-card-actions>
          <v-btn type="submit" color="success">Salvar</v-btn>
          <v-btn @click="$emit('close_create_user')">Cancelar</v-btn>
        </v-card-actions>

      </v-form>

    </v-card>
    <v-card v-else>

      <v-card-title>{{ alert.content.title }}</v-card-title>
      <v-card-text>{{ alert.content.text }}</v-card-text>

      <v-card-actions>
        <v-btn @click="alert.show=false">Fechar</v-btn>
      </v-card-actions>

    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios';
export default {
  name: "UserCreate",
  data() {
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
        name: nameRules,
        email: emailRules,
        password: passwordRules,
        confirmPassword: confirmPasswordRules,
      },
      alert: {
        content: {
          title: '',
          text: ''
        },
        show: false
      },
      showIcon: {
        password: false,
        confirmPassword: false
      }
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
          .then(response => {
            localStorage.setItem('token',response.data);
            this.$emit('logged');
          })
          .catch(error => {
            if(error.response.data[1] === 1062) {
              this.alert.content.title = 'Usuário já existe';
              this.alert.content.text = 'Você tentou inserir um email já cadastrado';
              this.alert.show = true;
            }
            console.log(error);
          })
    }
  }
}
</script>

<style scoped>

</style>
