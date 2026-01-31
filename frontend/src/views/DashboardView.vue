<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { AssetService } from "../services/AssetService";
import type { Asset } from "../types";

const assets = ref<Asset[]>([]);
const loading = ref(true);

const fetchAssets = async () => {
  loading.value = true;
  try {
    const response = await AssetService.getAllAssets();
    assets.value = response.data || response;
  } catch (error) {
    console.error("Gagal memuat data dashboard:", error);
  } finally {
    loading.value = false;
  }
};

const totalAssets = computed(() => assets.value.length);

const activeItems = computed(
  () => assets.value.filter((asset) => asset.status === "active").length,
);

const maintenanceItems = computed(
  () => assets.value.filter((asset) => asset.status === "maintenance").length,
);

onMounted(() => {
  fetchAssets();
});
</script>

<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Summary</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase">Total Assets</p>
        <p class="text-3xl font-bold text-indigo-600">{{ totalAssets }}</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase">Active Items</p>
        <p class="text-3xl font-bold text-green-600">{{ activeItems }}</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-sm font-medium text-gray-500 uppercase">
          Under Maintenance
        </p>
        <p class="text-3xl font-bold text-orange-600">{{ maintenanceItems }}</p>
      </div>
    </div>

    <div class="bg-indigo-50 border border-indigo-100 p-6 rounded-xl">
      <h2 class="text-lg font-semibold text-indigo-800 mb-2">
        Selamat Datang di AssetManager
      </h2>
      <p class="text-indigo-600">
        Gunakan menu navigasi di atas untuk mengelola aset, kategori, dan lokasi
        perusahaan Anda secara efisien.
      </p>
    </div>
  </div>
</template>
