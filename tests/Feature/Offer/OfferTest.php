<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\delete;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;

use Laravel\Sanctum\Sanctum;

uses(TestCase::class, RefreshDatabase::class);


it('can make store the offer', function(){

      // Create a user with necessary roles or permissions
      $user = User::factory()->create(['role' => 'admin']);

      // Authenticate the user using Sanctum
      Sanctum::actingAs($user);

      // Create member data
      $offerData = Offer::factory()->make()->toArray();

      // Make a POST request to create a member
      $response = postJson('api/v1/offer/store', $offerData);

      // Assert the response status
      $response->assertStatus(201);

      // Assert that the member data exists in the database
      $this->assertDatabaseHas('offers', $offerData);
});

it('can make read all offers', function(){

      // Create a user with necessary roles or permissions
      $user = User::factory()->create(['role' => 'admin']);

      // Authenticate the user using Sanctum
      Sanctum::actingAs($user);

      // Create member data
      $offerData = Offer::factory()->create()->toArray();

      $response = getJson('api/v1/offer/all');

      $response->assertStatus(200);

      $this->assertDatabaseHas('offers', $offerData);

});

it('can make read one offers', function(){

    // Create a user with necessary roles or permissions
    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    // Create member data
    $offerData = Offer::factory()->create()->toArray();

    $response = getJson("api/v1/offer/show/{$offerData['id']}");

    $response->assertStatus(200);

    $this->assertDatabaseHas('offers', $offerData);

});

it('can make update offers', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    // Create member data
    $offerData = Offer::factory()->create()->toArray();

    $offerData['value'] = 10.00;

    $response = putJson('api/v1/offer/update', $offerData);
    $response->assertStatus(201);

    $this->assertDatabaseHas('offers', $offerData);
});

it('can delete offer', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    // Create member data
    $offerData = Offer::factory()->create()->toArray();

    $response = deleteJson("api/v1/offer/destroy/{$offerData['id']}");

    $response->assertStatus(201);

    $this->assertDatabaseMissing('offers', $offerData);

});

