<template>
  <v-app>
    <default-drawer v-model="isDrawerOpen" />

    <default-bar @drawer="isDrawerOpen = !isDrawerOpen" />

    <default-view />
  </v-app>
</template>

<script>
  import DefaultBar from './AppBar.vue';
  import DefaultView from './View.vue';
  import DefaultDrawer from './ItemDrawer.vue';

export default {
  components: {DefaultBar, DefaultView, DefaultDrawer},
  data() {
    return {
      isDrawerOpen: false
    }
  }
}
</script>
