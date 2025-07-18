<template>
  <div>
    <div class="header">
      <div>
        <VacancyHeader>Вакансия</VacancyHeader>
        <VacancyButton @click="$router.push('/')">Список вакансий</VacancyButton>
      </div>
      <div>
        <div v-for="field in requiredFields" :key="field" class="field__options">
          <label>
            <input type="checkbox" checked disabled/>
            {{ fieldLabels[field] || field }}
          </label>
        </div>
        <div v-for="field in optionalFields" :key="field" class="field__options">
          <label>
            <input
              type="checkbox"
              :value="field"
              v-model="selectedOptions"
              @change="fetchVacancy($route.params.id)"
            />
            {{ fieldLabels[field] || field }}
          </label>
        </div>
      </div>
    </div>
    <div v-if="!isVacancyLoading">
      <div class="vacancy">
        <h2>{{ vacancy.title }}</h2>
        <VacancyFormattedSalary :salary="Number(vacancy.salary) || 0" />
        <p class="formatted">{{ vacancy.short_details }}</p>
      </div>
      <p v-if="selectedOptions.includes('full_details') && !vacancy.full_details" class="empty">
        Полное описание пока еще не добавлено
      </p>
      <p v-else class="formatted details">{{ vacancy.full_details }}</p>
    </div>
    <VacancyLoading v-else />
  </div>
</template>

<script>
import axios from "axios";
import { baseUrl } from "@/config.js";

export default {
  data() {
    return {
      vacancy: {},
      isVacancyLoading: false,
      requiredFields: ['title', 'salary', 'short_details'],
      optionalFields: ['full_details'],
      fieldLabels: {
        title: 'Название вакансии',
        salary: 'Зарплата',
        short_details: 'Краткое описание',
        full_details: 'Полное описание',
      },
      selectedOptions: [],
    }
  },
  methods: {
    async fetchVacancy(id) {
      try {
        this.isVacancyLoading = true;
        const res = await axios.get(baseUrl + '/vacancy/card', {
          params: {
            id: id,
            fields: this.selectedFields.join(','),
          }
        });
        this.vacancy = res.data;
      } catch (e) {
        if (e.response.status === 404) {
          alert(e.response.data.message);
          this.$router.push('/');
        } else {
          alert('Непредвиденная ошибка. Попробуйте еще раз')
        }
      } finally {
        this.isVacancyLoading = false;
      }
    },
  },
  mounted() {
    this.fetchVacancy(this.$route.params.id)
  },
  computed: {
    selectedFields() {
      return [...this.requiredFields, ...this.selectedOptions];
    }
  }
}
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 20px;
}

.field__options {
  white-space: nowrap;
}

.vacancy {
  margin-top: 15px;
  padding: 0 15px;
  border: 2px solid teal;
  border-radius: 15px;
  box-shadow: #5c636a 0 0 10px;
}

.formatted {
  white-space: pre-line;
}

.details {
  margin-top: 30px;
  text-align: justify;
}

.empty {
  text-align: center;
  color: red;
}
</style>