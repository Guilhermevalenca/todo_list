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

// Sweetalert2
import Swal from "sweetalert2";

const app = createApp(App)

registerPlugins(app)

app.mount('#app');

const baseURL = (import.meta.env.VITE_API_PREFIX + import.meta.env.VITE_API_BASE_URL + ':' + import.meta.env.VITE_API_PORT + '/' + import.meta.env.VITE_API_SUFFIX).toString();

axios.defaults.baseURL = baseURL;
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
