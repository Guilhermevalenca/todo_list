<template>
<v-menu>
  <template #activator="{ props }">
    <v-avatar v-bind="props">
      <v-img src="https://st.depositphotos.com/1037778/4713/i/950/depositphotos_47139273-stock-photo-nerd-boy-holding-geek-glasses.jpg" cover />
    </v-avatar>
  </template>
  <v-card min-width="200px">
    <v-list density="compact">
      <v-list-item prepend-icon="mdi-account-outline">
        <v-list-item-title>
          <v-btn>Meu perfil</v-btn>
        </v-list-item-title>
      </v-list-item>
      <v-list-item prepend-icon="mdi-logout">
        <v-list-item-subtitle>
        <v-btn @click="logout()">Sair da conta</v-btn>
        </v-list-item-subtitle>
      </v-list-item>
    </v-list>
  </v-card>
</v-menu>
</template>

<script>
import axios from "axios";

export default {
  name: "AuthenticatedUser",
  methods: {
    logout() {
      axios.post('users/logout')
        .then(response => {
          if(response.data) {
            localStorage.removeItem('token');
          }
        })
        .catch(error => console.log(error))
    }
  }
}
</script>


<style scoped>

</style>
