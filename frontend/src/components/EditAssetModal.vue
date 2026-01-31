<script setup lang="ts">
import { ref, watch } from "vue";
import { MasterService } from "../services/MasterService";
import { AssetService } from "../services/AssetService";
import type { Asset, AssetLocation } from "../types";

const props = defineProps<{
  isOpen: boolean;
  asset: Asset | null;
}>();

const emit = defineEmits(["close", "updated"]);

const form = ref({
  name: "",
  code: "",
  status: "",
  category_id: "" as string | number,
  location_id: "" as string | number,
});

const locations = ref<AssetLocation[]>([]);
const loading = ref(false);
const errors = ref<any>({});

watch(
  () => props.isOpen,
  async (newVal) => {
    if (newVal && props.asset) {
      errors.value = {};

      const currentCategoryId = (props.asset.category as any)?.id;
      const currentLocationId = (props.asset.location as any)?.id;

      form.value = {
        name: props.asset.name,
        code: props.asset.code,
        status: props.asset.status,
        category_id: currentCategoryId || "",
        location_id: currentLocationId || "",
      };

      const locRes = await MasterService.getLocation();
      locations.value = locRes.data;
    }
  },
);

const handleUpdate = async () => {
  if (!props.asset) return;

  loading.value = true;
  errors.value = {};

  try {
    await AssetService.updateAsset(props.asset.id, form.value);
    emit("updated");
    emit("close");
  } catch (error: any) {
    console.error("Gagal update:", error);
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      alert("Terjadi kesalahan sistem saat menyimpan.");
    }
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
  >
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
      <div class="px-6 py-4 border-b flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Update Status & Lokasi</h2>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-gray-600 text-2xl"
        >
          &times;
        </button>
      </div>

      <form @submit.prevent="handleUpdate" class="p-6 space-y-4">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Status Aset</label
          >
          <select
            v-model="form.status"
            class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <option value="active">Active</option>
            <option value="inactive">InActive</option>
            <option value="maintenance">Maintenance</option>
            <option value="retired">Retired</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Pindahkan ke Lokasi</label
          >
          <select
            v-model="form.location_id"
            class="w-full border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <option value="">Pilih Lokasi Baru</option>
            <option v-for="loc in locations" :key="loc.id" :value="loc.id">
              {{ loc.name }}
            </option>
          </select>
          <p v-if="errors.location_id" class="text-red-500 text-xs mt-1">
            {{ errors.location_id[0] }}
          </p>
        </div>

        <div class="flex justify-end space-x-3 pt-6">
          <button
            type="button"
            @click="$emit('close')"
            class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg"
          >
            Batal
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 font-bold shadow-md"
          >
            {{ loading ? "Memproses..." : "Simpan Perubahan" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
