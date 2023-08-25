<template>
  <v-navigation-drawer>
    <v-list>
      <v-list-item-title>Menu</v-list-item-title>
      <v-list-group value="sobre">
        <template #activator="{props}">
          <v-list-item v-bind="props">
            Sobre
          </v-list-item>
        </template>
        <v-list-item>Plataforma</v-list-item>
        <v-list-item>Criadores</v-list-item>
      </v-list-group>
      <v-list-group value="ajuda">
        <template #activator="{props}">
          <v-list-item v-bind="props">
            Ajuda
          </v-list-item>
        </template>
        <v-list-item>Dicas</v-list-item>
        <v-list-item>Problemas com o site</v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
  name: "ItemDrawer"
}
</script>

<style scoped>

</style>
