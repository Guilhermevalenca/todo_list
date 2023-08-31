
<template>
<v-dialog width="600px">
  <v-card class="mx-auto pa-12 pb-8" elevation="8" width="448" rounded="lg">

    <v-card-title>Entre com sua conta</v-card-title>

    <v-alert v-if="message.alert">
      <v-row>
        <v-col md="10">
        </v-col>
        <v-col md="2">
          <v-icon icon="mdi-close" @click="message.alert = false" />
        </v-col>
      </v-row>
      <v-alert-title>
        <v-icon color="warning" icon="mdi-alert" size="x-large" />
        Email ou senha incorreto
      </v-alert-title>
    </v-alert>

    <v-form @submit.prevent="loginUser()">

      <v-row>
        <v-col>
          <v-text-field prepend-inner-icon="mdi-email-outline" v-model="email" type="email" label="Email" hint="Digite seu email" placeholder="example@gmail.com" :rules="rules.email" />
        </v-col>
      </v-row>

      <v-row>
        <v-col >
        <v-text-field prepend-inner-icon="mdi-lock-outline" :append-inner-icon="showIcon.password ? 'mdi-eye' : 'mdi-eye-off'" :type="showIcon.password ? 'text' : 'password'" v-model="password" @click:append-inner="showIcon.password = !showIcon.password" hint="Digite Sua senha" label="Senha" placeholder="digite uma senha" :rules="rules.password" />
        </v-col>
      </v-row>

      <v-card-actions>
        <v-btn type="submit" color="success">Entrar</v-btn>
        <v-btn @click="$emit('close_login_user')">Cancelar</v-btn>
      </v-card-actions>

    </v-form>
  </v-card>
</v-dialog>
</template>

<script>
import axios from 'axios';
export default {
  name: "UserLogin",
  data() {
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
      email: '',
      password: '',
      rules: {
        email: emailRules,
        password: passwordRules
      },
      showIcon: {
        password: false
      },
      message: {
        alert: false
      }
    }
  },
  methods: {
    loginUser() {
      axios.post('users/login',{
        email: this.email,
        password: this.password
      })
        .then(response => {
          localStorage.setItem('token',response.data);
          this.$emit('logged');
        })
        .catch(error => {
          this.message.alert = true;
          console.log(error);
        })
    }
  }
}
</script>

<style scoped>

</style>
