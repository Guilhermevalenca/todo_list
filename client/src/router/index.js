import { createRouter, createWebHashHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/HomeView.vue')
  },
  {
    path: '/todos',
    name: 'todo',
    component: () => import('@/views/TodosView.vue')
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
