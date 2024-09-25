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

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can create alert', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

      $alert = Alert::factory()->make()->toArray();

     $response = postJson('api/v1/alert/store',$alert);

     $response->assertStatus(200)
     ->assertJsonCount(1);
});

it('can make show all alerts', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $alert = Alert::factory()->create()->toArray();

    $response = getJson('api/v1/alert/all');

    $response->assertStatus(200)
        ->assertJsonCount(1);

    $this->assertDatabaseHas('alert', $alert);


});

it('can make show a alert', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $alert = Alert::factory()->create()->toArray();

    $response = getJson("api/v1/alert/show/{$alert['id']}");

    $response->assertStatus(200);
});

it('can make update alert', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $alert = Alert::factory()->create()->toArray();

    $alert['message'] = 'Jesus é lindo';

    $response = putJson('api/v1/alert/update', $alert);

    $response->assertStatus(201)
        ->assertJsonCount(1);
});

it('can make delete in alert', function(){

    $user = User::factory()->create(['role' => 'admin']);

    Sanctum::actingAs($user);

    $alert = Alert::factory()->create()->toArray();

    $response = deleteJson("api/v1/alert/destroy/{$alert['id']}");

    $response->assertStatus(201)
    ->assertJsonCount(1);

});
