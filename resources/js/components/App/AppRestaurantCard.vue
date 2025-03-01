<script setup lang="ts">
import type { Restaurant } from '@/types/restaurant'

const props = defineProps<{
  name: string
  image: string
  description: string
}>()
</script>

<template>
  <div>
    <div class="relative">
      <div class="relative w-full overflow-hidden rounded-lg h-72">
        <img :src="props.image" :alt="props.name" class="object-cover object-center w-full h-full" loading="lazy">
      </div>

      <div class="relative h-16 mt-4">
        <h3 class="text-sm font-medium text-gray-900">
          {{ props.name }}
        </h3>
        <p
          v-tooltip="`${props.description} `"
          class="mt-1 text-sm text-gray-500 line-clamp-2"
        >
          {{ props.description }}
        </p>
      </div>
    </div>
  </div>
</template>
