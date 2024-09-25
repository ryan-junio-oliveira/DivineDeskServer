<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\delete;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\deleteJson;
use App\Models\WereHouseOut;
use Tests\TestCase;
use App\Models\User;

use Laravel\Sanctum\Sanctum;

uses(TestCase::class, RefreshDatabase::class);

it('can make create all were house Out', function(){

    // Create a user with necessary roles or permissions
    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $whereHouseOut = WereHouseOut::factory()->make()->toArray();

    $response = postJson("api/v1/were-house-out/store", $whereHouseOut);

    $response->assertStatus(201);

    $this->assertDatabaseHas('were_house_outs', $whereHouseOut);
});

it('can make show all were house Out', function(){

      // Create a user with necessary roles or permissions
      $user = User::factory()->create(['role' => 'admin']);

      // Authenticate the user using Sanctum
      Sanctum::actingAs($user);

      $whereHouseOut = WereHouseOut::factory()->create()->toArray();

      $response = getJson("api/v1/were-house-out/all");

      $response->assertStatus(200);

      $this->assertDatabaseHas('were_house_outs', $whereHouseOut);

});

it('can make one show  were house out', function(){

     // Create a user with necessary roles or permissions
     $user = User::factory()->create(['role' => 'admin']);

     // Authenticate the user using Sanctum
     Sanctum::actingAs($user);

     $wereHouseOut = WereHouseOut::factory()->create()->toArray();

     $response = getJson("api/v1/were-house-out/show/{$wereHouseOut['id']}");

     $response->assertStatus(200);

     $this->assertDatabaseHas('were_house_outs', $wereHouseOut);
});

it('can make update were house out', function(){

     // Create a user with necessary roles or permissions
     $user = User::factory()->create(['role' => 'admin']);

     //create werehouseout
     $wereHouseOut = WereHouseOut::factory()->create()->toArray();

     $wereHouseOut['quantity'] = 2;

     // Authenticate the user using Sanctum
     Sanctum::actingAs($user);

     $response = putJson("api/v1/were-house-out/update", $wereHouseOut);

     $response->assertStatus(201);

     $this->assertDatabaseHas('were_house_outs', $wereHouseOut);
});

it('can make destroy were house out', function(){

    // Create a user with necessary roles or permissions
    $user = User::factory()->create(['role' => 'admin']);

    //create werehouseout
    $wereHouseOut = WereHouseOut::factory()->create()->toArray();



    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $response = deleteJson("api/v1/were-house-out/destroy/{$wereHouseOut['id']}");

    $response->assertStatus(201);

    $this->assertDatabaseMissing('were_house_outs', $wereHouseOut);
});





