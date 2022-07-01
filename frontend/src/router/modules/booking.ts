import { createRouter, createWebHistory } from 'vue-router'
import authGuard from '../guards/auth'

const bookingRouter = [
  {
    path: '/',
    name: 'home',
    beforeEnter : authGuard,
    component: () => import('../../views/bookings/IndexView.vue')
  },
  {
    path: '/book',
    name: 'about',
    beforeEnter : authGuard,
    component: () => import('../../views/bookings/BookView.vue')
  }
]

export default bookingRouter
