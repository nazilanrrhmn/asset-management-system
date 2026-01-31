import axios, { AxiosError } from "axios";
import type { ApiError422 } from "../types";

const api = axios.create({
  baseURL: "http://localhost:8000/api/v1",
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

api.interceptors.response.use(
  (response) => response,
  (error: AxiosError<ApiError422>) => {
    if (error.response) {
      switch (error.response.status) {
        case 422:
          const validationErrors = error.response.data.errors;
          console.error("Validation Errors:", validationErrors);
          break;
        case 404:
          alert("Data tidak ditemukan");
          break;
        case 500:
          alert("Terjadi kesalahan pada server");
          break;
      }
    }
    return Promise.reject(error);
  },
);

export default api;
