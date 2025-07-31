<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import Checkbox from '@/Components/Checkbox.vue'

defineProps({
  canResetPassword: Boolean,
  status: String,
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}
</script>

<template>
  <Head title="Login" />

  <div class="min-h-screen flex items-center justify-center bg-gray-300">
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2 w-full max-w-5xl">
      <!-- Left Side: Form -->
      <div class="p-8 md:p-12 flex flex-col justify-center">
        <div class="mb-6 flex justify-center">
          <AuthenticationCardLogo class="h-10 w-auto" />
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Welcome Back</h2>
        <p class="text-gray-500 text-sm mb-6 text-center">Insira suas credenciais para acessar sua conta</p>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
          {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
          <!-- Email -->
          <div>
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              class="mt-1 block w-full"
              required
              autofocus
              autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <!-- Password -->
          <div>
            <InputLabel for="password" value="Password" />
            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              class="mt-1 block w-full"
              required
              autocomplete="current-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <!-- Remember -->
          <div class="flex items-center justify-between">
            <label class="flex items-center text-sm">
              <Checkbox v-model:checked="form.remember" name="remember" />
              <span class="ml-2 text-gray-600">Lembre-me</span>
            </label>

            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm text-indigo-600 hover:underline"
            >
              Esqueceu sua senha?
            </Link>
          </div>

          <!-- Submit -->
          <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Continue
          </PrimaryButton>
        </form>

        <!-- Footer -->
        <p class="text-xs text-gray-400 text-center mt-6">
          &copy; {{ new Date().getFullYear() }} AposentApp. Todos os direitos reservados.
        </p>
      </div>

      <!-- Right Side: Illustration -->
      <div class="bg-blue-100 hidden md:flex items-center justify-center h-full">
        <img src="/storage/img/login_img.jpg" alt="Login Illustration" class="w-full h-full object-cover" />
      </div>
    </div>
  </div>
</template>
