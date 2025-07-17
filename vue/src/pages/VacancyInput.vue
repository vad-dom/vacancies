<template>
  <VacancyForm @create="addVacancy" :errors="errors" />
</template>

<script>
import VacancyForm from "@/components/VacancyForm.vue";
import {baseUrl} from "@/config.js";

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
        const FD = new FormData()
        for (const key in vacancy) {
          FD.append(`Vacancy[${key}]`, vacancy[key])
        }
/*
        FD.append('Vacancy[title]', vacancy.title)
        FD.append('Vacancy[salary]', vacancy.salary)
        FD.append('Vacancy[short_details]', vacancy.short_details)
        FD.append('Vacancy[full_details]', vacancy.full_details)
*/
        const res = await fetch(baseUrl + '/site/save', {
          method: 'POST',
          body: FD,
        })
        console.log(res)
        let data = await res.json()
        console.log(data)
        if (data.success) {
          this.errors = {}
          this.$router.push(`/vacancies/${data.id}`);
        } else {
          this.errors = data.errors || {}
        }
      } catch (e) {
        console.log(e)
      }
    },

  }
}
</script>

<style scoped>

</style>