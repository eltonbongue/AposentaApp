<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
    <div class="bg-[#fdfdfc] min-h-screen">
        <!-- Top Banner -->
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <ApplicationLogo class="block h-12 w-auto" />
                <h1 class="text-3xl font-semibold text-gray-800">AposentApp</h1>
            </div>

            <h2 class="mt-6 text-xl text-gray-700 font-medium">
                Bem-vindo ao seu painel de aposentadoria
            </h2>

            <p class="mt-4 text-gray-500 leading-relaxed max-w-2xl">
                Este é o seu espaço para calcular e acompanhar seu progresso rumo à aposentadoria. Use os módulos abaixo para explorar funcionalidades úteis, como tempo de contribuição, projeções e mais.
            </p>
        </div>

        <!-- Feature Grid -->
        <div class="bg-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center">
                    <svg class="size-6 stroke-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75..." />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-800">
                        <a href="https://laravel.com/docs" target="_blank">Documentação Laravel</a>
                    </h2>
                </div>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Leia toda a documentação oficial do Laravel para dominar o framework e manter seu app robusto e seguro.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center">
                    <svg class="size-6 stroke-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72..." />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-800">
                        <a href="https://laracasts.com" target="_blank">Laracasts</a>
                    </h2>
                </div>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Assista tutoriais em vídeo para se aprimorar com Laravel, Vue, Inertia e muito mais.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center">
                    <svg class="size-6 stroke-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159..." />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-800">
                        <a href="https://tailwindcss.com/" target="_blank">Tailwind CSS</a>
                    </h2>
                </div>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Estilize sua aplicação com facilidade usando o Tailwind, um framework moderno de utilidades CSS.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center">
                    <svg class="size-6 stroke-indigo-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75..." />
                    </svg>
                    <h2 class="ms-3 text-xl font-semibold text-gray-800">
                        Autenticação Segura
                    </h2>
                </div>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    Jetstream oferece autenticação robusta e gerenciamento de contas com suporte a múltiplos recursos.
                </p>
            </div>
        </div>
    </div>
</template>
