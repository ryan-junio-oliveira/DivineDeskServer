<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\delete;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\deleteJson;
use App\Models\WereHouse;
use Tests\TestCase;
use App\Models\User;

use Laravel\Sanctum\Sanctum;

uses(TestCase::class, RefreshDatabase::class);

it('can make create all wherehouse', function(){

    // Create a user with necessary roles or permissions
    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $whereHouse = WereHouse::factory()->make()->toArray();

    $response = postJson("api/v1/were-house/store", $whereHouse);

    $response->assertStatus(201);

    $this->assertDatabaseHas('were_houses', $whereHouse);
});

it('can make show all wherehouse', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $whereHouse = WereHouse::factory()->count(5)->create()->toArray();

    $response = getJson("api/v1/were-house/all");

    $response->assertStatus(200);

    $this->assertDatabaseHas('were_houses', $whereHouse[1]);

});

it('can make show one whereHouse',function(){


    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $whereHouse = WereHouse::factory()->create()->toArray();


    $response = getJson("api/v1/were-house/show/{$whereHouse['id']}");

    $response->assertStatus(200);

    $this->assertDatabaseHas('were_houses', $whereHouse);

});

it('can make update were house', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $whereHouse = WereHouse::factory()->create()->toArray();

    $whereHouse['quantity'] = 10;

    $response = putJson('api/v1/were-house/update', $whereHouse);

    $response->assertStatus(201)
        ->assertJsonCount(1);

    $this->assertDatabaseHas('were_houses', $whereHouse);

});


it('can make destroy were house', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $whereHouse = WereHouse::factory()->create()->toArray();

    $response = deleteJson("api/v1/were-house/destroy/{$whereHouse['id']}");

    $response->assertStatus(201);

    $this->assertDatabaseMissing('were_houses', $whereHouse);
});

