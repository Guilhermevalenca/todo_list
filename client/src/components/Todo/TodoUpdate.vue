<template>
<v-dialog width="600px">
  <v-card>
    <v-card-title>Informações da tarefa</v-card-title>
    <v-card-subtitle>Aqui estão todos os dados disponíveis para está tarefa</v-card-subtitle>
    <v-form>
      <v-row>

      </v-row>
    </v-form>
  </v-card>
</v-dialog>
</template>

<script>
export default {
  name: "TodoInfo",
  props: {
    todo: Object
  },
  created() {
    console.log(this.todo);
  }
}
</script>


<style scoped>

</style>
