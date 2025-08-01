<template>
  <div class="pb-20 bg-dark min-h-screen">
    <!-- Back Button -->
    <div class="absolute top-12 left-4 z-10">
      <button @click="$router.go(-1)" class="w-10 h-10 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
        <ArrowLeftIcon class="w-6 h-6 text-white" />
      </button>
    </div>

    <!-- Movie Poster -->
    <div class="relative">
      <img 
        :src="movie.poster" 
        :alt="movie.title"
        class="w-full h-96 object-cover"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-dark via-transparent to-transparent"></div>
    </div>

    <!-- Movie Info -->
    <div class="px-4 -mt-16 relative z-10">
      <h1 class="text-3xl font-bold text-white mb-2">{{ movie.title }}</h1>
      
      <!-- Movie Meta -->
      <div class="flex items-center gap-4 mb-4">
        <span class="text-gray-300">{{ movie.year }}</span>
        <div class="flex items-center gap-1">
          <StarIcon class="w-4 h-4 text-neon" />
          <span class="text-white">{{ movie.rating }}</span>
        </div>
        <span class="px-2 py-1 bg-gray-700 rounded text-xs text-white">HD</span>
        <span class="px-2 py-1 bg-gray-700 rounded text-xs text-white">CC</span>
      </div>

      <!-- Genre Tags -->
      <div class="flex gap-2 mb-6">
        <span 
          v-for="genre in movie.genres" 
          :key="genre"
          class="px-3 py-1 bg-dark-lighter rounded-full text-sm text-gray-300"
        >
          {{ genre }}
        </span>
      </div>

      <!-- Play Button -->
      <button class="w-full bg-neon text-black py-4 rounded-xl font-semibold text-lg flex items-center justify-center mb-6">
        <PlayIcon class="w-6 h-6 mr-2" />
        Play
      </button>

      <!-- Synopsis -->
      <div class="mb-8">
        <h3 class="text-lg font-semibold text-white mb-3">Synopsis</h3>
        <p class="text-gray-300 leading-relaxed">{{ movie.synopsis }}</p>
      </div>

      <!-- Tabs -->
      <div class="mb-6">
        <div class="flex border-b border-dark-lighter">
          <button 
            v-for="tab in tabs" 
            :key="tab.id"
            @click="activeTab = tab.id"
            class="flex-1 py-3 text-center transition-colors"
            :class="activeTab === tab.id ? 'text-neon border-b-2 border-neon' : 'text-gray-400'"
          >
            {{ tab.name }}
          </button>
        </div>
      </div>

      <!-- Tab Content -->
      <div v-if="activeTab === 'episodes'" class="space-y-4">
        <!-- Season Dropdown -->
        <div class="relative">
          <select v-model="selectedSeason" class="w-full bg-dark-card text-white p-3 rounded-lg border border-dark-lighter">
            <option v-for="season in movie.seasons" :key="season" :value="season">
              Season {{ season }}
            </option>
          </select>
        </div>
        
        <!-- Episodes List -->
        <div class="space-y-3">
          <div 
            v-for="episode in episodes" 
            :key="episode.id"
            class="flex items-center gap-4 p-4 bg-dark-card rounded-xl"
          >
            <img 
              :src="episode.thumbnail" 
              :alt="episode.title"
              class="w-20 h-12 object-cover rounded-lg"
            />
            <div class="flex-1">
              <h4 class="text-white font-medium">{{ episode.number }}. {{ episode.title }}</h4>
              <p class="text-gray-400 text-sm">{{ episode.duration }}</p>
            </div>
            <PlayIcon class="w-6 h-6 text-neon" />
          </div>
        </div>
      </div>

      <div v-else-if="activeTab === 'trailers'" class="space-y-4">
        <div 
          v-for="trailer in trailers" 
          :key="trailer.id"
          class="flex items-center gap-4 p-4 bg-dark-card rounded-xl"
        >
          <img 
            :src="trailer.thumbnail" 
            :alt="trailer.title"
            class="w-20 h-12 object-cover rounded-lg"
          />
          <div class="flex-1">
            <h4 class="text-white font-medium">{{ trailer.title }}</h4>
            <p class="text-gray-400 text-sm">{{ trailer.duration }}</p>
          </div>
          <PlayIcon class="w-6 h-6 text-neon" />
        </div>
      </div>

      <div v-else-if="activeTab === 'subtitles'" class="space-y-3">
        <div 
          v-for="subtitle in subtitles" 
          :key="subtitle.id"
          class="flex items-center justify-between p-4 bg-dark-card rounded-xl"
        >
          <div class="flex items-center gap-3">
            <div class="w-8 h-6 rounded bg-gray-600 flex items-center justify-center">
              <span class="text-xs text-white">{{ subtitle.code }}</span>
            </div>
            <span class="text-white">{{ subtitle.language }}</span>
          </div>
          <input type="checkbox" :checked="subtitle.enabled" class="accent-neon">
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { ArrowLeftIcon, StarIcon, PlayIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  id: String
})

const activeTab = ref('episodes')
const selectedSeason = ref(1)

const tabs = ref([
  { id: 'episodes', name: 'Episodes' },
  { id: 'trailers', name: 'Trailers & Extras' },
  { id: 'subtitles', name: 'Subtitles' }
])

const movie = ref({
  title: 'Stranger Things',
  year: '2016',
  rating: '8.7',
  genres: ['Mysteries', 'Sci-Fi', 'Dramas'],
  poster: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=400&h=600&fit=crop',
  synopsis: 'When a young boy disappears, his mother, a police chief and his friends must confront terrifying supernatural forces in order to get him back. A love letter to the supernatural classics of the 80s, Stranger Things is set in 1983 Indiana, where a young boy vanishes into thin air.',
  seasons: [1, 2, 3, 4]
})

const episodes = ref([
  {
    id: 1,
    number: 1,
    title: 'The Vanishing of Will Byers',
    duration: '47m',
    thumbnail: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=200&h=120&fit=crop'
  },
  {
    id: 2,
    number: 2,
    title: 'The Weirdo on Maple Street',
    duration: '55m',
    thumbnail: 'https://images.unsplash.com/photo-1518929458119-e5bf444c30f4?w=200&h=120&fit=crop'
  },
  {
    id: 3,
    number: 3,
    title: 'Holly, Jolly',
    duration: '51m',
    thumbnail: 'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=200&h=120&fit=crop'
  }
])

const trailers = ref([
  {
    id: 1,
    title: 'Official Trailer',
    duration: '2:15',
    thumbnail: 'https://images.unsplash.com/photo-1489599962684-9ab6e7e6e2b0?w=200&h=120&fit=crop'
  },
  {
    id: 2,
    title: 'Behind the Scenes',
    duration: '5:30',
    thumbnail: 'https://images.unsplash.com/photo-1518929458119-e5bf444c30f4?w=200&h=120&fit=crop'
  }
])

const subtitles = ref([
  { id: 1, language: 'English', code: 'EN', enabled: true },
  { id: 2, language: 'Spanish', code: 'ES', enabled: false },
  { id: 3, language: 'French', code: 'FR', enabled: false },
  { id: 4, language: 'German', code: 'DE', enabled: false }
])
</script>