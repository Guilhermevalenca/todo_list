<template>
  <v-form >
    <v-row>
      <v-col md="2">
        <v-select v-model="searchBy" label="Pesquisar por..." :items="['Tarefa','Usuário']" />
      </v-col>
      <v-col md="4">
        <v-text-field label="" />
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
export default {
  name: "TodoSearch",
  data() {
    return {
      searchBy: ''
    }
  }
}
</script>


<style scoped>

</style>
