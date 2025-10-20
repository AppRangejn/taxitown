import axios from 'axios';

axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8080' // бекенд
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8080';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
