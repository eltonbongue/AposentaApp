<template>
  <aside
    :class="[ 
      'bg-blue-950 dark:bg-gray-800 text-gray-700 dark:text-white shadow-lg w-64 space-y-6 py-7 px-4 absolute md:relative z-10 inset-y-0 left-0 transform transition duration-200 ease-in-out',
      isOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <nav>
      <h2 class="text-xl text-white font-bold mb-6">Painel Admin</h2>

      <ul class="space-y-3">
        <li>
          <Link href="/admin/dashboard" class="flex text-white items-center space-x-2 hover:text-indigo-400 transition">
            <img src="/storage/img/dashboardd.png" alt="Ícone Dashboard" class="w-5 h-5" />
            <span>Dashboard</span>
          </Link>
        </li>

        <li>
          <Link href="/admin/users" class="flex text-white items-center space-x-2 hover:text-indigo-400 transition">
           <img src="/storage/img/users.png" alt="Ícone user" class="w-5 h-5" />
            <span>Usuários</span>
          </Link>
        </li>

        <li>
          <Link href="/admin/notificacoes" class="flex text-white items-center space-x-2 hover:text-indigo-400 transition">
          <img src="/storage/img/notification.png" alt="Ícone notification" class="w-5 h-5" />
            <span>Notificações</span>
          </Link>
        </li>

    <li>
  <Link
    :href="route('admin.logout')"
    method="post"
    as="button"
    class="flex text-white items-center space-x-2 hover:text-red-500 transition"
  >
   <img src="/storage/img/logout.png" alt="Ícone logout" class="w-5 h-5" />
    <span>Sair</span>
  </Link>
</li>

      </ul>
    </nav>
  </aside>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  isOpen: Boolean,
})
defineEmits(['toggle'])
</script>
