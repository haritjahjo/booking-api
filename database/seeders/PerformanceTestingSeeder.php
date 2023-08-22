<?php

namespace Database\Seeders;

use Database\Seeders\Performance;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PerformanceTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            PermissionSeeder::class
        ]);
 
        $this->callWith(Performance\UserSeeder::class, [
            'owners' => 1000,
            'users' => 1000
        ]);
        $this->callWith(Performance\CountrySeeder::class, [
            'count' => 100
        ]);
        $this->callWith(Performance\CitySeeder::class, [
            'count' => 1000
        ]);
        $this->callWith(Performance\GeoobjectSeeder::class, [
            'count' => 1000
        ]);
        $this->callWith(Performance\PropertySeeder::class, [
            'count' => 1000
        ]);
        $this->callWith(Performance\ApartmentSeeder::class, [
            'count' => 2000
        ]);
        $this->callWith(Performance\BookingSeeder::class, [
            'withRatings' => 200,
            'withoutRatings' => 200
        ]);
    }
}
