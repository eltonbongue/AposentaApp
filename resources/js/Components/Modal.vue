<template>
  <transition name="fade">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4" @click.self="close">
      <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-if="showSlot"
          class="bg-white text-black rounded-lg shadow-xl transform transition-all w-full max-w-2xl sm:mx-4"
        >
          <slot />
        </div>
      </transition>
    </div>
  </transition>
</template>

<script setup>
import { watch, ref, onUnmounted } from 'vue'

const props = defineProps({
  show: { type: Boolean, default: false },
  closeable: { type: Boolean, default: true },
})

const emit = defineEmits(['close'])

const showSlot = ref(props.show)

watch(() => props.show, (value) => {
  showSlot.value = value
  document.body.style.overflow = value ? 'hidden' : ''
})

// Garantir que ao desmontar o componente o overflow seja resetado
onUnmounted(() => {
  document.body.style.overflow = ''
})

const close = () => {
  if (props.closeable) emit('close')
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
