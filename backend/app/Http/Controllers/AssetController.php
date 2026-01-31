<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use App\Services\AssetService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function index(Request $request)
    {
        $assets = $this->assetService->getAllAssets($request->all());
        return AssetResource::collection($assets);
    }

    public function store(AssetRequest $request)
    {
        $asset = $this->assetService->storeAsset($request->validated());
        return new AssetResource($asset);
    }

    public function show(Asset $asset)
    {
        $asset->load(['category', 'location', 'logs' => fn($q) => $q->latest()]);
        return new AssetResource($asset);
    }

    public function update(AssetRequest $request, Asset $asset)
    {
        $updatedAsset = $this->assetService->updateAsset($asset, $request->validated());
        return new AssetResource($updatedAsset);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return response()->json(['message' => 'Asset deleted successfully']);
    }
}
