import { createRouter, createWebHistory } from 'vue-router'
import VacanciesPage from "@/pages/VacanciesPage.vue";
import Main from "@/pages/Main.vue";
import VacancyCard from "@/pages/VacancyCard.vue";
import VacancyInput from "@/pages/VacancyInput.vue";

const routes = [
    {
        path: '/',
        component: VacanciesPage
    },
    {
        path: '/about',
        component: Main
    },
    {
        path: '/vacancies/:id',
        component: VacancyCard
    },
    {
        path: '/new',
        component: VacancyInput
    }
]

const router = createRouter({
    routes,
    history: createWebHistory()
})

export default router