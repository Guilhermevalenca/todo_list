<template>
  <v-app-bar>
    <v-app-bar-nav-icon @click="$emit('drawer')" />
    <v-app-bar-title>Todo list</v-app-bar-title>
    <v-btn @click="alterTheme()">
      <v-icon icon="mdi-theme-light-dark" />
    </v-btn>
    <UserBar />
  </v-app-bar>
</template>

<script>
import { useTheme } from 'vuetify'
import UserBar from "@/layouts/default/UserBar.vue";
  export default {
    components: {UserBar},
    data() {
      return {
        theme: useTheme()
      }
    },
    methods: {
      alterTheme() {
        this.theme.global.name = this.theme.global.current.dark ? 'light' : 'dark';
      }
    }
  }
</script>
