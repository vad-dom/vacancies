<template>
  <div class="vacancy">
    <div>
      <h2>{{ vacancy.title }}</h2>
      <h3 v-if="vacancy.salary > 0">{{ formatNumber(vacancy.salary) }} руб. в месяц</h3>
      <h3 v-else>Зарплата не указана</h3>
      <p class="formatted">{{ vacancy.short_details }}</p>
    </div>
    <div class="vacancy__btns">
      <VacancyButton :big="false" @click="$router.push(`/vacancy/${vacancy.id}`)">Открыть</VacancyButton>
      <VacancyButton :big="false" @click="$emit('remove', vacancy)">Удалить</VacancyButton>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    vacancy: {
      type: Object,
      required: true
    }
  },
  methods: {
    formatNumber(n) {
      return Number(n).toLocaleString('ru-RU');
    }
  }
}
</script>

<style scoped>

.vacancy {
  margin-top: 15px;
  padding: 0 15px;
  border: 2px solid teal;
  border-radius: 15px;
  box-shadow: #5c636a 0 0 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
}

.formatted {
  white-space: pre-line;
}

.vacancy__btns {
  display: flex;
  flex-direction: column;
}

</style>