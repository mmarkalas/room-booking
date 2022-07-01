<template>
  <form class="form-group">
    <input v-model="name" type="text" class="form-control mb-3" placeholder="Name" required>
    <input v-model="username" type="text" class="form-control mb-3" placeholder="Username" required>
    <input v-model="email" type="email" class="form-control mb-3" placeholder="Email" required>
    <input v-model="password" type="password" class="form-control mb-3" placeholder="Password" required>
    <input v-model="passwordConfirmation" type="password" class="form-control mb-3" placeholder="Confirm Password" required>
    <input type="submit" class="btn btn-primary mb-3" @click="(e) => submitReg(e)">
    <p>Already have an account? <RouterLink to="/login">Sign in here</RouterLink>
    </p>
  </form>
</template>

<script setup lang="ts">
  import AuthService from '@/services/auth/auth-service';
  import { type Ref, ref } from 'vue';

  const authService = new AuthService();

  const name: Ref<string> = ref('');
  const username: Ref<string> = ref('');
  const email: Ref<string> = ref('');
  const password: Ref<string> = ref('');
  const passwordConfirmation: Ref<string> = ref('');

  const submitReg = async (e) => {
    e.preventDefault();

    const result = await authService.register({
      name: name.value,
      username: username.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value,
    });

    result.then((res) => {
      if(result.success) {
        alert(res.message);
        router.push('/')
      }
    }).catch((e) => {
        alert(e.message);
    }) 
  }
</script>

<style scoped>

</style>