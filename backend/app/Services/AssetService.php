<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetLog;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function getAllAssets($filters)
    {
        $query = Asset::with(['category', 'location']);

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('code', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['location_id'])) {
            $query->where('location_id', $filters['location_id']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(10);
    }

    public function storeAsset(array $data)
    {
        return DB::transaction(function () use ($data) {
            $asset = Asset::create($data);
            $asset->load('location');
            $this->logActivity($asset, "Asset created at location: " . $asset->location->name);
            return $asset;
        });
    }

    public function updateAsset(Asset $asset, array $data)
    {
        return DB::transaction(function () use ($asset, $data) {
            $oldData = [
                'location_id' => $asset->location_id,
                'status'      => $asset->status,
            ];

            $asset->update($data);

            if ($oldData['location_id'] != $data['location_id'] || $oldData['status'] != $data['status']) {
                $changes = [
                    'before' => $oldData,
                    'after'  => [
                        'location_id' => $data['location_id'],
                        'status'      => $data['status'],
                    ]
                ];

                $this->logActivity($asset, "Asset updated: status/location changed.", $changes);
            }

            return $asset;
        });
    }

    protected function logActivity(Asset $asset, string $description, ?array $changes = null)
    {
        AssetLog::create([
            'asset_id'    => $asset->id,
            'description' => $description,
            'changes'     => $changes
        ]);
    }
}
