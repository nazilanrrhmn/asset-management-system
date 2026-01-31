<script setup lang="ts">
import { ref, onMounted } from "vue";
import { AssetService } from "../../services/AssetService";
import type { Asset } from "../../types";
import AssetFormModal from "../../components/AssetFormModal.vue";

const assets = ref<Asset[]>([]);
const loading = ref(false);
const search = ref("");
const pagination = ref({ current: 1, last: 1 });

const loadAssets = async (page = 1) => {
  loading.value = true;
  try {
    const response = await AssetService.getAllAssets({
      page,
      search: search.value,
    });
    assets.value = response.data;
    if (response.meta) {
      pagination.value = {
        current: response.meta.current_page,
        last: response.meta.last_page,
      };
    }
  } finally {
    loading.value = false;
  }
};

const isModalOpen = ref(false);

const handleSaved = () => {
  loadAssets(1);
};

onMounted(() => loadAssets());
</script>

<template>
  <div class="w-full p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Daftar Aset IT</h1>
      <button
        @click="isModalOpen = true"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition"
      >
        + Tambah Aset
      </button>
    </div>

    <div class="mb-4">
      <input
        v-model="search"
        @input="loadAssets(1)"
        type="text"
        placeholder="Cari kode atau nama aset..."
        class="w-full md:w-1/3 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none"
      />
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b border-gray-200">
          <tr>
            <th class="p-4 text-sm font-semibold text-gray-600 uppercase">
              Kode
            </th>
            <th class="p-4 text-sm font-semibold text-gray-600 uppercase">
              Nama Aset
            </th>
            <th class="p-4 text-sm font-semibold text-gray-600 uppercase">
              Kategori
            </th>
            <th class="p-4 text-sm font-semibold text-gray-600 uppercase">
              Status
            </th>
            <th class="p-4 text-sm font-semibold text-gray-600 uppercase">
              Aksi
            </th>
          </tr>
        </thead>
        <tbody v-if="!loading">
          <tr
            v-for="asset in assets"
            :key="asset.id"
            class="border-b border-gray-100 hover:bg-gray-50"
          >
            <td class="p-4 font-mono text-sm text-indigo-600">
              {{ asset.code }}
            </td>
            <td class="p-4 text-gray-800 font-medium">{{ asset.name }}</td>
            <td class="p-4 text-gray-600">{{ asset.category?.name || "" }}</td>
            <td class="p-4">
              <span
                class="px-3 py-1 rounded-full text-xs font-bold"
                :class="{
                  'bg-green-100 text-green-700': asset.status === 'active',
                  'bg-red-100 text-red-700': asset.status === 'inactive',
                  'bg-orange-100 text-orange-700':
                    asset.status === 'maintenance',
                }"
              >
                {{ asset.status.toUpperCase() }}
              </span>
            </td>
            <td class="p-4">
              <router-link
                :to="{ name: 'assets.show', params: { id: asset.id } }"
                class="text-indigo-600 hover:text-indigo-900 font-bold"
              >
                Detail
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>

      <div v-if="loading" class="p-10 text-center text-gray-500 italic">
        Memuat data aset...
      </div>
    </div>

    <div class="mt-6 flex justify-center gap-2">
      <button
        @click="loadAssets(pagination.current - 1)"
        :disabled="pagination.current === 1"
        class="px-4 py-2 border rounded shadow-sm disabled:opacity-50 hover:bg-gray-50"
      >
        Prev
      </button>
      <span class="px-4 py-2"
        >Halaman {{ pagination.current }} / {{ pagination.last }}</span
      >
      <button
        @click="loadAssets(pagination.current + 1)"
        :disabled="pagination.current === pagination.last"
        class="px-4 py-2 border rounded shadow-sm disabled:opacity-50 hover:bg-gray-50"
      >
        Next
      </button>
    </div>

    <AssetFormModal
      :is-open="isModalOpen"
      @close="isModalOpen = false"
      @saved="handleSaved"
    />
  </div>
</template>
