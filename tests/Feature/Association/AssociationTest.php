<?php

use App\Models\Member;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\delete;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use Tests\TestCase;
use App\Models\Alert;
use App\Models\AlertUser;
use App\Models\Association;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can make association', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $association = Association::factory()->create()->toArray();

    $response = postJson('api/v1/association/store', $association);

    $response->assertStatus(201)
    ->assertJsonCount(1);

});

it('can make show all association', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $association = Association::factory()->create()->toArray();

    $response = getJson('api/v1/association/all');

    $response->assertStatus(200);

    $this->assertDatabaseHas('association', $association);

});

it('can make one association', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $association = Association::factory()->create()->toArray();

    $response = getJson('api/v1/association/show');

    $this->assertDatabaseHas('association', $association);

});

it('can make update one association', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $association = Association::factory()->create()->toArray();

    $association['name'] = 'junior';

    $response = putJson('/api/v1/association/update',$association);

    $response->assertStatus(201)
    ->assertJsonCount(1);

    $this->assertDatabaseHas('association', $association);
});


it('can make destroy', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $association = Association::factory()->create()->toArray();

    $response = deleteJson("/api/v1/association/destroy/{$association['id']}");

    $response->assertStatus(201)
    ->assertJsonCount(1);

    $this->assertDatabaseMissing('association', $association);

});
