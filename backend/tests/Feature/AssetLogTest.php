<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetLogTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_log_when_asset_location_is_updated()
    {
        $oldLocation = Location::factory()->create(['name' => 'Kantor Pusat']);
        $newLocation = Location::factory()->create(['name' => 'Cabang Bogor']);
        $category = AssetCategory::factory()->create();

        $asset = Asset::factory()->create([
            'location_id' => $oldLocation->id,
            'status' => 'active',
            'category_id' => $category->id
        ]);

        $response = $this->putJson("/api/v1/assets/{$asset->id}", [
            'name' => $asset->name,
            'code' => $asset->code,
            'category_id' => $category->id,
            'location_id' => $newLocation->id,
            'status' => 'active'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('asset_logs', [
            'asset_id' => $asset->id,
            'description' => "Asset updated: status/location changed."
        ]);

        $this->assertDatabaseHas('asset_logs', [
            'changes->after->location_id' => $newLocation->id
        ]);
    }
}
