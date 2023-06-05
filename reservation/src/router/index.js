import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/pages/Home.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/admin/register',
      name: 'registerAdmin',
      component: () => import('../views/auth/Register.vue')
    },
    {
      path: '/admin',
      name: 'loginAdmin',
      component: () => import('../views/auth/Login.vue')
    },
    {
      path: '/admin/dashboard',
      name: 'adminDashboard',
      component: () => import('../views/pages/Dashboard.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/admin');
        JSON.parse(localStorage.getItem('user_info')).user_type == 1 ? next() : next('/admin');
      }
    },
    {
      path: '/admin/reservation',
      name: 'adminReservation',
      component: () => import('../views/pages/Reservation.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/admin');
        JSON.parse(localStorage.getItem('user_info')).user_type == 1 ? next() : next('/admin');
      }
    },
    {
      path: '/admin/rooms',
      name: 'adminRooms',
      component: () => import('../views/pages/Rooms.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/admin');
        JSON.parse(localStorage.getItem('user_info')).user_type == 1 ? next() : next('/admin');
      }
    },
    {
      path: '/admin/customers',
      name: 'adminCustomers',
      component: () => import('../views/pages/Customers.vue'),
      beforeEnter: (to, from, next) => {
        if (!localStorage.getItem('user_info')) return next('/admin');
        JSON.parse(localStorage.getItem('user_info')).user_type == 1 ? next() : next('/admin');
      }
    },
  ]
})

export default router;
