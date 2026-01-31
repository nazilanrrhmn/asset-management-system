<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { AssetService } from "../../services/AssetService";
import EditAssetModal from "../../components/EditAssetModal.vue";

const route = useRoute();
const router = useRouter();
const asset = ref<any>(null);
const loading = ref(true);

const fetchDetail = async () => {
  loading.value = true;
  try {
    const id = route.params.id as string;
    const response = await AssetService.getDetailAssets(id);
    asset.value = response.data;
  } catch (error) {
    console.error("Gagal memuat detail:", error);
  } finally {
    loading.value = false;
  }
};

const isEditModalOpen = ref(false);
const isDeleting = ref(false);

const onUpdated = () => {
  fetchDetail();
};

const handleDelete = async () => {
  if (!asset.value) return;

  if (
    confirm(`Apakah Anda yakin ingin menghapus aset "${asset.value.name}"?`)
  ) {
    try {
      await AssetService.deleteAsset(asset.value.id);

      alert("Data berhasil dihapus");

      router.push("/assets");
    } catch (error: any) {
      console.error("Detail Error:", error);
      alert("Gagal menghapus aset. Silakan cek koneksi atau database Anda.");
    }
  }
};

onMounted(() => fetchDetail());
</script>

<template>
  <div class="p-8">
    <div class="flex justify-between items-center mb-6">
      <router-link to="/assets" class="text-indigo-600 font-medium"
        >&larr; Kembali ke Daftar</router-link
      >

      <div class="flex gap-3" v-if="asset">
        <button
          @click="handleDelete"
          :disabled="isDeleting"
          class="bg-white border-2 border-red-500 text-red-500 px-4 py-2 rounded-lg font-bold hover:bg-red-50 transition disabled:opacity-50"
        >
          {{ isDeleting ? "Menghapus..." : "Hapus Aset" }}
        </button>

        <button
          @click="isEditModalOpen = true"
          class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md"
        >
          Update Status & Lokasi
        </button>
      </div>
    </div>

    <EditAssetModal
      :is-open="isEditModalOpen"
      :asset="asset"
      @close="isEditModalOpen = false"
      @updated="onUpdated"
    />

    <div v-if="loading" class="text-gray-500 italic py-10 text-center">
      Sedang mengambil data aset...
    </div>

    <div v-else-if="asset" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div
        class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100"
      >
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ asset.name }}</h1>

        <div class="space-y-4">
          <div>
            <label class="text-xs font-bold text-gray-400 uppercase"
              >Kode Aset</label
            >
            <p
              class="text-gray-700 font-mono bg-gray-50 px-2 py-1 rounded border w-fit"
            >
              {{ asset.code }}
            </p>
          </div>

          <div>
            <label class="text-xs font-bold text-gray-400 uppercase"
              >Status</label
            >
            <div class="mt-1">
              <span
                class="px-3 py-1 rounded-full text-xs font-bold capitalize"
                :class="{
                  'bg-green-100 text-green-700': asset.status === 'active',
                  'bg-red-100 text-red-700': asset.status === 'broken',
                  'bg-orange-100 text-orange-700':
                    asset.status === 'maintenance',
                }"
              >
                {{ asset.status }}
              </span>
            </div>
          </div>

          <div>
            <label class="text-xs font-bold text-gray-400 uppercase"
              >Kategori</label
            >
            <p class="text-gray-700">{{ asset.category?.name || "N/A" }}</p>
          </div>

          <div>
            <label class="text-xs font-bold text-gray-400 uppercase"
              >Lokasi</label
            >
            <p class="text-gray-700">{{ asset.location?.name || "N/A" }}</p>
          </div>
        </div>
      </div>

      <div
        class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden"
      >
        <div class="p-4 border-b bg-gray-50">
          <h2 class="font-bold text-gray-800">
            Riwayat Perubahan (Asset Logs)
          </h2>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 font-bold">
              <tr>
                <th class="p-4 border-b">Tanggal</th>
                <th class="p-4 border-b">Aktivitas</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr
                v-for="log in asset.logs"
                :key="log.id"
                class="hover:bg-gray-50"
              >
                <td class="p-4 text-gray-500 whitespace-nowrap align-top">
                  {{ new Date(log.created_at).toLocaleString("id-ID") }}
                </td>
                <td class="p-4">
                  <p class="text-gray-800 font-medium">{{ log.name }}</p>

                  <div
                    v-if="log.details"
                    class="mt-2 text-xs bg-gray-100 p-2 rounded-lg border border-gray-200"
                  >
                    <div class="grid grid-cols-2 gap-2">
                      <div>
                        <span
                          class="text-red-600 font-bold uppercase block mb-1"
                          >Sebelum:</span
                        >
                        <ul class="text-gray-600">
                          <li>Status: {{ log.details.before.status }}</li>
                          <li>
                            Lokasi ID: {{ log.details.before.location_id }}
                          </li>
                        </ul>
                      </div>
                      <div>
                        <span
                          class="text-green-600 font-bold uppercase block mb-1"
                          >Sesudah:</span
                        >
                        <ul class="text-gray-600">
                          <li>Status: {{ log.details.after.status }}</li>
                          <li>
                            Lokasi ID: {{ log.details.after.location_id }}
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr v-if="!asset.logs || asset.logs.length === 0">
                <td colspan="2" class="p-10 text-center text-gray-400">
                  Belum ada riwayat aktivitas.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-else class="bg-red-50 text-red-600 p-4 rounded-lg">
      Data aset tidak ditemukan atau terjadi kesalahan server.
    </div>
  </div>
</template>
