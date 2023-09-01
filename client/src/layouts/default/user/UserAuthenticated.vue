<template>
  <v-tooltip text="Opções de perfil">
    <template #activator="{ props }">
      <v-card v-bind="props">
        <v-menu>
          <template #activator="{ props }">
            <v-avatar v-bind="props">
              <v-img src="https://st.depositphotos.com/1037778/4713/i/950/depositphotos_47139273-stock-photo-nerd-boy-holding-geek-glasses.jpg" cover />
            </v-avatar>
          </template>
          <v-card min-width="200px">
            <v-list density="compact">
              <v-list-item>
                <v-list-item-title>
                  <v-btn prepend-icon="mdi-account-outline">Meu perfil</v-btn>
                </v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-list-item-subtitle>
                  <v-btn prepend-icon="mdi-logout" @click="logout()">Sair da conta</v-btn>
                </v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-card>
        </v-menu>
      </v-card>
    </template>
  </v-tooltip>
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
            this.$emit('logout');
          }
        })
        .catch(error => console.log(error))
    }
  },
  created() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
  }
}
</script>


<style scoped>

</style>
