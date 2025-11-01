<template>
  <router-view />
</template>

<script setup>
import HomePage from './components/HomePage.vue';
import './router'
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-fontsmoothing: grayscale;
  color: var(--text);
  min-height: 100vh;
}
</style>