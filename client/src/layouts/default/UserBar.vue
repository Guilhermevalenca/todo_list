<template>
  <v-btn color="secondary" @click="isLoginOpen = true">Login</v-btn>
  <v-btn @click="isCreateOpen = true" >Criar conta</v-btn>

  <Login v-model="isLoginOpen" />
  <Create v-model="isCreateOpen" @close_create_user="isCreateOpen = false" />
</template>

<script>
import Login from "@/layouts/default/user/Login.vue";
import Create from "@/layouts/default/user/Create.vue";

export default {
  name: "UserBar",
  components: {Create, Login},
  data() {
    return {
      isLoginOpen: false,
      isCreateOpen: false
    }
  }
}
</script>

<style scoped>

</style>
