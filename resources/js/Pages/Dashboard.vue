<template>
  <AppLayout>
    <div class="p-4 md:p-6 bg-gray-100 min-h-screen space-y-10">

      <!-- Cabeçalho -->
      <header class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white p-4 md:p-6 rounded shadow max-w-6xl mx-auto gap-4">
        <h1 class="text-2xl md:text-3xl font-bold text-indigo-700">Dashboard Financeira</h1>
        <button @click="openModal" class="btn flex items-center gap-2 w-full md:w-auto">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Atualizar Perfil Financeiro
        </button>
      </header>

      <!-- Metas -->
      <section class="p-4 md:p-6 bg-white rounded shadow max-w-6xl mx-auto">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Metas Financeiras</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center">
          <div class="bg-indigo-100 p-4 rounded">
            <p class="text-sm text-gray-600">Meta Anual</p>
            <p class="text-xl font-bold text-indigo-700">Kz {{ metas.meta_anual }}</p>
          </div>
          <div class="bg-green-100 p-4 rounded">
            <p class="text-sm text-gray-600">Meta Mensal</p>
            <p class="text-xl font-bold text-green-700">Kz {{ metas.meta_mensal }}</p>
          </div>
          <div class="bg-yellow-100 p-4 rounded">
            <p class="text-sm text-gray-600">Meta Semanal</p>
            <p class="text-xl font-bold text-yellow-700">Kz {{ metas.meta_semanal }}</p>
          </div>
          <div class="bg-gray-200 p-4 rounded">
            <p class="text-sm text-gray-600">Saldo Atual</p>
            <p class="text-xl font-bold text-gray-800">Kz {{ metas.saldo }}</p>
          </div>
        </div>
      </section>

      <!-- Modal -->
      <Modal :show="showModal" @close="closeModal">
        <template #default>
          <div class="p-6 bg-white rounded-lg w-full max-w-3xl mx-auto" @click.stop>
            <h2 class="text-lg font-bold mb-4">Atualizar Perfil Financeiro</h2>
            <form @submit.prevent="saveFinancialProfile" class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label>Idade Atual</label><input v-model="financialProfile.idade_actual" type="number" class="input" required /></div>
                <div><label>Idade para Aposentadoria</label><input v-model="financialProfile.idade_aposentadoria" type="number" class="input" required /></div>
                <div><label>Salário Atual</label><input v-model="financialProfile.salario_actual" type="number" class="input" required /></div>
                <div><label>Poupança Atual</label><input v-model="financialProfile.poupanca" type="number" class="input" required /></div>
                <div><label>Investimentos</label><input v-model="financialProfile.investimentos" type="number" class="input" required /></div>
                <div><label>Despesas mensais estimadas(Kz)</label><input v-model="financialProfile.montante_aposentadoria" type="number" class="input" required /></div>
                <div><label>Retorno de Investimento Anual (%)</label><input v-model="financialProfile.retorno_investimento_anual" type="number" step="0.01" class="input" required /></div>
                <div><label>Inflação Anual (%)</label><input v-model="financialProfile.inflacao_anual" type="number" step="0.01" class="input" required /></div>
              <div><label>Duração esperada da aposentadoria (anos)</label><input v-model="financialProfile.duracao_aposentadoria" type="number" class="input" required /></div>
              </div>

              <div class="flex justify-end mt-6">
                <button type="submit" class="btn" :disabled="loading">
                  {{ loading ? 'Salvando...' : 'Salvar' }}
                </button>
              </div>

              <p v-if="errorMessage" class="text-red-600 mt-2">{{ errorMessage }}</p>
              <p v-if="successMessage" class="text-green-600 mt-2">{{ successMessage }}</p>
            </form>
          </div>
        </template>
      </Modal>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Modal from '@/Components/Modal.vue'
import axios from 'axios'

const showModal = ref(false)
const loading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

const financialProfile = ref({
  idade_actual: null,
  idade_aposentadoria: null,
  duracao_aposentadoria: null,
  salario_actual: null,
  poupanca: null,
  investimentos: null,
  montante_aposentadoria: null,
  retorno_investimento_anual: null,
  inflacao_anual: null,
})

const metas = ref({
  meta_anual: 0,
  meta_mensal: 0,
  meta_semanal: 0,
  saldo: 0,
})

const openModal = () => {
  errorMessage.value = ''
  successMessage.value = ''
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
}

const carregarPerfilFinanceiro = async () => {
  try {
    const res = await axios.get('/profile/financial-profile')
    financialProfile.value = { ...financialProfile.value, ...res.data.financialProfile }
  } catch (e) {
    console.error('Erro ao carregar perfil financeiro:', e)
  }
}

const carregarMetas = async () => {
  try {
    const res = await axios.get('/profile/financial-profile/metas')
    metas.value = res.data
  } catch (e) {
    console.error('Erro ao carregar metas:', e)
  }
}


const parseProfileData = () => ({
  idade_actual: Number(financialProfile.value.idade_actual),
  idade_aposentadoria: Number(financialProfile.value.idade_aposentadoria),
  duracao_aposentadoria: Number(financialProfile.value.duracao_aposentadoria),
  salario_actual: Number(financialProfile.value.salario_actual),
  poupanca: Number(financialProfile.value.poupanca),
  investimentos: Number(financialProfile.value.investimentos),
  montante_aposentadoria: Number(financialProfile.value.montante_aposentadoria),
  retorno_investimento_anual: Number(financialProfile.value.retorno_investimento_anual),
  inflacao_anual: Number(financialProfile.value.inflacao_anual),
})

const saveFinancialProfile = async () => {
  loading.value = true
  errorMessage.value = ''
  successMessage.value = ''
  try {
    await axios.put('/profile/financial-profile', parseProfileData())
    successMessage.value = 'Perfil financeiro salvo com sucesso!'
    await carregarPerfilFinanceiro()
    await carregarMetas()
    closeModal()
  } catch (e) {
    if (e.response?.status === 422) {
      const errors = e.response.data.errors
      errorMessage.value = Object.values(errors).flat().join(' ')
    } else {
      errorMessage.value = 'Erro ao salvar perfil financeiro.'
    }
    console.error(e)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  carregarPerfilFinanceiro()
  carregarMetas()
})
</script>

<style scoped>
.input {
  @apply w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500;
}
.btn {
  @apply bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed;
}
</style>
