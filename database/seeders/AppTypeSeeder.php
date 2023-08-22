<?php

namespace Database\Seeders;

use App\Models\BedType;
use App\Models\RoomType;
use App\Models\ApartmentType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApartmentType::create(['name' => 'Entire apartment']);
        ApartmentType::create(['name' => 'Entire studio']);
        ApartmentType::create(['name' => 'Private suite']);

        RoomType::create(['name' => 'Bedroom']);
        RoomType::create(['name' => 'Living room']);

        BedType::create(['name' => 'Single bed']);
        BedType::create(['name' => 'Large double bed']);
        BedType::create(['name' => 'Extra large double bed']);
        BedType::create(['name' => 'Sofa bed']);

        
    }
}
