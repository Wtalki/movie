<template>
  <div class="px-4 mb-6">
    <SectionTitle title="Categories" />
    <div class="flex gap-3 overflow-x-auto scroll-container pb-2">
      <button
        v-for="category in categories"
        :key="category.id"
        :class="[
          'filter-chip whitespace-nowrap flex-shrink-0',
          { 'active': selectedCategory === category.id }
        ]"
        @click="selectCategory(category.id)"
      >
        {{ category.name }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import SectionTitle from './SectionTitle.vue'

const emit = defineEmits(['category-changed'])

const selectedCategory = ref('all')

const categories = ref([
  { id: 'all', name: 'All' },
  { id: 'action', name: 'Action' },
  { id: 'comedy', name: 'Comedy' },
  { id: 'drama', name: 'Drama' },
  { id: 'horror', name: 'Horror' },
  { id: 'sci-fi', name: 'Sci-Fi' },
  { id: 'thriller', name: 'Thriller' },
  { id: 'romance', name: 'Romance' },
  { id: 'animation', name: 'Animation' },
  { id: 'documentary', name: 'Documentary' }
])

const selectCategory = (categoryId) => {
  selectedCategory.value = categoryId
  emit('category-changed', categoryId)
}
</script>