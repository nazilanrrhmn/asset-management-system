<?php

namespace Tests\Feature;

use App\Models\AssetCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AssetCategoryApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_categories()
    {
        AssetCategory::factory()->count(5)->create();
        $response = $this->getJson('/api/v1/categories');
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data');
    }

    #[Test]
    public function it_validates_unique_name_on_update()
    {
        $cat1 = AssetCategory::create(['name' => 'Laptop']);
        $cat2 = AssetCategory::create(['name' => 'Monitor']);
        $cat3 = AssetCategory::create(['name' => 'Keyboard']);

        $response = $this->putJson("/api/v1/categories/{$cat2->id}", [
            'name' => 'Laptop'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}
