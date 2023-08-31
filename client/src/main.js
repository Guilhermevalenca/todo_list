/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'

// Plugins
import { registerPlugins } from '@/plugins'

// Axios
import axios from 'axios';
import Swal from "sweetalert2";

const app = createApp(App)

registerPlugins(app)

app.mount('#app');

axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

axios.interceptors.request.use((config) => {
  // console.log(config);
  return config;
});
axios.interceptors.response.use(function (response) {
  return response;
},function (error) {
  if(error.response.status === 429) {
    Swal.fire({
      title: 'Error',
      text: 'Você foi proibido temporariamente de realizar algumas ações no site, por motivos de segurança'
    });
  }
  return Promise.reject(error);
});
