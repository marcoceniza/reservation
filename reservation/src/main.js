import './assets/main.css'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';
import axios from 'axios';

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const axiosRes = axios.create({
    baseURL: 'https://dating-app2023.000webhostapp.com/reservationAPI'
});

export default axiosRes;

const app = createApp(App)

app.use(router)

app.mount('#app')
