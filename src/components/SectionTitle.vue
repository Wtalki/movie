<template>
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-lg font-semibold text-white">{{ title }}</h2>
    <button v-if="showSeeAll" class="text-neon text-sm hover:underline">
      See All
    </button>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  showSeeAll: {
    type: Boolean,
    default: false
  }
})
</script>