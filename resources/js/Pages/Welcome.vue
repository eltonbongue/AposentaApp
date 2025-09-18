<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <section class="min-h-screen bg-gradient-to-r from-indigo-600 via-purple-700 to-pink-600 flex flex-col">
    <!-- Navbar -->
    <nav class="flex justify-between items-center p-6 max-w-7xl mx-auto w-full">
      <h1 class="text-3xl font-extrabold text-white cursor-pointer select-none">
        Aposenta<span class="text-yellow-300">+</span>
      </h1>

      <div class="space-x-4">
        <Link
          :href="route('know-more')"
          class="text-white hover:text-yellow-300 font-semibold transition"
        >
          Saber Mais
        </Link>

        <Link
          :href="route('login')"
          class="bg-yellow-300 text-indigo-900 font-bold px-5 py-2 rounded-lg shadow hover:bg-yellow-400 transition"
        >
          Login
        </Link>

        <Link
          :href="route('register')"
          class="border-2 border-yellow-300 text-yellow-300 font-bold px-5 py-2 rounded-lg hover:bg-yellow-300 hover:text-indigo-900 transition"
        >
          Registrar
        </Link>
      </div>
    </nav>

    <!-- Hero Content -->
    <main class="flex-grow flex flex-col justify-center items-center text-center px-6 max-w-4xl mx-auto">
      <h2
        class="text-5xl sm:text-6xl font-extrabold text-white drop-shadow-lg leading-tight"
        style="text-shadow: 2px 2px 6px rgba(0,0,0,0.5)"
      >
        Planeje sua <span class="text-yellow-300">aposentadoria</span> <br />
        com <span class="underline decoration-yellow-300">facilidade</span> e <br />
        <span class="italic text-yellow-300">confiança</span>.
      </h2>

      <p class="mt-6 text-indigo-200 max-w-xl text-lg sm:text-xl drop-shadow-md">
        O Aposenta+ ajuda você a projetar seu futuro financeiro, recomendando a
        melhor poupança mensal para a aposentadoria dos seus sonhos.
      </p>

      <div class="mt-10 flex flex-wrap justify-center gap-4">
        <Link
          :href="route('know-more')"
          class="bg-yellow-300 text-indigo-900 font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-yellow-400 transition transform hover:-translate-y-1"
        >
          Saiba Mais
        </Link>

        <Link
          :href="route('login')"
          class="border-2 border-yellow-300 text-yellow-300 font-semibold px-8 py-3 rounded-lg hover:bg-yellow-300 hover:text-indigo-900 transition transform hover:-translate-y-1"
        >
          Entrar
        </Link>

        <Link
          :href="route('register')"
          class="bg-transparent border-2 border-white text-white font-semibold px-8 py-3 rounded-lg hover:bg-white hover:text-indigo-900 transition transform hover:-translate-y-1"
        >
          Criar Conta
        </Link>
      </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 bg-indigo-900 text-indigo-300 text-center select-none">
      &copy; 2025 Aposent+. Todos os direitos reservados.
    </footer>
  </section>
</template>

<style scoped>
@keyframes pulseShadow {
  0%, 100% {
    text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
  }
  50% {
    text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
  }
}

h2 {
  animation: pulseShadow 4s ease-in-out infinite;
}
</style>
