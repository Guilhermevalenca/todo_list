<template>
  <v-form @submit.prevent="searchItem()">
    <v-row>
      <v-col>
        <v-text-field label="Tarefa" persistent-placeholder placeholder="Digite o nome da tarefa" v-model="search.content" />
      </v-col>
      <v-col>
        <v-tooltip text="Clique para pesquisar">
          <template #activator="{ props }">
            <v-btn type="submit" color="secondary" size="x-large" prepend-icon="mdi-text-box-search-outline" v-bind="props" >
              Pesquisar
            </v-btn>
          </template>
        </v-tooltip>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import axios from "axios";

export default {
  name: "TodoSearch",
  data() {
    return {
      search: {
        content: ''
      },

    }
  },
  methods: {
    searchItem() {
      axios.post('todo_list/search',{
        name: this.search.content
      })
        .then(response => {
          this.$emit('dataSearch',{
            data: response.data,
            name: this.search.content
          });
        })
        .catch(error => console.log(error))
    }
  },
  watch: {
    search: {
      handler($new) {
        if($new.content === '') {
          this.$emit('notSearch');
        }
      },
      deep: true
    }
  }
}
</script>

<style scoped>

</style>
