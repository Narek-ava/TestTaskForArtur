import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.css';
import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from './components/pages/LoginPage.vue';
import RegisterPage from './components/pages/RegisterPage.vue';
import DashboardPage from './components/pages/DashboardPage.vue';
import CreateOrder from "./components/pages/CreateOrder.vue";
import UpdateOrder from "./components/pages/UpdateOrder.vue";

axios.defaults.baseURL = "http://localhost:8000"
axios.interceptors.request.use(function (config) {
    return config;
});

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: LoginPage },
        { path: '/register', component: RegisterPage },
        { path: '/dashboard', component: DashboardPage },
        { path: '/create/order', component: CreateOrder},
        {  path: '/update/order/:orderId',
            component: UpdateOrder,
            props: true
        },
    ],
});

createApp(App).use(router).mount('#app');