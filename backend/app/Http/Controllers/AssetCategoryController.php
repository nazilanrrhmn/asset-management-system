<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetCategoryRequest;
use App\Http\Resources\MasterResource;
use App\Models\AssetCategory;
use App\Services\MasterDataService;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    protected $masterService;

    public function __construct(MasterDataService $masterService)
    {
        $this->masterService = $masterService;
    }

    public function index()
    {
        return MasterResource::collection($this->masterService->getAllCategories());
    }

    public function store(AssetCategoryRequest $request)
    {
        $category = $this->masterService->storeCategory($request->validated());
        return new MasterResource($category);
    }

    public function show(AssetCategory $assetCategory)
    {
        return new MasterResource($assetCategory);
    }

    public function update(AssetCategoryRequest $request, AssetCategory $category)
    {
        $this->masterService->updateCategory($category, $request->validated());
        return new MasterResource($category->refresh());
    }

    public function destroy(AssetCategory $category)
    {
        $this->masterService->deleteCategory($category);
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
