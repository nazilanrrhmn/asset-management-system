<script setup lang="ts"></script>

<template>
  <div class="h-screen w-full bg-gray-50 flex flex-col overflow-hidden">
    <header class="bg-indigo-600 text-white shadow-md flex-none">
      <div class="w-full px-8 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">AssetManager</h1>
        <nav class="space-x-6 text-sm font-medium">
          <router-link
            to="/"
            class="hover:text-indigo-200 transition"
            active-class="border-b-2 border-white pb-1"
            exact-active-class="border-b-2 border-white pb-1"
          >
            Dashboard
          </router-link>

          <router-link
            to="/categories"
            class="hover:text-indigo-200 transition"
            active-class="border-b-2 border-white pb-1"
          >
            Categories
          </router-link>
          <router-link
            to="/locations"
            class="hover:text-indigo-200 transition"
            active-class="border-b-2 border-white pb-1"
          >
            Locations
          </router-link>

          <router-link
            to="/assets"
            class="hover:text-indigo-200 transition"
            active-class="border-b-2 border-white pb-1"
          >
            Assets
          </router-link>
        </nav>
      </div>
    </header>

    <main class="grow w-full overflow-auto bg-white">
      <slot />
    </main>

    <footer class="bg-white border-t py-3 flex-none">
      <div class="text-center text-gray-500 text-xs font-medium">
        &copy; 2026 Asset Management System
      </div>
    </footer>
  </div>
</template>
