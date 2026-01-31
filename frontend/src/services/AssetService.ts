import api from "../api/axios";
import type { ApiResponse, Asset } from "../types";

export const AssetService = {
  async getAllAssets(params?: any): Promise<ApiResponse<Asset[]>> {
    const response = await api.get("/assets", { params });
    return response.data;
  },

  async getDetailAssets(id: number | string): Promise<ApiResponse<Asset>> {
    const response = await api.get(`/assets/${id}`);
    return response.data;
  },

  async storeAsset(data: any): Promise<ApiResponse<Asset>> {
    const response = await api.post("/assets", data);
    return response.data;
  },

  async updateAsset(
    id: number | string,
    data: any,
  ): Promise<ApiResponse<Asset>> {
    const response = await api.put(`/assets/${id}`, data);
    return response.data;
  },

  async deleteAsset(id: number | string): Promise<void> {
    await api.delete(`/assets/${id}`);
  },
};
