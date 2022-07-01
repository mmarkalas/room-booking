import { createRouter, createWebHistory } from 'vue-router'

import authGuard from '../guards/auth'

const authRouter = [
  {
    path: '/login',
    name: 'login',
    beforeEnter : authGuard,
    component: () => import('../../views/auth/LoginView.vue')
  },
  {
    path: '/register',
    name: 'register',
    beforeEnter : authGuard,
    component: () => import('../../views/auth/RegistrationView.vue')
  },
]

export default authRouter
