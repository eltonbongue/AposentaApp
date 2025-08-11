<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

// Dados de formulário
const currentAge = ref('');
const retirementAge = ref('');
const monthlyContribution = ref('');
const rate = ref(5);

const result = ref(null);

const calculate = () => {
  const years = retirementAge.value - currentAge.value;
  if (years > 0) {
    const n = years * 12;
    const r = rate.value / 100 / 12;
    let total = 0;
    for (let i = 0; i < n; i++) {
      total = (total + Number(monthlyContribution.value)) * (1 + r);
    }
    result.value = total.toFixed(2);
  } else {
    result.value = null;
  }
};
</script>

<template>
  <div>
    <Head :title="title" />
    <Banner />

    <div class="min-h-screen bg-blue-50">
      <!-- Navbar (pode manter seu layout existente aqui) -->
      <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-8">
              <Link :href="route('dashboard')">
                <ApplicationMark class="block h-9 w-auto" />
              </Link>

              <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                Dashboard
              </NavLink>
              <NavLink :href="route('calculateamount')" :active="route().current('calculateamount')">
                Cálculo do Montante
              </NavLink>
              <NavLink :href="route('simulatecenario')" :active="route().current('simulatecenario')">
                Simular Cenário
              </NavLink>
            </div>

            <div class="flex items-center gap-3">
              <span class="text-sm text-gray-600">{{ $page.props.auth.user.name }}</span>
              <button @click="logout" class="text-sm text-red-600 hover:underline">Sair</button>
            </div>
          </div>
        </div>
      </nav>

      <!-- Header -->
      <header class="bg-white shadow py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 class="text-2xl font-semibold text-gray-800">{{ title || 'Cálculo do Montante' }}</h1>
        </div>
      </header>

      <!-- Main Content -->
      <main class="max-w-3xl mx-auto p-6 sm:p-8">
        <div class="bg-white rounded-xl shadow p-6 space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Idade Atual</label>
              <input type="number" v-model="currentAge" placeholder="Ex: 30"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Idade da Aposentadoria</label>
              <input type="number" v-model="retirementAge" placeholder="Ex: 65"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Contribuição Mensal (em $)</label>
              <input type="number" v-model="monthlyContribution" placeholder="Ex: 200"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Taxa de Juros Anual (%)</label>
              <input type="number" v-model="rate" placeholder="5"
                     class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>
          </div>

          <button @click="calculate"
                  class="w-full py-3 mt-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
            Calcular Montante
          </button>

          <div v-if="result !== null" class="mt-6 bg-blue-100 text-blue-900 text-lg font-medium p-4 rounded-md">
            Montante estimado: <span class="font-semibold">${{ result }}</span>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
