export interface Category {
  id: number;
  name: string;
}

export interface AssetLocation {
  id: number;
  name: string;
}

export interface AssetLog {
  id: number;
  description: string;
  details?: any;
  created_at: string;
}

export interface Asset {
  id: number;
  name: string;
  code: string;
  status: "active" | "inactive" | "maintenance" | "retired";
  category: { id: number; name: string } | null;
  location: { id: number; name: string } | null;
  logs?: AssetLog[];
  created_at: string;
}

export interface ApiResponse<T> {
  data: T;
  meta?: {
    current_page: number;
    last_page: number;
    total: number;
  };
}

export interface ApiError422 {
  message: string;
  errors: Record<string, string[]>;
}
