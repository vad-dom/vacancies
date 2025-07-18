import { createRouter, createWebHistory } from 'vue-router'
import VacancyListPage from "@/pages/VacancyListPage.vue";
import VacancyCardPage from "@/pages/VacancyCardPage.vue";
import VacancyFormPage from "@/pages/VacancyFormPage.vue";

const routes = [
    {
        path: '/',
        component: VacancyListPage,
    },
    {
        path: '/vacancy/:id',
        component: VacancyCardPage,
    },
    {
        path: '/vacancy/new',
        component: VacancyFormPage,
    }
]

const router = createRouter({
    routes,
    history: createWebHistory()
})

export default router