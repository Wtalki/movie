import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import './style.css'
import App from './App.vue'
import HomeScreen from './screens/HomeScreen.vue'
import SearchScreen from './screens/SearchScreen.vue'
import MovieDetailScreen from './screens/MovieDetailScreen.vue'

const routes = [
  { path: '/', component: HomeScreen },
  { path: '/search', component: SearchScreen },
  { path: '/movie/:id', component: MovieDetailScreen, props: true }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

createApp(App).use(router).mount('#app')