<template>
  <div>
    <VacancyHeader>Список вакансий</VacancyHeader>
    <VacancyButton @click="$router.push('/vacancy/new')">Создать вакансию</VacancyButton>
    <VacancyList/>
  </div>
</template>

<script>
import VacancyList from "@/components/VacancyList.vue";

export default {
  components: {
    VacancyList
  },
}
</script>

<style scoped>

</style>