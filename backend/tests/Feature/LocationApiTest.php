<?php

namespace Tests\Feature;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LocationApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_locations()
    {
        Location::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/locations');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    #[Test]
    public function it_can_store_a_location()
    {
        $response = $this->postJson('/api/v1/locations', ['name' => 'Gudang A']);

        $response->assertStatus(201);
        $this->assertDatabaseHas('locations', ['name' => 'Gudang A']);
    }
}
