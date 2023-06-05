import { createRouter, createWebHistory } from 'vue-router'
// import HomeView from '../views/HomeView.vue'
import WelcomeView from '../views/WelcomeView.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [

    {
      path: '/',
      name: 'welcome',
      component: WelcomeView
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/RegisterView.vue')
    },
    {
      path: '/delUser',
      name: 'DelUser',
      component: () => import('../views/User/DelUser.vue')
    },
    {
      path: '/addUser',
      name: 'AddUser',
      component: () => import('../views/User/AddUser.vue')
    },
    {
      path: '/editUser',
      name: 'EditUser',
      component: () => import('../views/User/EditUser.vue')
    },
    {
      path: '/showUser',
      name: 'ShowUser',
      component: () => import('../views/User/ShowUser.vue')
    },
  ]
})

export default router
