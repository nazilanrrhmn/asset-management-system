<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        AssetCategory::create(['name' => 'Elektronik']);
        AssetCategory::create(['name' => 'Perlengkapan Kantor']);
        AssetCategory::create(['name' => 'Perabotan']);
        AssetCategory::create(['name' => 'Kendaraan']);

        Location::create(['name' => 'Gudang Utama']);
        Location::create(['name' => 'Ruang IT']);
        Location::create(['name' => 'Kantor Cabang Jakarta']);
        Location::create(['name' => 'Kantor Cabang Surabaya']);
    }
}
