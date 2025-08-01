<template>
  <div class="pb-20 bg-dark min-h-screen">
    <!-- Header with Search -->
    <div class="px-4 pt-12 pb-6">
      <div class="relative">
        <MagnifyingGlassIcon class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" />
        <input 
          v-model="searchQuery"
          type="text" 
          placeholder="Search movies, shows..." 
          class="w-full bg-dark-card text-white pl-10 pr-4 py-3 rounded-lg border border-dark-lighter focus:outline-none focus:border-neon transition-colors"
        />
      </div>
    </div>

    <!-- Filter Chips -->
    <div class="px-4 mb-6">
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <button 
          v-for="filter in filters" 
          :key="filter.id"
          @click="activeFilter = filter.id"
          class="filter-chip flex-shrink-0"
          :class="{ active: activeFilter === filter.id }"
        >
          {{ filter.name }}
        </button>
      </div>
    </div>

    <!-- Trending Section -->
    <div class="px-4 mb-8">
      <SectionTitle title="Trending" :show-see-all="true" />
      <div class="space-y-3">
        <div 
          v-for="(movie, index) in trending" 
          :key="movie.id"
          class="flex items-center gap-4 p-3 bg-dark-card rounded-xl"
          @click="goToMovie(movie.id)"
        >
          <div class="flex-shrink-0 w-8 h-8 bg-neon rounded-full flex items-center justify-center">
            <span class="text-black font-bold text-sm">#{{ index + 1 }}</span>
          </div>
          <img 
            :src="movie.thumbnail" 
            :alt="movie.title"
            class="w-16 h-16 object-cover rounded-lg"
          />
          <div class="flex-1">
            <h3 class="text-white font-medium">{{ movie.title }}</h3>
            <p class="text-gray-400 text-sm">{{ movie.year }} • {{ movie.genre }}</p>
          </div>
          <ChevronRightIcon class="w-5 h-5 text-gray-400" />
        </div>
      </div>
    </div>

    <!-- For You Section -->
    <div class="px-4 mb-8">
      <SectionTitle title="For You" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in forYou" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>

    <!-- Exploring the Space Section -->
    <div class="px-4 mb-8">
      <SectionTitle title="Exploring the Space" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in spaceMovies" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { MagnifyingGlassIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import MovieCard from '../components/MovieCard.vue'
import SectionTitle from '../components/SectionTitle.vue'

const router = useRouter()
const searchQuery = ref('')
const activeFilter = ref('featured')

const filters = ref([
  { id: 'featured', name: 'Featured' },
  { id: 'drama', name: 'Drama' },
  { id: 'scifi', name: 'Sci-Fi' },
  { id: 'thriller', name: 'Thriller' },
  { id: 'action', name: 'Action' },
  { id: 'comedy', name: 'Comedy' }
])

const trending = ref([
  {
    id: 10,
    title: 'Wednesday',
    year: '2022',
    genre: 'Mystery',
    thumbnail: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop'
  },
  {
    id: 11,
    title: 'The Queen\'s Gambit',
    year: '2020',
    genre: 'Drama',
    thumbnail: 'https://images.unsplash.com/photo-1596877826717-e4c28d3e9b11?w=200&h=200&fit=crop'
  },
  {
    id: 12,
    title: 'Squid Game',
    year: '2021',
    genre: 'Thriller',
    thumbnail: 'https://images.unsplash.com/photo-1611348586804-61bf6c080437?w=200&h=200&fit=crop'
  }
])

const forYou = ref([
  {
    id: 13,
    title: 'The Witcher',
    year: '2019',
    thumbnail: 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=200&h=300&fit=crop'
  },
  {
    id: 14,
    title: 'House of Cards',
    year: '2013',
    thumbnail: 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=200&h=300&fit=crop'
  },
  {
    id: 15,
    title: 'Breaking Bad',
    year: '2008',
    thumbnail: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=200&h=300&fit=crop'
  }
])

const spaceMovies = ref([
  {
    id: 16,
    title: 'Interstellar',
    year: '2014',
    thumbnail: 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=200&h=300&fit=crop'
  },
  {
    id: 17,
    title: 'Gravity',
    year: '2013',
    thumbnail: 'https://images.unsplash.com/photo-1502134249126-9f3755a50d78?w=200&h=300&fit=crop'
  },
  {
    id: 18,
    title: 'The Martian',
    year: '2015',
    thumbnail: 'https://images.unsplash.com/photo-1457364887197-9150188c107b?w=200&h=300&fit=crop'
  }
])

const goToMovie = (id) => {
  router.push(`/movie/${id}`)
}
</script>