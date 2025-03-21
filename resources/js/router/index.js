import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/auth/Login.vue';
import UserDashboard from '../components/Pages/UserDashboard.vue';
import AdminDashboard from '../components/Pages/AdminDashboard.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/user-dashboard', component: UserDashboard },
  { path: '/admin-dashboard', component: AdminDashboard },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
