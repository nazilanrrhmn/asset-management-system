<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Http\Resources\MasterResource;
use App\Models\Location;
use App\Services\MasterDataService;

class LocationController extends Controller
{
    protected $masterService;

    public function __construct(MasterDataService $masterService)
    {
        $this->masterService = $masterService;
    }

    public function index()
    {
        return MasterResource::collection($this->masterService->getAllLocations());
    }

    public function store(LocationRequest $request)
    {
        $location = $this->masterService->storeLocation($request->validated());
        return new MasterResource($location);
    }

    public function show(Location $location)
    {
        return new MasterResource($location);
    }

    public function update(LocationRequest $request, Location $location)
    {
        $this->masterService->updateLocation($location, $request->validated());
        return new MasterResource($location->refresh());
    }

    public function destroy(Location $location)
    {
        $this->masterService->deleteLocation($location);
        return response()->json(['message' => 'Location deleted successfully']);
    }
}
