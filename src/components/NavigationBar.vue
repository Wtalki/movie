<template>
  <nav class="fixed bottom-0 left-0 right-0 bg-dark-card border-t border-dark-lighter">
    <div class="flex justify-around items-center h-16 px-4">
      <router-link to="/" class="nav-item" :class="{ active: $route.path === '/' }">
        <HomeIcon class="w-6 h-6" />
        <span class="text-xs mt-1">Home</span>
      </router-link>
      
      <router-link to="/search" class="nav-item" :class="{ active: $route.path === '/search' }">
        <MagnifyingGlassIcon class="w-6 h-6" />
        <span class="text-xs mt-1">Search</span>
      </router-link>
      
      <div class="nav-item">
        <HeartIcon class="w-6 h-6" />
        <span class="text-xs mt-1">Favorites</span>
      </div>
      
      <div class="nav-item">
        <UserIcon class="w-6 h-6" />
        <span class="text-xs mt-1">Profile</span>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { HomeIcon, MagnifyingGlassIcon, HeartIcon, UserIcon } from '@heroicons/vue/24/outline'
</script>