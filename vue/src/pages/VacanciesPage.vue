<template>
  <div>
    <VacancyH1 :marginBottom="'20px'">Список вакансий</VacancyH1>
    <MyButton>
      <router-link to="/new" style="text-decoration: none; color: inherit;">Создать вакансию</router-link>
    </MyButton>
    <VacancyList/>
  </div>
</template>

<script>
import VacancyList from "@/components/VacancyList.vue";
import axios from "axios";
import { baseUrl } from "@/config.js";

export default {
  components: {
    VacancyList
  },
  data() {
    return {

    }
  },
  methods: {
    async addVacancy(vacancy) {
      try {
        //const param = document.querySelector('meta[name="csrf-param"]').getAttribute('content')
        //const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

        const FD = new FormData()
        //FD.append(param, token)
        //FD.append('_token', 'csrf')
        FD.append('Vacancy[title]', vacancy.title)
        FD.append('Vacancy[salary]', vacancy.salary)
        FD.append('Vacancy[short_details]', vacancy.short_details)
        FD.append('Vacancy[full_details]', vacancy.full_details)

        //let token = this.getCrsfToken()
        /*
        const res = axios.post(baseUrl + '/site/save', {
          vacancy: vacancy
        })
        */
        const res = await fetch(baseUrl + '/site/save', {
          method: 'POST',
          body: FD,
        })
        console.log(res)
      } catch (e) {
        console.log(e)
      }
      this.vacancies.push(vacancy);
      this.dialogVisible = false;
    },
    showDialog() {
      this.dialogVisible = true
    },
    async fetchVacancies() {
      //const res = await fetch('https://jsonplaceholder.typicode.com/posts?_limit=3');
      //return await res.json();
      try {
        this.isVacanciesLoading = true;
        /*
        const res = await fetch(baseUrl + '/site/list', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            //'X-Requested-With': 'XMLHttpRequest',
            //'Access-Control-Allow-Origin': '*',
            //'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
            //'Access-Control-Allow-Headers': "Content-Type, Authorization, X-Requested-With",
          },
          body: JSON.stringify({
            page: this.page,
            limit: this.limit
          })
        });
         */
        const res = await axios.get(baseUrl + '/site/list', {
          params: {
            page: this.page,
            limit: this.limit,
          }
        });
        /*
        const res = await axios.get('https://jsonplaceholder.typicode.com/posts', {
          params: {
            _page: this.page,
            _limit: this.limit,
          }
        });
         */
        this.totalPages = res.data.totalPages;
        this.totalRows = res.data.totalRows;
        console.log(res);
        //const data = await res.json();
        //console.log(data);
        //this.posts = data;
        //this.posts = await res.json();
        this.vacancies = res.data.rows;
      } catch (e) {
        console.log(e);
        alert('Произошла ошибка при получении постов');
      } finally {
        this.isVacanciesLoading = false;
      }
    }
  },
}

</script>

<style scoped>

</style>