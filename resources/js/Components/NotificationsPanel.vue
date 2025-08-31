<!-- resources/js/Components/NotificationsPanel.vue -->

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const notifications = ref([])
const loading = ref(true)

const fetchNotifications = async () => {
  try {
    const response = await axios.get('/api/notifications')
    notifications.value = response.data
  } catch (error) {
    console.error('Erro ao buscar notificações:', error)
  } finally {
    loading.value = false
  }
}

// Simples polling a cada 30 segundos (pode ser trocado por Laravel Echo)
onMounted(() => {
  fetchNotifications()
  setInterval(fetchNotifications, 30000)
})
</script>

<template>
  <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Notificações</h2>

    <div v-if="loading" class="text-gray-500">Carregando notificações...</div>

    <ul v-else-if="notifications.length > 0" class="space-y-3">
      <li
        v-for="(notification, index) in notifications"
        :key="index"
        class="p-4 bg-white rounded shadow hover:bg-indigo-50 transition-all border border-indigo-100"
      >
        <p class="font-medium text-indigo-700">{{ notification.data.title }}</p>
        <p class="text-sm text-gray-600">{{ notification.data.message }}</p>
        <p class="text-xs text-gray-400 mt-1">
          Recebido em: {{ new Date(notification.created_at).toLocaleString() }}
        </p>
      </li>
    </ul>

    <div v-else class="text-gray-500">Nenhuma notificação no momento.</div>
  </div>
</template>
