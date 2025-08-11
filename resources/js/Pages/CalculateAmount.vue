<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const despesasMensais = ref('');
const idadeAtual = ref('');
const idadeAposentadoria = ref('');
const inflacao = ref('');
const anosAposentado = ref('');
const retornoInvestimento = ref('');
const salarioMensal = ref('');
const valorAcumulado = ref('');

const resultado = ref(null);
const poupancaMensal = ref(null);
const percentualSalario = ref(null);

const calcularMontante = () => {
    const d = parseFloat(despesasMensais.value);
    const i = parseInt(idadeAtual.value);
    const a = parseInt(idadeAposentadoria.value);
    const inf = parseFloat(inflacao.value) / 100;
    const anos = parseInt(anosAposentado.value);
    const roi = retornoInvestimento.value ? parseFloat(retornoInvestimento.value) / 100 : null;
    const acumulado = valorAcumulado.value ? parseFloat(valorAcumulado.value) : 0;

    if (isNaN(d) || isNaN(i) || isNaN(a) || isNaN(inf) || isNaN(anos)) {
        resultado.value = null;
        poupancaMensal.value = null;
        percentualSalario.value = null;
        return;
    }

    const anosAteAposentar = a - i;
    const meses = anosAteAposentar * 12;
    const despesasAnuais = d * 12;
    const fatorInflacao = Math.pow(1 + inf, anosAteAposentar);
    const despesasCorrigidas = despesasAnuais * fatorInflacao;

    let montante;

    if (roi !== null && !isNaN(roi)) {
        const fatorROI = (1 - Math.pow(1 + roi, -anos)) / roi;
        montante = despesasCorrigidas * fatorROI;
    } else {
        montante = despesasCorrigidas * anos;
    }

    resultado.value = montante.toFixed(2);

    // Cálculo da poupança mensal
    let poupanca = 0;

    if (roi !== null && roi > 0) {
        const rMensal = roi / 12;
        const futuroInvestido = acumulado * Math.pow(1 + rMensal, meses);
        const valorRestante = montante - futuroInvestido;

        if (valorRestante > 0) {
            poupanca = (valorRestante * rMensal) / (Math.pow(1 + rMensal, meses) - 1);
        }
    } else {
        const restante = montante - acumulado;
        poupanca = restante / meses;
    }

    poupancaMensal.value = poupanca.toFixed(2);

    // Percentual do salário
    if (salarioMensal.value && !isNaN(parseFloat(salarioMensal.value))) {
        const sal = parseFloat(salarioMensal.value);
        percentualSalario.value = ((poupanca / sal) * 100).toFixed(1);
    } else {
        percentualSalario.value = null;
    }
};
</script>

<template>
    <AppLayout title="Simulador de Aposentadoria">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Planejador de Aposentadoria em Angola
            </h2>
        </template>

        <div class="py-12 bg-gray-100 min-h-screen">
            <div class="max-w-4xl mx-auto px-6 lg:px-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6">
                        Calcule o montante necessário para sua aposentadoria
                    </h3>

                    <form @submit.prevent="calcularMontante">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Despesas mensais estimadas (Kz)</label>
                                <input v-model="despesasMensais" type="number" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 300000" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Idade atual</label>
                                <input v-model="idadeAtual" type="number" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 30" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Idade de aposentadoria desejada</label>
                                <input v-model="idadeAposentadoria" type="number" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 60" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Inflação anual estimada (%)</label>
                                <input v-model="inflacao" type="number" step="0.1" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 10" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Retorno anual com investimento (%) <span class="text-gray-500">(opcional)</span></label>
                                <input v-model="retornoInvestimento" type="number" step="0.1" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 6" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Valor já acumulado (Kz) <span class="text-gray-500">(opcional)</span></label>
                                <input v-model="valorAcumulado" type="number" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 2000000" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Salário mensal atual (Kz) <span class="text-gray-500">(opcional)</span></label>
                                <input v-model="salarioMensal" type="number" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 250000" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Duração esperada da aposentadoria (anos)</label>
                                <input v-model="anosAposentado" type="number" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ex: 20" />
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full md:w-auto px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                                Calcular
                            </button>
                        </div>
                    </form>

                    <!-- Resultado -->
                    <div v-if="resultado !== null" class="mt-6 p-4 bg-green-100 text-green-800 rounded-md text-lg font-medium">
                        <p>
                            Você precisará de aproximadamente <strong>{{ resultado }} Kz</strong> ao se aposentar.
                        </p>
                        <div v-if="poupancaMensal !== null">
                            <p class="mt-2">
                                Para alcançar esse valor, você deve guardar cerca de <strong>{{ poupancaMensal }} Kz por mês</strong>.
                            </p>
                            <div v-if="percentualSalario !== null" class="text-sm text-green-700 mt-1">
                                Isso representa <strong>{{ percentualSalario }}%</strong> do seu salário mensal.
                            </div>
                        </div>
                        <div v-if="retornoInvestimento">
                            <p class="text-sm text-green-700 mt-1">
                                Considerando um retorno anual médio de {{ retornoInvestimento }}% com investimentos.
                            </p>
                        </div>
                        <div v-else>
                            <p class="text-sm text-green-700 mt-1">
                                Considerando uma poupança sem retorno de investimento.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
