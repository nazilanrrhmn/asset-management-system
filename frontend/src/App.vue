<script setup lang="ts">
import MainLayout from "./layouts/MainLayout.vue";
</script>

<template>
  <MainLayout>
    <router-view />
  </MainLayout>
</template>

<style scoped>
body {
  margin: 0;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
