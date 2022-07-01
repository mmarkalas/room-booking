<script setup lang="ts">
import LoginForm from '@/components/auth/LoginForm.vue'
</script>

<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-8 mx-auto">
        <div class="card login p-5">
          <h1 class="mb-3">Sign In</h1>
          <LoginForm />
        </div>
      </div>
    </div>
  </div>
</template>
