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
      errors: {},
      process: false,
    }
  },
  methods: {
    async addVacancy(vacancy) {
      if (this.process) {
        return;
      }
      this.process = true;
      this.errors = {};
      try {
        const csrfRes = await fetch(baseUrl + '/vacancy/csrf', {
          method: 'GET',
          headers: {
            'Cache-Control': 'no-cache',
          }
        });
        const { param, token } = await csrfRes.json();
        const formData = new FormData();
        formData.append(param, token);
        for (const key in vacancy) {
          formData.append(`Vacancy[${key}]`, vacancy[key])
        }
        const res = await fetch(baseUrl + '/vacancy/save', {
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
      } finally {
        this.process = false;
      }
    },

  }
}
</script>

<style scoped>

</style>