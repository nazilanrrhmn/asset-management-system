<script setup lang="ts">
import { ref, onMounted } from "vue";
import { MasterService } from "../../services/MasterService";

const locations = ref<any[]>([]);
const loading = ref(false);
const form = ref({ id: null, name: "" });

const fetchLocations = async () => {
  loading.value = true;
  try {
    const res = await MasterService.getLocation();
    locations.value = res.data;
  } finally {
    loading.value = false;
  }
};

const handleSubmit = async () => {
  try {
    if (form.value.id) {
      await MasterService.updateLocation(form.value.id, {
        name: form.value.name,
      });
    } else {
      await MasterService.storeLocation({ name: form.value.name });
    }
    form.value = { id: null, name: "" };
    fetchLocations();
    alert("Berhasil menyimpan data");
  } catch (err) {
    alert("Gagal menyimpan data");
  }
};

const editLocations = (cat: any) => {
  form.value = { id: cat.id, name: cat.name };
};

const deleteLocations = async (id: number) => {
  if (confirm("Hapus locations ini?")) {
    await MasterService.deleteLocation(id);
    fetchLocations();
  }
};

onMounted(fetchLocations);
</script>

<template>
  <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="bg-white p-6 rounded-xl shadow border h-fit">
      <h2 class="text-lg font-bold mb-4">
        {{ form.id ? "Edit" : "Tambah" }} Locations
      </h2>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label class="text-sm font-medium">Nama Location</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full border p-2 rounded mt-1"
            required
            placeholder="Contoh: Ruang Rapat"
          />
        </div>
        <div class="flex gap-2">
          <button
            type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded font-bold grow"
          >
            Simpan
          </button>
          <button
            v-if="form.id"
            type="button"
            @click="form = { id: null, name: '' }"
            class="bg-gray-100 px-4 py-2 rounded"
          >
            Batal
          </button>
        </div>
      </form>
    </div>

    <div
      class="md:col-span-2 bg-white rounded-xl shadow border overflow-hidden"
    >
      <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="p-4">Nama Location</th>
            <th class="p-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="loc in locations" :key="loc.id" class="border-b">
            <td class="p-4">{{ loc.name }}</td>
            <td class="p-4 text-right space-x-3">
              <button
                @click="editLocations(loc)"
                class="text-indigo-600 font-bold"
              >
                Edit
              </button>
              <button
                @click="deleteLocations(loc.id)"
                class="text-red-600 font-bold"
              >
                Hapus
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
