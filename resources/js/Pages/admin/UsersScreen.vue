<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Gestão de Utilizadores</h1>

    <!-- Barra de ações -->
    <div class="flex items-center justify-between mb-6">
      <input
        v-model="search"
        @keyup.enter="searchUsers"
        type="text"
        placeholder="Pesquisar por nome ou email..."
        class="w-1/3 px-4 py-2 rounded-lg border focus:ring focus:ring-indigo-300"
      />
    </div>

    <!-- Tabela de usuários -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
      <table class="w-full border-collapse">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
          <tr>
            <th class="p-4 text-left">#</th>
            <th class="p-4 text-left">Nome</th>
            <th class="p-4 text-left">Email</th>
            <th class="p-4 text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users.data"
            :key="user.id"
            class="border-t hover:bg-gray-50 dark:hover:bg-gray-700"
          >
            <td class="p-4">{{ user.id }}</td>
            <td class="p-4 font-medium">{{ user.name }}</td>
            <td class="p-4">{{ user.email }}</td>
            <td class="p-4 text-center space-x-2">
              <button
                @click="deleteUser(user.id)"
                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow"
              >
                Excluir
              </button>
            </td>
          </tr>

          <tr v-if="users.data.length === 0">
            <td colspan="4" class="p-6 text-center text-gray-500">
              Nenhum usuário encontrado.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginação -->
    <div class="flex justify-between items-center mt-4">
      <p class="text-sm text-gray-600">
        Mostrando {{ users.from }} até {{ users.to }} de {{ users.total }}
      </p>
      <div class="flex space-x-2">
        <button
          v-if="users.prev_page_url"
          @click="router.visit(users.prev_page_url)"
          class="px-3 py-1 border rounded hover:bg-gray-100"
        >
          Anterior
        </button>
        <button
          v-if="users.next_page_url"
          @click="router.visit(users.next_page_url)"
          class="px-3 py-1 border rounded hover:bg-gray-100"
        >
          Próxima
        </button>
      </div>
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
      type: Object,
      required: true,
    },
    filters: {
      type: Object,
      default: () => ({}),
    },
  },
  setup(props) {
    const search = ref(props.filters?.search || '')

    // 🔎 Pesquisa usuários
    function searchUsers() {
      router.get(route('admin.users'), { search: search.value }, { preserveState: true, replace: true })
    }

    // 🗑️ Apagar usuário
    function deleteUser(id) {
      if (confirm('Tem certeza que deseja remover este usuário?')) {
        router.delete(route('admin.users.destroy', id))
      }
    }

    return {
      users: props.users,
      search,
      searchUsers,
      deleteUser,
      router,
    }
  },
}
</script>
