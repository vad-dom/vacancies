<template>
  <VacancyLoading v-if="isVacanciesLoading" />
  <h2 v-else-if="!vacancies.length" style="color: red">Пока еще нет ни одной вакансии</h2>
  <div v-else="">
    <div class="tools">
      <h3>Найдено вакансий: {{ pagination.totalCount }}</h3>
      <div class="sort">
        <VacancySelect v-model="selectedSort" :options="sortOptions" :disabledOption="true"/>
        <VacancySelect v-model="selectedOrder" :options="orderOptions"/>
      </div>
    </div>
    <div v-if="!isVacanciesLoading">
      <transition-group name="vacancy-list">
        <VacancyItem
          :key="vacancy.id"
          :vacancy="vacancy"
          v-for="vacancy in vacancies"
          @remove="removeVacancy"
        />
      </transition-group>
      <div class="page__wrapper">
        <button
            v-for="page in pagination.pageCount"
            :key="page"
            :class="{'active': pagination.page === page}"
            @click="changePage(page)"
        >
          {{ page }}
        </button>
      </div>
    </div>
    <VacancyLoading v-else />
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
        page: 1
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
      this.vacancies = this.vacancies.filter(v => v.id !== vacancy.id);
      try {
        const res = await axios.delete(baseUrl + '/site/delete/', {
          params: {
            id: vacancy.id
          }
        });
        console.log(res);
        await this.fetchVacancies()
      } catch (e) {
        console.log(e);
      }
    },
    changePage(page) {
      this.pagination.page = page
    },
    async fetchVacancies() {
      //const res = await fetch('https://jsonplaceholder.typicode.com/posts?_limit=3');
      //return await res.json();
      try {
        this.isVacanciesLoading = true;
        const res = await axios.get(baseUrl + '/site/list', {
          params: {
            page: this.pagination.page,
            pageSize: this.pagination.pageSize,
            sort: this.selectedSort,
            order: this.selectedOrder
          }
        });
        //this.totalPages = res.data.totalPages;
        //this.totalRows = res.data.totalRows;
        console.log(res);
        this.vacancies = res.data.vacancies;
        this.pagination = res.data.pagination;
      } catch (e) {
        console.log(e);
        alert('Произошла ошибка при получении постов');
      } finally {
        this.isVacanciesLoading = false;
      }
    }

  },
  mounted() {
    this.fetchVacancies();
  },
  watch: {
    page() {
      this.fetchVacancies();
    },
    selectedSort() {
      this.fetchVacancies();
    },
    selectedOrder() {
      this.fetchVacancies();
    },
  },
  computed: {
    page() {
      return this.pagination.page
    },
/*
    sortedVacancies() {
      return [...this.vacancies].sort((post1, post2) => post1[this.selectedSort]?.localeCompare(post2[this.selectedSort]))
    }
*/
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

.page__wrapper {
  margin-top: 15px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 4px;
}

.page__wrapper button {
  //border: 1px solid black;
  //padding: 10px;
  padding: 6px 10px;
  border-radius: 5px;
  cursor: pointer;
}

.page__wrapper button.active {
  //border: 2px solid teal;
  background-color: #006400;
  color: white;
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