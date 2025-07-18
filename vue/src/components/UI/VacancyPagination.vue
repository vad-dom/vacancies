<template>
  <div class="wrapper">
    <button
        v-for="n in pageCount"
        :key="n"
        :class="{'active': n === page}"
        @click="$emit('update:page', n)"
    >
      {{ n }}
    </button>
  </div>
</template>

<script>
export default {
  name: "VacancyPagination",
  props: {
    page: {
      type: Number,
      required: true,
    },
    pageCount: {
      type: Number,
      required: true,
    },
  },
}

</script>

<style scoped>

.wrapper {
  margin-top: 15px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 4px;
}

button {
  padding: 6px 10px;
  border-radius: 5px;
  cursor: pointer;
}

button.active {
  background-color: #006400;
  color: white;
}

</style>