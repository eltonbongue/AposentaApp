<template>
  <aside
    :class="[
      'bg-white dark:bg-gray-800 text-gray-700 dark:text-white shadow-lg w-64 space-y-6 py-7 px-4 absolute md:relative z-10 inset-y-0 left-0 transform transition duration-200 ease-in-out',
      isOpen ? 'translate-x-0' : '-translate-x-full'
    ]"
  >
    <nav>
      <h2 class="text-xl font-bold mb-6">Painel Admin</h2>

      <ul class="space-y-3">
           <li>
          <a href="#" class="flex items-center space-x-2 hover:text-indigo-600 transition">
            <i class="fas fa-users"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li>
          <a href="/admin/users" class="flex items-center space-x-2 hover:text-indigo-600 transition">
            <i class="fas fa-users"></i>
            <span>Usuários</span>
          </a>
        </li>
        <li>
          <a href="/admin/notificacoes" class="flex items-center space-x-2 hover:text-indigo-600 transition">
            <i class="fas fa-bell"></i>
            <span>Notificações</span>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center space-x-2 hover:text-indigo-600 transition">
            <i class="fas fa-cog"></i>
            <span>Configurações</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script setup>
defineProps({ isOpen: Boolean });
defineEmits(['toggle']);
</script>
