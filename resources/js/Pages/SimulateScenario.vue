<script setup>
import { ref, computed, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Inputs controlados pelo usuário
const despesasMensais = ref(300000);
const idadeAtual = ref(30);
const idadeAposentadoria = ref(60);
const inflacao = ref(10);
const anosAposentado = ref(20);
const retornoInvestimento = ref(6);
const valorAcumulado = ref(2000000);
const salarioMensal = ref(250000);

// Resultado reativo
const montanteNecessario = ref(0);
const poupancaMensal = ref(0);
const percentualSalario = ref(0);

const calcularMontante = () => {
  const d = despesasMensais.value;
  const i = idadeAtual.value;
  const a = idadeAposentadoria.value;
  const inf = inflacao.value / 100;
  const anos = anosAposentado.value;
  const roi = retornoInvestimento.value / 100;
  const acumulado = valorAcumulado.value;
  const sal = salarioMensal.value;

  const anosAteAposentar = a - i;
  const meses = anosAteAposentar * 12;
  const despesasAnuais = d * 12;
  const fatorInflacao = Math.pow(1 + inf, anosAteAposentar);
  const despesasCorrigidas = despesasAnuais * fatorInflacao;

  // Montante total necessário na aposentadoria considerando anos apos aposentadoria e retorno dos investimentos
  const fatorROI = (1 - Math.pow(1 + roi, -anos)) / roi;
  const montante = despesasCorrigidas * fatorROI;

  montanteNecessario.value = montante;

  // Cálculo da poupança mensal necessária
  const rMensal = roi / 12;
  const futuroInvestido = acumulado * Math.pow(1 + rMensal, meses);
  const valorRestante = montante - futuroInvestido;

  let poupanca = 0;
  if (valorRestante > 0) {
    poupanca = (valorRestante * rMensal) / (Math.pow(1 + rMensal, meses) - 1);
  }
  poupancaMensal.value = poupanca;

  percentualSalario.value = (poupanca / sal) * 100;
};

// Recalcula sempre que algum input mudar
watch(
  [
    despesasMensais,
    idadeAtual,
    idadeAposentadoria,
    inflacao,
    anosAposentado,
    retornoInvestimento,
    valorAcumulado,
    salarioMensal,
  ],
  calcularMontante,
  { immediate: true }
);

// Resetar todos inputs para valores padrão
const resetar = () => {
  despesasMensais.value = 300000;
  idadeAtual.value = 30;
  idadeAposentadoria.value = 60;
  inflacao.value = 10;
  anosAposentado.value = 20;
  retornoInvestimento.value = 6;
  valorAcumulado.value = 2000000;
  salarioMensal.value = 250000;
};
</script>

<template>
  <AppLayout title="Simulação de Cenários Financeiros">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Simulação de Cenários Financeiros
      </h2>
    </template>

    <div class="py-12 bg-gray-100 min-h-screen">
      <div class="max-w-5xl mx-auto px-6 lg:px-8">
        <div class="bg-white p-8 rounded-lg shadow-md space-y-8">
          <!-- Inputs de simulação -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block font-medium text-gray-700">Despesas mensais estimadas (Kz)</label>
              <input
                v-model.number="despesasMensais"
                type="number"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Idade atual</label>
              <input
                v-model.number="idadeAtual"
                type="number"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Idade de aposentadoria desejada</label>
              <input
                v-model.number="idadeAposentadoria"
                type="number"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Inflação anual estimada (%)</label>
              <input
                v-model.number="inflacao"
                type="number"
                step="0.1"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Anos esperados após aposentadoria</label>
              <input
                v-model.number="anosAposentado"
                type="number"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Retorno anual com investimento (%)</label>
              <input
                v-model.number="retornoInvestimento"
                type="number"
                step="0.1"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Valor já acumulado (Kz)</label>
              <input
                v-model.number="valorAcumulado"
                type="number"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>

            <div>
              <label class="block font-medium text-gray-700">Salário mensal atual (Kz)</label>
              <input
                v-model.number="salarioMensal"
                type="number"
                class="mt-1 w-full border-gray-300 rounded-md shadow-sm"
                min="0"
              />
            </div>
          </div>

          <!-- Resultados -->
          <div class="bg-indigo-50 rounded-lg p-6">
            <h3 class="text-xl font-semibold text-indigo-700 mb-4">Resultados da Simulação</h3>
            <p>
              <strong>Montante necessário para aposentadoria:</strong>
              <span class="text-indigo-900">{{ montanteNecessario.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} Kz</span>
            </p>
            <p>
              <strong>Você precisará guardar mensalmente:</strong>
              <span class="text-indigo-900">{{ poupancaMensal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} Kz</span>
            </p>
            <p>
              <strong>Isso corresponde a:</strong>
              <span class="text-indigo-900">{{ percentualSalario.toFixed(2) }}%</span> do seu salário mensal.
            </p>
          </div>

          <!-- Botões de ação -->
          <div class="flex justify-end gap-4">
            <button
              @click="resetar"
              class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
            >
              Resetar valores
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
