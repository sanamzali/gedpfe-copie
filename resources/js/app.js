import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/auth/Login.vue';
import AdminDashboard from './components/Pages/AdminDashboard.vue';
import UserDashboard from './components/Pages/UserDashboard.vue';
import App from './App.vue';
import '../css/app.css';



// Vérifiez si ce bloc est dupliqué
const routes = [
    { path: '/login', component: Login} ,
    { path: '/admin/dashboard', component: AdminDashboard },
    { path: '/user/dashboard', component: UserDashboard },


];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);
app.use(router);
app.mount('#app');
