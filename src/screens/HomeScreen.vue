<template>
  <div class="pb-20 bg-dark min-h-screen">
    <!-- Header Section -->
    <div class="px-4 pt-12 pb-6">
      <h1 class="text-2xl font-bold text-white mb-2">Good evening, Alex</h1>
      <p class="text-gray-400">Ready for binge watching?</p>
    </div>

    <!-- Featured Banner -->
    <div class="px-4 mb-8">
      <div class="relative rounded-xl overflow-hidden shadow-lg bg-dark-card">
        <img 
          src="https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=400&h=235&fit=crop"
          alt="Featured Movie"
          class="w-full aspect-movie object-cover"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent">
          <div class="absolute bottom-6 left-6 right-6">
            <h2 class="text-xl font-bold text-white mb-2">Stranger Things</h2>
            <p class="text-sm text-gray-300 mb-4">A group of young friends witness supernatural forces...</p>
            <button class="bg-neon text-black px-6 py-2 rounded-lg font-medium flex items-center">
              <PlayIcon class="w-5 h-5 mr-2" />
              Play
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Continue Watching -->
    <div class="px-4 mb-8">
      <SectionTitle title="Continue Watching" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in continueWatching" 
          :key="movie.id"
          class="flex-shrink-0 w-32"
        >
          <MovieCard 
            :movie="movie" 
            :show-play-button="true"
            @click="goToMovie(movie.id)"
          />
        </div>
      </div>
    </div>

    <!-- What's New -->
    <div class="px-4 mb-8">
      <SectionTitle title="What's New" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in whatsNew" 
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

    <!-- Some Thrills -->
    <div class="px-4 mb-8">
      <SectionTitle title="Some Thrills" :show-see-all="true" />
      <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
        <div 
          v-for="movie in thrills" 
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
import { PlayIcon } from '@heroicons/vue/24/solid'
import MovieCard from '../components/MovieCard.vue'
import SectionTitle from '../components/SectionTitle.vue'

const router = useRouter()

const continueWatching = ref([
  {
    id: 1,
    title: 'The Dark Knight',
    year: '2008',
    thumbnail: 'https://images.unsplash.com/photo-1518929458119-e5bf444c30f4?w=200&h=300&fit=crop',
    progress: 65
  },
  {
    id: 2,
    title: 'Inception',
    year: '2010',
    thumbnail: 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=200&h=300&fit=crop',
    progress: 30
  },
  {
    id: 3,
    title: 'Interstellar',
    year: '2014',
    thumbnail: 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=200&h=300&fit=crop',
    progress: 90
  }
])

const whatsNew = ref([
  {
    id: 4,
    title: 'Dune: Part Two',
    year: '2024',
    thumbnail: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=200&h=300&fit=crop'
  },
  {
    id: 5,
    title: 'Avatar: The Way of Water',
    year: '2022',
    thumbnail: 'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?w=200&h=300&fit=crop'
  },
  {
    id: 6,
    title: 'Top Gun: Maverick',
    year: '2022',
    thumbnail: 'https://images.unsplash.com/photo-1478720568477-b0a8d129c8d4?w=200&h=300&fit=crop'
  }
])

const thrills = ref([
  {
    id: 7,
    title: 'John Wick 4',
    year: '2023',
    thumbnail: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=200&h=300&fit=crop'
  },
  {
    id: 8,
    title: 'Mad Max: Fury Road',
    year: '2015',
    thumbnail: 'https://images.unsplash.com/photo-1434394354979-a235cd36269d?w=200&h=300&fit=crop'
  },
  {
    id: 9,
    title: 'Mission: Impossible',
    year: '2023',
    thumbnail: 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=200&h=300&fit=crop'
  }
])

const goToMovie = (id) => {
  router.push(`/movie/${id}`)
}
</script>