<template>
  <VacancyForm @create="addVacancy" :errors="errors" />
</template>

<script>
import VacancyForm from "@/components/VacancyForm.vue";
import { baseUrl } from "@/config.js";

export default {
  components: {
    VacancyForm,
  },
  data() {
    return {
      errors: {}
    }
  },
  methods: {
    async addVacancy(vacancy) {
      try {
        const formData = new FormData()
        for (const key in vacancy) {
          formData.append(`Vacancy[${key}]`, vacancy[key])
        }
        const res = await fetch(baseUrl + '/site/save', {
          method: 'POST',
          body: formData,
        })
        let data = await res.json()
        if (data.success) {
          this.errors = {}
          this.$router.push(`/vacancy/${data.id}`);
        } else {
          this.errors = data.errors || {}
        }
      } catch (e) {
        alert('Непредвиденная ошибка. Попробуйте еще раз')
      }
    },

  }
}
</script>

<style scoped>

</style>