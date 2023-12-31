<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\BedSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\FacilitySeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ApartmentSeeder;
use Database\Seeders\GeoobjectSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\FacilityCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(PermissionSeeder::class);

        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(GeoobjectSeeder::class);

        $this->call(PropertySeeder::class);
        $this->call(ApartmentSeeder::class);

        $this->call(RoomSeeder::class);
        $this->call(BedSeeder::class);

        $this->call(FacilityCategorySeeder::class);
        $this->call(FacilitySeeder::class);
    }
}
