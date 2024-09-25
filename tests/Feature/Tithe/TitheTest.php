<?php

use App\Models\User;
use App\Models\Tithe;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can a create a tithe', function(){

      // Create a user with necessary roles or permissions
      $user = User::factory()->create(['role' => 'admin']);

      // Authenticate the user using Sanctum
      Sanctum::actingAs($user);

      // Create Tithe using factory
      $tithe = Tithe::factory()->make()->toArray();

      $tithe['user_id'] = $user->id;

      $response = postJson('api/v1/tithe/store', $tithe);
      $response->assertStatus(201);


        $this->assertDatabaseHas('tithe', $tithe);


});

it('can read all tithe', function () {
    // Criar um usuário com papéis ou permissões necessárias
    $user = User::factory()->create(['role' => 'admin']);

    // Autenticar o usuário usando Sanctum
    Sanctum::actingAs($user);

    $data = Tithe::factory()->make()->toArray();



    Tithe::create($data);

    // Enviar requisição GET para buscar todos os dízimos
    $response = getJson('api/v1/tithe/all');

    // Verificar se a requisição foi bem-sucedida (status 200 - OK)
    $response->assertStatus(200)
    ->assertJsonCount(1);
});

it('can show one tithe', function(){


       // Criar um usuário com papéis ou permissões necessárias
       $user = User::factory()->create(['role' => 'admin']);

       // Autenticar o usuário usando Sanctum
       Sanctum::actingAs($user);

       $data = Tithe::factory()->make()->toArray();


         $tithe = Tithe::create($data);

        $response = getJson("api/v1/tithe/show/{$tithe['id']}");

        $response->assertStatus(200)
         ->assertJsonCount(5);
});

it('can update the tithe', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Autenticar o usuário usando Sanctum
    Sanctum::actingAs($user);

    $data = Tithe::factory()->make()->toArray();


      $tithe = Tithe::create($data)->toArray();

      $tithe['value'] = 20.00;

      $response = putJson("api/v1/tithe/update", $tithe);

      $response->assertStatus(201);

      $this->assertDatabaseHas('tithe', $tithe);
});

it('can destroy the title', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Autenticar o usuário usando Sanctum
    Sanctum::actingAs($user);

    $data = Tithe::factory()->make()->toArray();

      $tithe = Tithe::create($data)->toArray();

      $response = deleteJson("api/v1/tithe/destroy/{$tithe['id']}");

      $response->assertStatus(201);

      $this->assertDatabaseMissing('tithe', $tithe);

});
