<template>
  <v-form >
    <v-row>
      <v-col md="2">
        <v-select v-model="searchBy" label="Pesquisar por..." persistent-hint hint="Selecione o parâmetro de pesquisa" :items="['Tarefa','Usuário']" />
      </v-col>
      <v-col md="4">
        <v-text-field :label="showInfo.label" persistent-placeholder placeholder="digite aqui sua tarefa" />
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
export default {
  name: "TodoSearch",
  data() {
    return {
      searchBy: '',
      showInfo: {
        label: this.searchBy === 'Usuário' ? 'Usuário' : 'Tarefa'
      }
    }
  }
}
</script>


<style scoped>

</style>
