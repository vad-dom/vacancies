<template>
  <h1 class="no__margin">
    <slot></slot>
  </h1>
</template>

<script>
export default {
  name: "VacancyHeader",
}
</script>

<style scoped>

.no__margin {
  margin: 0;
}

</style>