<template>
  <h1 :style="{'margin-top': marginTop, 'margin-bottom': marginBottom}">
    <slot></slot>
  </h1>
</template>

<script>
export default {
  name: "VacancyH1",
  props: {
    marginTop: {
      type: String,
      default: '0',
    },
    marginBottom: {
      type: String,
      default: '0',
    },
  }
}
</script>

<style scoped>

</style>