<script setup lang="ts">
import type { Restaurant } from '@/types/restaurant'

const props = defineProps<{
  restaurants: Array<Restaurant>
}>()
</script>

<template>
  <div class="flex flex-col px-4 py-10 mx-auto space-y-8 overflow-hidden max-w-7xl sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
      <div>
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
          Explore our restaurants
        </h2>
        <p class="mt-4 text-base text-gray-500">
          Find the best restaurants in your area.
        </p>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-y-10 gap-x-6 sm:grid-cols-3 lg:grid-cols-4 lg:gap-x-8">
      <AppRestaurantCard
        v-for="restaurant in restaurants.data"
        :key="restaurant.id"
        :name="restaurant.name"
        :image="'https://images.unsplash.com/photo-1556742205-e10c9486e506?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'"
        :description="restaurant.description"
      />
  </div>
  </div>

  <pre>{{ JSON.stringify(restaurants, null, 2) }}</pre>
</template>
