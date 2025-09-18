<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const notifications = ref([])
const loading = ref(true)
const marcando = ref(null) // id da notificação em processo de marcação

// Buscar notificações do usuário logado
const fetchNotifications = async () => {
  loading.value = true
  try {
    const { data } = await axios.get('/api/notifications')

    // Garantir que recebemos um array
    notifications.value = Array.isArray(data) ? data : []
    console.log('Notificações recebidas:', notifications.value) // debug
  } catch (error) {
    console.error('Erro ao buscar notificações:', error)
    notifications.value = []
  } finally {
    loading.value = false
  }
}

// Marcar notificação como lida
const markAsRead = async (id) => {
  try {
    marcando.value = id
    await axios.post(`/api/notifications/${id}/read`)
    notifications.value = notifications.value.map(n =>
      n.id === id ? { ...n, lida: true } : n
    )
  } catch (error) {
    console.error('Erro ao marcar como lida:', error)
  } finally {
    marcando.value = null
  }
}

onMounted(() => {
  fetchNotifications()
  setInterval(fetchNotifications, 30000) // Polling a cada 30s
})
</script>

<template>
  <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">🔔 Minhas Notificações</h2>

    <div v-if="loading" class="text-gray-500">Carregando notificações...</div>

    <ul v-else-if="notifications.length > 0" class="space-y-3">
      <li
        v-for="notification in notifications"
        :key="notification.id"
        class="p-4 bg-white rounded shadow border flex justify-between items-start"
        :class="notification.lida ? 'opacity-70' : 'hover:bg-indigo-50 transition-all border-indigo-100'"
      >
        <div>
          <p class="font-medium text-indigo-700">
            {{ notification.mensagem }}
          </p>
          <p class="text-xs text-gray-400 mt-1">
            Recebido em: {{ new Date(notification.created_at).toLocaleString() }}
          </p>
        </div>

        <button
          v-if="!notification.lida"
          @click="markAsRead(notification.id)"
          :disabled="marcando === notification.id"
          class="ml-4 px-3 py-1 text-xs rounded bg-green-600 text-white hover:bg-green-700 disabled:opacity-50"
        >
          {{ marcando === notification.id ? '...' : 'Marcar como lida' }}
        </button>
      </li>
    </ul>

    <div v-else class="text-gray-500">Nenhuma notificação no momento.</div>
  </div>
</template>
