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
    {
      path: '/showFlight',
      name: 'ShowFlight',
      component: () => import('../views/Flight/ShowFlight.vue')
    },
    {
      path: '/addFlight',
      name: 'AddFlight',
      component: () => import('../views/Flight/AddFlight.vue')
    },
    {
      path: '/editFlight',
      name: 'EditFlight',
      component: () => import('../views/Flight/EditFlight.vue')
    },
    {
      path: '/delFlight',
      name: 'DelFlight',
      component: () => import('../views/Flight/DelFlight.vue')
    },
    {
      path: '/showReservation',
      name: 'ShowReservation',
      component: () => import('../views/Reservation/ShowReservation.vue')
    },
    {
      path: '/addReservation',
      name: 'AddReservation',
      component: () => import('../views/Reservation/AddReservation.vue')
    },
    {
      path: '/editReservation',
      name: 'EditReservation',
      component: () => import('../views/Reservation/EditReservation.vue')
    },
    {
      path: '/delReservation',
      name: 'DelReservation',
      component: () => import('../views/Reservation/DelReservation.vue')
    },
    {
      path: '/addSeat',
      name: 'AddSeat',
      component: () => import('../views/Seat/AddSeat.vue')
    },
    {
      path: '/editSeat',
      name: 'EditSeat',
      component: () => import('../views/Seat/EditSeat.vue')
    },
    {
      path: '/delSeat',
      name: 'DelSeat',
      component: () => import('../views/Seat/DelSeat.vue')
    },
    {
      path: '/showSeat',
      name: 'ShowSeat',
      component: () => import('../views/Seat/ShowSeat.vue')
    },
    {
      path: '/showAircraft',
      name: 'ShowAircraft',
      component: () => import('../views/Aircraft/ShowAircraft.vue')
    },
    {
      path: '/addAircraft',
      name: 'AddAircraft',
      component: () => import('../views/Aircraft/AddAircraft.vue')
    },
    {
      path: '/editAircraft',
      name: 'EditAircraft',
      component: () => import('../views/Aircraft/EditAircraft.vue')
    },
    {
      path: '/delAircraft',
      name: 'DelAircraft',
      component: () => import('../views/Aircraft/DelAircraft.vue')
    },
    {
      path: '/showAirport',
      name: 'ShowAirport',
      component: () => import('../views/Airport/ShowAirport.vue')
    },
    {
      path: '/addAirport',
      name: 'AddAirport',
      component: () => import('../views/Airport/AddAirport.vue')
    },
    {
      path: '/editAirport',
      name: 'EditAirport',
      component: () => import('../views/Airport/EditAirport.vue')
    },
    {
      path: '/delAirport',
      name: 'DelAirport',
      component: () => import('../views/Airport/DelAirport.vue')
    },

  ]
})

export default router
