<?php

namespace Tests\Feature;

use App\Models\AssetCategory;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_store_an_asset()
    {
        $category = AssetCategory::factory()->create();
        $location = Location::factory()->create();

        $payload = [
            'name' => 'Laptop Ideapad',
            'code' => 'LAP-001',
            'category_id' => $category->id,
            'location_id' => $location->id,
            'status' => 'active'
        ];

        $response = $this->postJson('/api/v1/assets', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('assets', ['code' => 'LAP-001']);
    }
}
