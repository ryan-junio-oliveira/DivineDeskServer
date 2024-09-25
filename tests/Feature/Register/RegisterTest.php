<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use Tests\TestCase;
use App\Models\User;

use Laravel\Sanctum\Sanctum;

uses(TestCase::class, RefreshDatabase::class);

it('can make register', function () {
    $user = ['name'=> 'zequinha','email' => 'naoclica@gmail.com', 'password' => '12346756'];

    $response = postJson('/api/auth/register', $user);

    $response->assertStatus(200)
        ->assertJsonCount(1);

    $this->assertDatabaseHas('users', ['email' => 'naoclica@gmail.com']);
});

it('can make login', function(){

    $user = ['name'=> 'zequinha','email' => 'naoclica@gmail.com', 'password' => '12346756'];

    $create = User::create($user);
    $data = ['email' => $user['email'], 'password' => $user['password']];

     $response = postJson('api/auth/login', $data);

     $response
     ->assertStatus(200);

     $this->assertDatabaseHas('users', [
        'email' => $user['email'],
    ]);
});


it('can make logout', function(){

    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = getJson('api/auth/logout');

    $response->assertStatus(200)
    ->assertJson([
        'message' => 'Logged out successfully'
    ]);
});
