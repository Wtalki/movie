<template>
  <div class="movie-card relative h-48" @click="$emit('click')">
    <div class="relative">
      <img 
        :src="movie.thumbnail" 
        :alt="movie.title"
        class="w-full h-32 object-cover"
      />
      <!-- Type indicator badge -->
      <div class="absolute top-2 left-2">
        <span 
          class="px-2 py-1 text-xs font-medium rounded-md"
          :class="movie.type === 'movie' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white'"
        >
          {{ movie.type === 'movie' ? 'Movie' : 'Series' }}
        </span>
      </div>
      <div v-if="showPlayButton" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="w-12 h-12 bg-white bg-opacity-80 rounded-full flex items-center justify-center">
          <PlayIcon class="w-6 h-6 text-black ml-1" />
        </div>
      </div>
      <div v-if="movie.progress" class="absolute bottom-0 left-0 right-0 h-1 bg-gray-600">
        <div class="h-full bg-neon" :style="{ width: `${movie.progress}%` }"></div>
      </div>
    </div>
    <div v-if="showDetails" class="p-3 flex-1 flex flex-col">
      <h3 class="text-sm font-medium text-white mb-1 line-clamp-2 flex-1">{{ movie.title }}</h3>
      <p class="text-xs text-gray-400">{{ movie.year }}</p>
    </div>
  </div>
</template>

<script setup>
import { PlayIcon } from '@heroicons/vue/24/solid'

defineProps({
  movie: {
    type: Object,
    required: true
  },
  showPlayButton: {
    type: Boolean,
    default: false
  },
  showDetails: {
    type: Boolean,
    default: true
  }
})

defineEmits(['click'])
</script>