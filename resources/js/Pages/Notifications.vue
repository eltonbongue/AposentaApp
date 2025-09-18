<template>
  <AppLayout>
    <div class="p-6 bg-white rounded shadow max-w-4xl mx-auto space-y-6">
      <h1 class="text-2xl font-bold text-indigo-700">
        🔔 Minhas Notificações ({{ unreadCount }})
      </h1>

      <div v-if="notifications.length > 0" class="space-y-4">
        <div
          v-for="n in notifications"
          :key="n.id"
          class="p-4 bg-gray-100 rounded shadow flex flex-col"
        >
          <div>
            <p>{{ n.mensagem }}</p>
            <small class="text-gray-500">{{ new Date(n.created_at).toLocaleString() }}</small>
          </div>

          <div
            class="flex space-x-3 mt-3 items-center"
          >
            <span v-if="!n.lida" class="text-sm text-red-500">
              Não lida
            </span>

            <button
              v-if="!n.lida"
              @click="markAsRead(n.id)"
              class="bg-indigo-600 text-white rounded hover:bg-indigo-800 transition
                     text-xs sm:text-sm px-3 py-1"
            >
              Marcar como lida
            </button>

            <button
              @click="deleteNotification(n.id)"
              :disabled="excluindoId === n.id"
              class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition text-sm disabled:opacity-50"
            >
              {{ excluindoId === n.id ? 'Excluindo...' : 'Excluir' }}
            </button>
          </div>
        </div>
      </div>

      <div v-else class="text-gray-500">
        Nenhuma notificação no momento.
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  notifications: {
    type: Array,
    default: () => []
  },
  unreadCount: {
    type: Number,
    default: 0
  }
})

const notifications = ref([...props.notifications])
const unreadCount = ref(props.unreadCount)
const excluindoId = ref(null) // controla o botão "Excluir" em loading

const markAsRead = async (id) => {
  try {
    const { data } = await axios.post(route('api.notifications.read', id))

    const notif = notifications.value.find(n => n.id === id)
    if (notif) notif.lida = true

    unreadCount.value = data.unread_count
  } catch (error) {
    console.error('Erro ao marcar notificação como lida:', error)
  }
}

const deleteNotification = async (id) => {
  const confirmacao = confirm('Tem certeza que deseja excluir esta notificação?')
  if (!confirmacao) return

  try {
    excluindoId.value = id
    await axios.delete(route('api.notifications.destroy', id))
    notifications.value = notifications.value.filter(n => n.id !== id)
  } catch (error) {
    console.error('Erro ao excluir notificação:', error)
  } finally {
    excluindoId.value = null
  }
}
</script>