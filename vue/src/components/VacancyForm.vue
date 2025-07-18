<template>
  <form @submit.prevent="addVacancy">
    <VacancyHeader>Создание вакансии</VacancyHeader>
    <div :class="{'error': errors.title}" class="field__wrapper">
      <VacancyInput v-model="vacancy.title" type="text" placeholder="Название" @input="errors.title = null" />
      <div v-if="errors.title" class="error-text">{{ errors.title[0] }}</div>
    </div>
    <div :class="{'error': errors.salary}" class="field__wrapper">
      <VacancyInput v-model="vacancy.salary" type="number" placeholder="Зарплата" @input="errors.salary = null" />
      <div v-if="errors.salary" class="error-text">{{ errors.salary[0] }}</div>
    </div>
    <div :class="{'error': errors.short_details}" class="field__wrapper">
      <VacancyTextArea v-model="vacancy.short_details" placeholder="Краткое описание" @input="errors.short_details = null" />
      <div v-if="errors.short_details" class="error-text">{{ errors.short_details[0] }}</div>
    </div>
    <div :class="{'error': errors.full_details}" class="field__wrapper">
      <VacancyTextArea v-model="vacancy.full_details" placeholder="Полное описание" rows="15" @input="errors.full_details = null" />
      <div v-if="errors.full_details" class="error-text">{{ errors.full_details[0] }}</div>
    </div>
    <div class="buttons">
      <VacancyButton type="submit">Создать вакансию</VacancyButton>
      <VacancyButton type="button" @click="$router.push('/')">Отмена</VacancyButton>
    </div>
  </form>
</template>

<script>

export default {
  name: "VacancyForm",
  props: {
    errors: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      vacancy: {
        title: '',
        salary: '',
        short_details: '',
        full_details: '',
      },
    }
  },
  methods: {
    addVacancy() {
      this.$emit('create', this.vacancy);
    }
  },
}
</script>

<style scoped>

form, .field__wrapper {
  display: flex;
  flex-direction: column;
}

.buttons {
  display: flex;
  justify-content: flex-end;
  flex-wrap: wrap;
  gap: 10px;
}

.error input, .error textarea {
  border: 2px solid red;
}
.error-text {
  color: red;
  font-size: 0.8em;
  margin-top: 4px;
}

</style>