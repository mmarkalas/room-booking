import { createApp } from 'vue'
import Vue3Storage, { StorageType } from 'vue3-storage'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)

app.use(Vue3Storage, { 
  namespace: "room_booking_",
  storage: StorageType.Local 
})

app.mount('#app')
