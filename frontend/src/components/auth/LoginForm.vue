<template>
  <form class="form-group">
    <input v-model="username" type="text" class="form-control mb-3" placeholder="Username" required>
    <input v-model="password" type="password" class="form-control mb-3" placeholder="Password" required>
    <input type="submit" class="btn btn-primary  mb-3" @click="(e) => submitLogin(e)">
    <p>
      Don't have an account? <RouterLink to="/register">Sign up here</RouterLink>
    </p>
  </form>
</template>

<script setup lang="ts">
  import router from '@/router';
  import AuthService from '@/services/auth/auth-service';
  import { Ref, ref } from '@vue/reactivity';

  const authService = new AuthService();
  const username: Ref<string> = ref('');
  const password: Ref<string> = ref('');

  const submitLogin = async (e: any) => {
    e.preventDefault();

    const result = await authService.login({
      username: username.value,
      password: password.value
    });

    if(result.success) {
      alert(result.message);
      router.push('/')
    }
  }
</script>

<style scoped>

</style>
