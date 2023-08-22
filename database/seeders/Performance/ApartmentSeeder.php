<?php

namespace Database\Seeders\Performance;

use App\Models\Property;
use App\Models\Apartment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $count = 100): void
    {
            // $properties = Property::pluck('id');
    
            // $apartments = [];
            // for ($i = 1; $i <= $count; $i++) {
            //     $apartments[] = [
            //         'property_id' => $properties->random(),
            //         'name' => 'Apartment ' . $i,
            //         'capacity_adults' => rand(1, 5),
            //         'capacity_children' => rand(1, 5),
            //     ];
            // }
    
            // foreach (array_chunk($apartments, 500) as $apartmentsChunk) {
            //     Apartment::insert($apartmentsChunk);
            // }
        $propertyMin = Property::min('id');
        $propertyMax = Property::max('id');
 
        $apartments = [];
        for ($i = 1; $i <= $count; $i++) {
            $apartments[] = [
                'property_id' => rand($propertyMin, $propertyMax),
                'name' => 'Apartment ' . $i,
                'capacity_adults' => rand(1, 5),
                'capacity_children' => rand(1, 5),
            ];
 
            if ($i % 500 == 0 || $i == $count) {
                Apartment::insert($apartments);
                $apartments = [];
            }
        }
    }
}
