<script setup lang="ts">
import { ref, watch } from "vue";
import { MasterService } from "../services/MasterService";
import { AssetService } from "../services/AssetService";
import type { Category, AssetLocation } from "../types";

const props = defineProps<{
  isOpen: boolean;
}>();

const emit = defineEmits(["close", "saved"]);

const form = ref({
  name: "",
  code: "",
  category_id: "",
  location_id: "",
  status: "active",
});

const categories = ref<Category[]>([]);
const locations = ref<AssetLocation[]>([]);
const loading = ref(false);
const errors = ref<any>({});

const resetForm = () => {
  form.value = {
    name: "",
    code: "",
    category_id: "",
    location_id: "",
    status: "active",
  };
  errors.value = {};
};

const fetchMasterData = async () => {
  try {
    const [catRes, locRes] = await Promise.all([
      MasterService.getCategories(),
      MasterService.getLocation(),
    ]);
    categories.value = catRes.data;
    locations.value = locRes.data;
  } catch (err) {}
};

watch(
  () => props.isOpen,
  (newVal) => {
    if (newVal) {
      resetForm();
      fetchMasterData();
    }
  },
);

const handleSubmit = async () => {
  loading.value = true;
  errors.value = {};

  try {
    await AssetService.storeAsset(form.value);

    emit("saved");
    emit("close");
  } catch (error: any) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      alert("Terjadi kesalahan sistem. Silakan coba lagi.");
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
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
      <div
        class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center"
      >
        <h2 class="text-xl font-bold text-gray-800">Tambah Aset Baru</h2>
        <button
          @click="$emit('close')"
          class="text-gray-400 hover:text-gray-600 font-bold text-2xl"
        >
          &times;
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="p-6 space-y-4">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Nama Aset</label
          >
          <input
            v-model="form.name"
            type="text"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition"
            :class="
              errors.name ? 'border-red-500 bg-red-50' : 'border-gray-300'
            "
            placeholder="Contoh: MacBook Pro 2023"
          />
          <p v-if="errors.name" class="text-red-500 text-xs mt-1">
            {{ errors.name[0] }}
          </p>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1"
            >Kode Aset</label
          >
          <input
            v-model="form.code"
            type="text"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition uppercase"
            :class="
              errors.code ? 'border-red-500 bg-red-50' : 'border-gray-300'
            "
            placeholder="Contoh: AST-001"
          />
          <p v-if="errors.code" class="text-red-500 text-xs mt-1">
            {{ errors.code[0] }}
          </p>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1"
              >Kategori</label
            >
            <select
              v-model="form.category_id"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
            >
              <option value="">Pilih</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                {{ cat.name }}
              </option>
            </select>
            <p v-if="errors.category_id" class="text-red-500 text-xs mt-1">
              {{ errors.category_id[0] }}
            </p>
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1"
              >Lokasi</label
            >
            <select
              v-model="form.location_id"
              class="w-full border border-gray-300 rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
            >
              <option value="">Pilih</option>
              <option v-for="loc in locations" :key="loc.id" :value="loc.id">
                {{ loc.name }}
              </option>
            </select>
            <p v-if="errors.location_id" class="text-red-500 text-xs mt-1">
              {{ errors.location_id[0] }}
            </p>
          </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t">
          <button
            type="button"
            @click="$emit('close')"
            class="px-5 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition"
          >
            Batal
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 font-bold shadow-md transition"
          >
            {{ loading ? "Menyimpan..." : "Simpan Aset" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
