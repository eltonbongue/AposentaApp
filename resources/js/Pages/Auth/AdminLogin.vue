<script setup>
import { reactive } from "vue";
import { router } from "@inertiajs/vue3";

const form = reactive({
  email: "",
  password: "",
  remember: false,
  errors: {},
});

function submit() {
  router.post(route("admin.login.submit"), form, {
    onError: (errors) => {
      form.errors = errors;
    },
  });
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">
        Painel do Administrador
      </h1>

      <form @submit.prevent="submit" class="space-y-4">
        <!-- Email -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            placeholder="admin@example.com"
          />
          <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">
            {{ form.errors.email }}
          </p>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Senha</label>
          <input
            v-model="form.password"
            type="password"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            placeholder="********"
          />
          <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">
            {{ form.errors.password }}
          </p>
        </div>

        <!-- Remember me -->
        <div class="flex items-center">
          <input
            v-model="form.remember"
            type="checkbox"
            id="remember"
            class="mr-2"
          />
          <label for="remember" class="text-gray-700">Lembrar-me</label>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg shadow font-medium"
        >
          Entrar
        </button>
      </form>
    </div>
  </div>
</template>
