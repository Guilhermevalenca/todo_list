<template>
  <div v-if="!isLoggedUser">
    <v-btn color="secondary" @click="isLoginOpen = true">Login</v-btn>
    <v-btn @click="isCreateOpen = true" >Criar conta</v-btn>

    <Login v-model="isLoginOpen" @close_login_user="isLoginOpen = false" @loggaed="isLoggedUser = true"/>
    <Create v-model="isCreateOpen" @close_create_user="isCreateOpen = false" @loggaed="isLoggedUser = true" />
  </div>
  <div v-else>
    <AuthenticatedUser />
  </div>
</template>

<script>
import Login from "@/layouts/default/user/Login.vue";
import Create from "@/layouts/default/user/Create.vue";
import AuthenticatedUser from "@/layouts/default/user/Authenticated.vue";
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
      this.isLoggedUser = true;
    }
  }
}
</script>

<style scoped>

</style>
