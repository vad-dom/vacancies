<template>
  <div class="vacancy">
    <div class="item__header">
      <div>
        <h2>{{ vacancy.title }}</h2>
        <VacancyFormattedSalary :salary="Number(vacancy.salary) || 0" />
      </div>
      <div class="buttons">
        <VacancyButton :big="false" @click="$router.push(`/vacancy/${vacancy.id}`)">Открыть</VacancyButton>
        <VacancyButton :big="false" @click="$emit('remove', vacancy)">Удалить</VacancyButton>
      </div>
    </div>
    <p class="formatted">{{ vacancy.short_details }}</p>
  </div>
</template>

<script>
export default {
  props: {
    vacancy: {
      type: Object,
      required: true
    },
  },
}
</script>

<style scoped>
.vacancy {
  margin-top: 15px;
  padding: 0 15px;
  border: 2px solid teal;
  border-radius: 15px;
  box-shadow: #5c636a 0 0 10px;
}

.item__header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
}

.formatted {
  white-space: pre-line;
}

.buttons {
  display: flex;
  flex-direction: column;
}

@media (max-width: 480px) {
  .item__header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0;
  }

  .buttons {
    flex-direction: row;
    justify-content: space-between;
    align-self: stretch;
  }
}
</style>