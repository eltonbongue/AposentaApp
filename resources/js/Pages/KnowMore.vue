<template>
  <div class="min-h-screen bg-white text-gray-800">
    <!-- Header -->
    <header class="bg-gray-900 text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-2">Saber Mais</h1>
        <p class="text-lg text-gray-300">Descubra como o <span class="text-indigo-400">Aposenta+</span> pode ajudar você a planear sua aposentadoria com inteligência.</p>
      </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="py-12">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- Seção 1 -->
        <section class="md:flex md:items-center md:space-x-12">
          <div class="md:w-1/2 mb-6 md:mb-0">
            <img src="storage/img/hero.jpg"  alt="Planeamento de Aposentadoria" class="rounded-lg shadow-md w-full h-auto">
          </div>
          <div class="md:w-1/2">
            <h2 class="text-2xl font-semibold mb-4">Planeamento Inteligente</h2>
            <p class="text-gray-600">
              O Aposenta+ oferece ferramentas para simular cenários de aposentadoria, permitindo que você tome decisões informadas sobre o futuro financeiro com base na sua realidade atual.
            </p>
          </div>
        </section>

        <!-- Seção 2 -->
        <section class="md:flex md:items-center md:flex-row-reverse md:space-x-reverse md:space-x-12">
          <div class="md:w-1/2 mb-6 md:mb-0">
            <img src="storage/img/login_img.jpg" alt="Inteligência Financeira" class="rounded-lg shadow-md w-full h-auto">
          </div>
          <div class="md:w-1/2">
            <h2 class="text-2xl font-semibold mb-4">Assistente Financeiro com IA</h2>
            <p class="text-gray-600">
              Conte com um assistente virtual com inteligência artificial para tirar dúvidas sobre previdência, INSS e investimentos voltados para a aposentadoria.
            </p>
          </div>
        </section>

        <!-- Seção 3 -->
        <section>
          <h2 class="text-2xl font-semibold mb-4">Por que usar o Aposenta+?</h2>
          <ul class="list-disc pl-5 text-gray-700 space-y-2">
            <li>Simulações personalizadas de aposentadoria.</li>
            <li>Alertas de contribuição e notificações importantes.</li>
            <li>Interface simples, acessível e 100% gratuita.</li>
            <li>Desenvolvido para trabalhadores formais e autônomos.</li>
          </ul>
        </section>
      </div>

      <!-- Botão de Voltar à Página Inicial -->
<div class="text-center mt-8">
  <a
    href="/" 
    class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-indigo-700 transition"
  >
    ← Voltar para Início
  </a>
</div>

    </main>

    <!-- Rodapé -->
    <footer class="bg-gray-100 py-6 mt-12 text-center text-gray-500 text-sm">
      &copy; {{ new Date().getFullYear() }} Aposenta+. Todos os direitos reservados.
    </footer>
  </div>
</template>

<script setup>
// Sem lógica JS por enquanto, só conteúdo estático
</script>

<style scoped>
/* Adicional (opcional): animações ou ajustes podem ir aqui */
</style>
