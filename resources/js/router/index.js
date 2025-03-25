import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/auth/Login.vue';
import UserDashboard from '../components/Pages/UserDashboard.vue';
import AdminDashboard from '../components/Pages/AdminDashboard.vue';

// Définition des routes
const routes = [
  {
    path: '/login',
    name: 'Login', // Nom de la route (facultatif mais recommandé)
    component: Login,
  },
  {
    path: '/user/dashboard', // Utilisation d'un slash au lieu d'un point pour la cohérence
    name: 'UserDashboard', // Nom de la route
    component: UserDashboard,
    meta: { requiresAuth: true, role: 'user' }, // Métadonnées pour la protection de la route
  },
  {
    path: '/admin/dashboard', // Utilisation d'un slash au lieu d'un point pour la cohérence
    name: 'AdminDashboard', // Nom de la route
    component: AdminDashboard,
    meta: { requiresAuth: true, role: 'admin' }, // Métadonnées pour la protection de la route
  },
  // Redirection par défaut (optionnel)
  {
    path: '/', // Route racine
    redirect: '/login', // Redirige vers la page de connexion par défaut
  },
  // Route pour les pages non trouvées (optionnel)
  {
    path: '/:pathMatch(.*)*', // Capture toutes les routes non définies
    redirect: '/login', // Redirige vers la page de connexion
  },
];

// Création du routeur
const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Middleware de navigation (protection des routes)
router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth-token'); // Vérifie si l'utilisateur est authentifié
  const userRole = localStorage.getItem('user-role'); // Récupère le rôle de l'utilisateur

  // Vérifie si la route nécessite une authentification
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login'); // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
  } else if (to.meta.requiresAuth && to.meta.role !== userRole) {
    next('/login'); // Redirige vers la page de connexion si le rôle ne correspond pas
  } else {
    next(); // Continue la navigation
  }
});

// Exportez le routeur pour l'utiliser dans l'application
export default router;