<template>
  <div class="max-w-4xl mx-auto space-y-8">
    <h1 class="text-2xl font-bold mb-6">📢 Gerenciar Notificações</h1>

    <!-- Nova Notificação -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow space-y-4">
      <h2 class="text-lg font-semibold">Nova Notificação</h2>

      <textarea
        v-model="mensagem"
        rows="4"
        placeholder="Escreva a mensagem da notificação..."
        class="w-full border rounded-lg px-4 py-2 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-300"
      ></textarea>

      <div class="flex items-center space-x-4">
        <select
          v-model="userId"
          class="border rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white"
        >
          <option :value="null">Todos os Usuários</option>
          <option
            v-for="user in users"
            :key="user.id"
            :value="user.id"
          >
            {{ user.name }} ({{ user.email }})
          </option>
        </select>

        <button
          @click="enviarNotificacao"
          :disabled="carregando"
          class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow disabled:opacity-50"
        >
          {{ carregando ? 'Enviando...' : 'Enviar Notificação' }}
        </button>
      </div>
    </div>

    <!-- Lista de Notificações Enviadas -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow space-y-4">
      <h2 class="text-lg font-semibold">Notificações Enviadas</h2>

      <div v-if="notifications.length === 0" class="text-gray-500">
        Nenhuma notificação enviada ainda.
      </div>

      <table v-else class="w-full text-sm text-left">
        <thead>
          <tr class="text-gray-700 dark:text-gray-300 border-b">
            <th class="px-2 py-2">Mensagem</th>
            <th class="px-2 py-2">Usuário</th>
            <th class="px-2 py-2">Enviada em</th>
            <th class="px-2 py-2">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="notification in notifications"
            :key="notification.id"
            class="border-t dark:border-gray-700"
          >
            <td class="px-2 py-2">
              {{ notification.mensagem }}
            </td>
            <td class="px-2 py-2">
              {{ notification.user ? `${notification.user.name} (${notification.user.email})` : 'Todos os usuários' }}
            </td>
            <td class="px-2 py-2">
              {{ formatarData(notification.created_at) }}
            </td>
            <td class="px-2 py-2">
              <button
                @click="removerNotificacao(notification.id)"
                class="text-red-600 hover:underline"
              >
                Remover
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default {
  layout: AdminLayout,
  props: {
    users: {
      type: Array,
      required: true
    },
    notifications: {
      type: Array,
      required: true
    }
  },
  setup(props) {
    const mensagem = ref('')
    const userId = ref(null)
    const carregando = ref(false)
    
    // Criando uma versão reativa das notificações
    const notifications = ref([...props.notifications])

    // Enviar Notificação
    const enviarNotificacao = () => {
      if (!mensagem.value.trim()) {
        alert('Escreva uma mensagem antes de enviar!')
        return
      }

      carregando.value = true
      router.post(
        route('admin.notifications.store'),
        { mensagem: mensagem.value, user_id: userId.value },
        {
          preserveScroll: true,
          onSuccess: () => {
            mensagem.value = ''
            userId.value = null
            alert('Notificação enviada com sucesso!')
            // Atualizar a lista de notificações localmente
            notifications.value.push({
              mensagem: mensagem.value,
              user_id: userId.value,
              created_at: new Date()
            })
          },
          onFinish: () => (carregando.value = false)
        }
      )
    }

    // Remover Notificação
   const removerNotificacao = (id) => {
  if (!confirm('Tem certeza que deseja remover esta notificação?')) return;

  // Impedir que o Inertia navegue após a exclusão
  event.preventDefault(); // Impede o comportamento de navegação

  router.delete(route('admin.notifications.destroy', id), {
    preserveScroll: true, // Preserva o scroll na página
    onSuccess: () => {
      alert('Notificação removida com sucesso!');
      // Remover da lista de notificações localmente
      const index = notifications.value.findIndex(notification => notification.id === id);
      if (index !== -1) {
        notifications.value.splice(index, 1); // Remove a notificação da lista
      }
    },
    onError: () => {
      alert('Erro ao remover a notificação!');
    }
  });
};


    // Função para formatar data
    const formatarData = (data) => {
      return new Date(data).toLocaleString('pt-BR')
    }

    return {
      users: props.users,
      notifications,
      mensagem,
      userId,
      carregando,
      enviarNotificacao,
      removerNotificacao,
      formatarData
    }
  }
}
</script>
