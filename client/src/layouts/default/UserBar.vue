<template>
  <div v-if="!isLoggedUser">
    <v-btn color="secondary" @click="isLoginOpen = true">Login</v-btn>
    <v-btn @click="isCreateOpen = true" >Criar conta</v-btn>

    <Login v-model="isLoginOpen" @close_login_user="isLoginOpen = false" @logged="isLoginOpen = false;isLoggedUser = true"/>
    <Create v-model="isCreateOpen" @close_create_user="isCreateOpen = false" @logged="isCreateOpen = false;isLoggedUser = true" />
  </div>
  <div v-else>
    <AuthenticatedUser @logout="isLoggedUser = false" />
  </div>
</template>

<script>
import Login from "@/layouts/default/user/UserLogin.vue";
import Create from "@/layouts/default/user/UserCreate.vue";
import AuthenticatedUser from "@/layouts/default/user/UserAuthenticated.vue";
import axios from "axios";
export default {
  name: "UserBar",
  components: {AuthenticatedUser, Create, Login},
  data() {
    return {
      isLoginOpen: false,
      isCreateOpen: false,
      isLoggedUser: false
    }
  },
  created() {
    if(localStorage.getItem('token')) {
      axios.get('user')
        .then(response => {
          if(response.data === "") {
            localStorage.removeItem('token');
          } else {
            this.isLoggedUser = true;
          }
        })
        .catch(error => {
          // console.log(error);
          this.isLoggedUser = false;
        })
    }
  }
}
</script>

<style scoped>

</style>
