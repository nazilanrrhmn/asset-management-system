<?php

namespace App\Http\Controllers;

use App\Http\Resources\MasterResource;
use App\Models\AssetLog;
use Illuminate\Http\Request;

class AssetLogController extends Controller
{
    public function index()
    {
        return MasterResource::collection(AssetLog::with('asset')->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(AssetLog $assetLog)
    {
        //
    }

    public function update(Request $request, AssetLog $assetLog)
    {
        //
    }

    public function destroy(AssetLog $assetLog)
    {
        //
    }
}
