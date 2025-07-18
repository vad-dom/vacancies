<template>
  <h3 v-if="salary > 0" class="price">{{ formatNumber(salary) }}</h3>
  <h3 v-else>Зарплата не указана</h3>
</template>

<script>
export default {
  name: "VacancyFormattedSalary",
  props: {
    salary: {
      type: Number,
      required: true,
    },
  },
  methods: {
    formatNumber(n) {
      return Number(n).toLocaleString('ru-RU');
    }
  }
}
</script>

<style scoped>

.price:after {
  content: ' \20BD/мес';
}

</style>