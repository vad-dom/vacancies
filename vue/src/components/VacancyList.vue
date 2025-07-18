<template>
  <VacancyLoading v-if="isVacanciesLoading" />
  <h2 v-else-if="!pagination.totalCount" style="color: red">Пока еще нет ни одной вакансии</h2>
  <div v-else>
    <div class="tools">
      <h3>Найдено вакансий: {{ pagination.totalCount }}</h3>
      <div class="sort">
        <VacancySelect v-model="selectedSort" :options="sortOptions" :disabledOption="true"/>
        <VacancySelect v-model="selectedOrder" :options="orderOptions"/>
      </div>
    </div>
    <transition-group name="vacancy-list">
      <VacancyItem
        :key="vacancy.id"
        :vacancy="vacancy"
        v-for="vacancy in vacancies"
        @remove="removeVacancy"
      />
    </transition-group>
    <VacancyPagination
      :page="pagination.page"
      :pageCount="pagination.pageCount"
      @update:page="changePage"
    />
  </div>
</template>

<script>
import VacancyItem from "@/components/VacancyItem.vue";
import axios from "axios";
import {baseUrl} from "@/config.js";

export default {
  components: {
    VacancyItem
  },
  data() {
    return {
      vacancies: [],
      isVacanciesLoading: false,
      pagination: {
        totalCount: 0,
        pageSize: 10,
        pageCount: 1,
        page: 1,
      },
      sortOptions: [
        {value: 'salary', name: 'По зарплате'},
        {value: 'created_at', name: 'По дате создания'},
      ],
      selectedSort: '',
      orderOptions: [
        {value: 'asc', name: 'По возрастанию'},
        {value: 'desc', name: 'По убыванию'},
      ],
      selectedOrder: 'asc',
    }
  },
  methods: {
    async removeVacancy(vacancy) {
      if (!confirm('Удалить вакансию?')) {
        return;
      }
      this.vacancies = this.vacancies.filter(v => v.id !== vacancy.id);
      try {
        const res = await axios.delete(baseUrl + '/site/delete/', {
          params: {
            id: vacancy.id,
          }
        });
        if (res.data.success === false) {
          alert('Непредвиденная ошибка. Попробуйте еще раз');
        }
      } catch (e) {
        if (e.response.status === 404) {
          alert(e.response.data.message);
        } else {
          alert('Непредвиденная ошибка. Попробуйте еще раз');
        }
      } finally {
        await this.fetchVacancies();
      }
    },
    changePage(page) {
      this.pagination.page = page;
    },
    async fetchVacancies() {
      try {
        this.isVacanciesLoading = true;
        const res = await axios.get(baseUrl + '/site/list', {
          params: {
            page: this.pagination.page,
            pageSize: this.pagination.pageSize,
            sort: this.selectedSort,
            order: this.selectedOrder,
          }
        });
        this.vacancies = res.data.vacancies;
        this.pagination = res.data.pagination;
      } catch (e) {
        alert('Непредвиденная ошибка. Попробуйте еще раз');
      } finally {
        this.isVacanciesLoading = false;
      }
    }
  },
  mounted() {
    this.fetchVacancies();
  },
  watch: {
    'pagination.page'() {
      this.fetchVacancies();
    },
    selectedSort() {
      this.fetchVacancies();
    },
    selectedOrder() {
      this.fetchVacancies();
    },
  },
}
</script>

<style scoped>
.tools {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 20px;
}

h3 {
  margin: 0;
  white-space: nowrap;
}

.sort {
  display: flex;
  gap: 10px;
}

.vacancy-list-item {
  display: inline-block;
  margin-right: 10px;
}
.vacancy-list-enter-active,
.vacancy-list-leave-active {
  transition: all 0.3s ease;
}
.vacancy-list-enter-from,
.vacancy-list-leave-to {
  opacity: 0;
  transform: translateX(130px);
}
.vacancy-list-move {
  transition: transform 0.4s ease;
}
</style>