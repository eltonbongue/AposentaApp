<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const mensagem = ref('');
const mensagens = ref([]);
const loading = ref(false);

// Envia a mensagem para a API e armazena a resposta
const enviarPergunta = async () => {
  if (!mensagem.value) return;

  const perguntaAtual = mensagem.value;
  mensagens.value.push({ pergunta: perguntaAtual, resposta: '' });
  mensagem.value = '';
  loading.value = true;

  try {
    const res = await axios.post('/api/chat/ia', {
      mensagem: perguntaAtual,
    });

    mensagens.value[mensagens.value.length - 1].resposta = res.data.resposta;
  } catch (err) {
    mensagens.value[mensagens.value.length - 1].resposta = 'Erro ao obter resposta.';
  } finally {
    loading.value = false;
  }
};

// Limpa todo o histórico da conversa
const limparMensagens = () => {
  mensagens.value = [];
};
</script>

<template>
  <AppLayout title="Assistente de Finanças">
    <template #header >
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Assistente de Finanças com IA
      </h2>
    </template>

    <div class="py-12 bg-gray-100 min-h-screen">
      <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <!-- Título + botão limpar -->
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Tire dúvidas sobre finanças</h2>
            <button
              @click="limparMensagens"
              class="text-sm text-red-600 hover:underline"
              v-if="mensagens.length > 0 && !loading"
            >
              Limpar conversa
            </button>
          </div>

          <!-- Área de mensagens -->
          <div class="h-64 overflow-y-auto border rounded p-4 bg-gray-50 mb-4">
            <div v-for="(msg, i) in mensagens" :key="i" class="mb-3">
              <div class="font-semibold text-indigo-600">Você:</div>
              <div class="mb-2">{{ msg.pergunta }}</div>
              <div class="font-semibold text-green-700">IA:</div>
              <div class="whitespace-pre-line">{{ msg.resposta }}</div>
            </div>
            <div v-if="loading" class="text-sm text-gray-500 italic">A pensar...</div>
            <div v-if="mensagens.length === 0 && !loading" class="text-sm text-gray-500 italic">
              Nenhuma mensagem ainda. Faça sua primeira pergunta.
            </div>
          </div>

          <!-- Campo de input -->
          <form @submit.prevent="enviarPergunta" class="flex gap-2">
            <input
              v-model="mensagem"
              type="text"
              class="flex-1 px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Ex: Como posso começar a poupar para a aposentadoria?"
              :disabled="loading"
            />
            <button
              type="submit"
              :disabled="loading || !mensagem"
              class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
            >
              Enviar
            </button>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
