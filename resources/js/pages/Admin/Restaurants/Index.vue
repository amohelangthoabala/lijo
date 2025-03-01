<script setup lang="ts">
import type { PaginationRestaurants } from '@/types/restaurant'
defineProps<{
  restaurants: PaginationRestaurants
}>()

defineOptions({
  layout: AdminLayout,
})
</script>

<template>
  <main class="flex-1 ">
    <Head title="Restaurants | Admin" />

    <!-- Page title & actions -->
    <div class="px-4 py-6 border-gray-200 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
      <div class="flex-1 min">
        <div class="sm:flex-auto">
          <h1 class="text-xl font-semibold text-gray-900">
            Restaurants
          </h1>
          <p class="mt-2 text-sm text-gray-700">
            A list of all the restaurants in the system including their name and description.
          </p>
        </div>
      </div>
    </div>
  </main>
</template>
