import api from "../api/axios";
import type { ApiResponse, Category, AssetLocation } from "../types";

export const MasterService = {
  async getCategories(): Promise<ApiResponse<Category[]>> {
    const response = await api.get("/categories");
    return response.data;
  },
  async storeCategory(data: { name: string }) {
    const response = await api.post("/categories", data);
    return response.data;
  },
  async updateCategory(id: number, data: { name: string }) {
    const response = await api.put(`/categories/${id}`, data);
    return response.data;
  },
  async deleteCategory(id: number): Promise<void> {
    return (await api.delete(`/categories/${id}`)).data;
  },

  async getLocation(): Promise<ApiResponse<AssetLocation[]>> {
    const response = await api.get("/locations");
    return response.data;
  },
  async storeLocation(data: { name: string }) {
    const response = await api.post("/locations", data);
    return response.data;
  },
  async updateLocation(id: number, data: { name: string }) {
    const response = await api.put(`/locations/${id}`, data);
    return response.data;
  },
  async deleteLocation(id: number): Promise<void> {
    return (await api.delete(`/locations/${id}`)).data;
  },
};
