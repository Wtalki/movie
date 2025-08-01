<template>
  <div class="min-h-screen bg-dark">
    <router-view />
    <NavigationBar />
  </div>
</template>

<script setup>
import NavigationBar from './components/NavigationBar.vue'
</script>