<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Dashboard Principal</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Usuários Cadastrados</p>
        <h2 class="text-3xl font-bold">{{ stats.users }}</h2>
      </div>
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Notificações</p>
        <h2 class="text-3xl font-bold">{{ stats.notifications }}</h2>
      </div>
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
        <p class="text-sm text-gray-500">Perguntas no Chatbot</p>
        <h2 class="text-3xl font-bold">{{ stats.chatQuestions }}</h2>
      </div>
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Linha: Evolução de Usuários -->
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Evolução de Usuários</h2>
        <div class="h-64">
          <LineChart :data="chartUsers" :options="chartOptions" />
        </div>
      </div>

      <!-- Barras: Notificações por mês -->
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Notificações por Mês</h2>
        <div class="h-64">
          <BarChart :data="chartNotifications" :options="chartOptions" />
        </div>
      </div>

      <!-- Pizza: Perguntas no Chatbot (dinâmico) -->
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-4">Tipos de Perguntas</h2>
        <div class="h-64">
          <PieChart :data="chartQuestions" :options="chartOptions" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, BarElement, ArcElement, CategoryScale, LinearScale, PointElement } from 'chart.js'
import { Line as LineChart, Bar as BarChart, Pie as PieChart } from 'vue-chartjs'
import { ref } from 'vue'

defineOptions({ layout: AdminLayout })

const props = defineProps({
  stats: Object,  // { users, notifications, chatQuestions }
  charts: Object, // { usersPerMonth, notificationsPerMonth, chatQuestionsByType }
})

ChartJS.register(Title, Tooltip, Legend, LineElement, BarElement, ArcElement, CategoryScale, LinearScale, PointElement)

// Labels fixos para meses
const monthLabels = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"]

// Gráfico de usuários por mês
const chartUsers = ref({
  labels: monthLabels,
  datasets: [
    {
      label: "Usuários",
      data: monthLabels.map((_, i) => props.charts.usersPerMonth[i + 1] ?? 0),
      borderColor: "#3b82f6",
      backgroundColor: "#3b82f6",
      fill: false,
    },
  ],
})

// Gráfico de notificações por mês
const chartNotifications = ref({
  labels: monthLabels,
  datasets: [
    {
      label: "Notificações",
      data: monthLabels.map((_, i) => props.charts.notificationsPerMonth[i + 1] ?? 0),
      backgroundColor: "#10b981",
    },
  ],
})

// Gráfico de perguntas no chatbot (dinâmico)
const chartQuestions = ref({
  labels: Object.keys(props.charts.chatQuestionsByType || {}),
  datasets: [
    {
      label: "Perguntas",
      data: Object.values(props.charts.chatQuestionsByType || {}),
      backgroundColor: ["#f59e0b", "#3b82f6", "#ef4444", "#8b5cf6", "#ec4899"], // cores extras se houver mais categorias
    },
  ],
})

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
})
</script>
