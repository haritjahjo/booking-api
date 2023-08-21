<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_property_owner_can_add_photo_to_property()
    {
        Storage::fake();

        $owner = User::factory()->create(['role_id' => Role::ROLE_OWNER]);
        $cityId = City::value('id');
        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $cityId,
        ]);

        $response = $this->actingAs($owner)->postJson('/api/owner/properties/' . $property->id . '/photos', [
            'photo' => UploadedFile::fake()->image('photo.png')
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'filename' => config('app.url') . '/storage/1/photo.png',
            'thumbnail' => config('app.url') . '/storage/1/conversions/photo-thumbnail.jpg',
        ]);
    }

    public function test_property_owner_can_reorder_photos_in_property()
    {
        Storage::fake();

        $owner = User::factory()->create(['role_id' => Role::ROLE_OWNER]);
        $cityId = City::value('id');
        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $cityId,
        ]);

        // I admit I'm lazy here: 2 API calls to upload files, instead of building a factory
        $photo1 = $this->actingAs($owner)->postJson('/api/owner/properties/' . $property->id . '/photos', [
            'photo' => UploadedFile::fake()->image('photo1.png')
        ]);
        $photo2 = $this->actingAs($owner)->postJson('/api/owner/properties/' . $property->id . '/photos', [
            'photo' => UploadedFile::fake()->image('photo2.png')
        ]);

        $newPosition = $photo1->json('position') + 1;
        $response = $this->actingAs($owner)->postJson('/api/owner/properties/' . $property->id . '/photos/1/reorder/' . $newPosition);
        $response->assertStatus(200);
        $response->assertJsonFragment(['newPosition' => $newPosition]);

        $this->assertDatabaseHas('media', ['file_name' => 'photo1.png', 'position' => $photo2->json('position')]);
        $this->assertDatabaseHas('media', ['file_name' => 'photo2.png', 'position' => $photo1->json('position')]);
    }
}
