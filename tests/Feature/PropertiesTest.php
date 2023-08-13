<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertiesTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_property_owner_has_access_to_properties_feature()
    {
        $owner = User::factory()->create([
            'name' => 'Prop Owner 1',
            'email' => 'prop.owner1@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => Role::ROLE_OWNER
        ]);
        $response = $this->actingAs($owner)->getJson('/api/owner/properties');
 
        $response->assertStatus(200);
    }
 
    public function test_user_does_not_have_access_to_properties_feature()
    {
        $owner = User::factory()->create([
            'name' => 'Simple User1 ',
            'email' => 'simple.user1@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => Role::ROLE_USER
        ]);
        $response = $this->actingAs($owner)->getJson('/api/owner/properties');
 
        $response->assertStatus(403);
    }
}
