import axios from 'axios'

axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8000' // бекенд
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
