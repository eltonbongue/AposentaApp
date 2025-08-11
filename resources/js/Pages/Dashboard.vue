<script setup>
import { ref, watch, onMounted } from 'vue';
import ApexCharts from 'apexcharts';
import AppLayout from '@/Layouts/AppLayout.vue';

const despesasMensais = ref(300000);
const idadeAtual = ref(30);
const idadeAposentadoria = ref(60);
const inflacao = ref(10);
const anosAposentado = ref(20);
const retornoInvestimento = ref(6);
const valorAcumulado = ref(2000000);
const salarioMensal = ref(250000);

const alerta = ref('');

const calcularMontante = () => {
  const d = despesasMensais.value;
  const i = idadeAtual.value;
  const a = idadeAposentadoria.value;
  const inf = inflacao.value / 100;
  const anos = anosAposentado.value;
  const roi = retornoInvestimento.value / 100;
  const acumulado = valorAcumulado.value;

  const anosAteAposentar = a - i;
  const meses = anosAteAposentar * 12;
  const despesasAnuais = d * 12;
  const fatorInflacao = Math.pow(1 + inf, anosAteAposentar);
  const despesasCorrigidas = despesasAnuais * fatorInflacao;

  const fatorROI = (1 - Math.pow(1 + roi, -anos)) / roi;
  const montante = despesasCorrigidas * fatorROI;

  // Cálculo poupança mensal
  const rMensal = roi / 12;
  const futuroInvestido = acumulado * Math.pow(1 + rMensal, meses);
  const valorRestante = montante - futuroInvestido;

  let poupanca = 0;
  if (valorRestante > 0) {
    poupanca = (valorRestante * rMensal) / (Math.pow(1 + rMensal, meses) - 1);
  }

  const percentual = (poupanca / salarioMensal.value) * 100;

  return {
    montante: montante.toFixed(2),
    poupanca: poupanca.toFixed(2),
    percentual: percentual.toFixed(1),
  };
};

const resultado = ref(calcularMontante());

const montarGrafico = () => {
  const anos = idadeAposentadoria.value - idadeAtual.value;
  const meses = anos * 12;
  const roiMensal = retornoInvestimento.value / 100 / 12;
  const poupancaMensal = parseFloat(resultado.value.poupanca);
  const valores = [];
  let acumulado = valorAcumulado.value;

  for (let m = 0; m <= meses; m++) {
    acumulado = acumulado * (1 + roiMensal) + poupancaMensal;
    valores.push(parseFloat(acumulado.toFixed(2)));
  }

  const options = {
    chart: {
      type: 'line',
      height: 320,
      toolbar: { show: false },
      animations: {
        enabled: true,
        easing: 'easeinout',
        speed: 800,
      },
    },
    stroke: { curve: 'smooth' },
    series: [{ name: 'Patrimônio acumulado', data: valores }],
    xaxis: {
      categories: Array.from({ length: meses + 1 }, (_, i) => `Mês ${i}`),
      title: { text: 'Tempo (meses)' },
    },
    yaxis: {
      labels: {
        formatter: val => `Kz ${val.toLocaleString()}`,
      },
      title: { text: 'Montante acumulado' },
    },
    tooltip: {
      y: { formatter: val => `Kz ${val.toLocaleString()}` },
    },
    colors: ['#4f46e5'],
  };

  const chartEl = document.querySelector('#patrimonio-chart');
  if (chartEl) {
    if (window.apexChartInstance) {
      window.apexChartInstance.updateOptions(options);
    } else {
      window.apexChartInstance = new ApexCharts(chartEl, options);
      window.apexChartInstance.render();
    }
  }
};

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
  () => {
    resultado.value = calcularMontante();

    // Alertas simples
    if (resultado.value.percentual > 30) {
      alerta.value = 'Você está poupando mais de 30% do seu salário! Excelente!';
    } else if (resultado.value.percentual < 10) {
      alerta.value = 'Alerta: poupança abaixo de 10% do salário. Considere aumentar!';
    } else {
      alerta.value = '';
    }

    montarGrafico();
  },
  { immediate: true }
);

onMounted(() => {
  montarGrafico();
});
</script>

<template>
  <AppLayout>
    <div class="p-6 bg-white rounded shadow max-w-5xl mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-indigo-700">Dashboard Financeiro</h1>

      <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-100 p-4 rounded-lg text-center">
          <div class="text-gray-600 font-semibold">Montante Necessário</div>
          <div class="text-2xl font-bold text-indigo-900 mt-2">Kz {{ resultado.montante }}</div>
        </div>
        <div class="bg-green-100 p-4 rounded-lg text-center">
          <div class="text-gray-600 font-semibold">Poupança Mensal Recomendada</div>
          <div class="text-2xl font-bold text-green-900 mt-2">Kz {{ resultado.poupanca }}</div>
        </div>
        <div
          class="bg-yellow-100 p-4 rounded-lg text-center"
          :class="{
            'text-red-700 bg-red-100': resultado.percentual < 10,
            'text-green-700 bg-green-100': resultado.percentual > 30
          }"
        >
          <div class="text-gray-600 font-semibold">Percentual do Salário</div>
          <div class="text-2xl font-bold mt-2">{{ resultado.percentual }}%</div>
        </div>
      </section>

      <section class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Projeção do Patrimônio ao Longo do Tempo</h2>
        <div id="patrimonio-chart"></div>
      </section>

      <section class="bg-gray-50 p-6 rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Simulador Rápido</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block font-medium mb-1">Despesas Mensais (Kz)</label>
            <input
              type="number"
              step="1000"
              v-model="despesasMensais"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Inflação anual (%)</label>
            <input
              type="number"
              step="0.1"
              v-model="inflacao"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Retorno anual (%)</label>
            <input
              type="number"
              step="0.1"
              v-model="retornoInvestimento"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Idade Atual</label>
            <input
              type="number"
              v-model="idadeAtual"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Idade de Aposentadoria</label>
            <input
              type="number"
              v-model="idadeAposentadoria"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Anos Aposentado</label>
            <input
              type="number"
              v-model="anosAposentado"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Valor Acumulado (Kz)</label>
            <input
              type="number"
              step="1000"
              v-model="valorAcumulado"
              class="border p-2 rounded w-full"
            />
          </div>
          <div>
            <label class="block font-medium mb-1">Salário Mensal (Kz)</label>
            <input
              type="number"
              step="1000"
              v-model="salarioMensal"
              class="border p-2 rounded w-full"
            />
          </div>
        </div>
        <p class="mt-4 text-indigo-700 font-semibold" v-if="alerta">{{ alerta }}</p>
      </section>
    </div>
  </AppLayout>
</template>

<style scoped>
#patrimonio-chart {
  max-width: 100%;
}
</style>
