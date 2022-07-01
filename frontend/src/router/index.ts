import { createRouter, createWebHistory } from 'vue-router'
import authRouter from './modules/auth'
import bookingRouter from './modules/booking'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    ...authRouter,
    ...bookingRouter,
  ]
})

export default router
