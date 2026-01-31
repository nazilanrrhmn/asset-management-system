<?php

namespace App\Services;

use App\Models\AssetCategory;
use App\Models\Location;
use App\Models\AssetLog;

class MasterDataService
{
    public function getAllCategories()
    {
        return AssetCategory::all();
    }

    public function storeCategory(array $data)
    {
        return AssetCategory::create($data);
    }

    public function updateCategory(AssetCategory $category, array $data)
    {
        $category->update($data);
        return $category;
    }

    public function deleteCategory(AssetCategory $category)
    {
        return $category->delete();
    }

    public function getAllLocations()
    {
        return Location::all();
    }

    public function storeLocation(array $data)
    {
        return Location::create($data);
    }

    public function updateLocation(Location $location, array $data)
    {
        $location->update($data);
        return $location;
    }

    public function deleteLocation(Location $location)
    {
        return $location->delete();
    }

    public function getLogsByAsset($assetId)
    {
        return AssetLog::where('asset_id', $assetId)
            ->latest()
            ->get();
    }
}
