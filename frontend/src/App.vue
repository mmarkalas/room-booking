<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <section class="vh-100">
    <div class="d-flex align-items-center h-100 bg-danger">
      <RouterView />
    </div>
  </section>
</template>

<style>
@import '@/assets/base.css';

#app {
  width: 100%;
  margin: auto;
}

</style>
