<?php

use App\Models\Member;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can create a member', function () {
    // Create a user with necessary roles or permissions
    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    // Create member data
    $memberData = Member::factory()->make()->toArray();

    // Make a POST request to create a member
    $response = postJson('api/v1/members/store', $memberData);

    // Assert the response status
    $response->assertStatus(201);

    // Assert that the member data exists in the database
    $this->assertDatabaseHas('members', $memberData);
});

it('can make read all members', function(){

    // Create a user with necessary roles or permissions
    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);

    $memberData = Member::factory()->count(5)->create()->toArray();

    $response = getJson('api/v1/members/all');

    $response->assertStatus(200);

    $this->assertDatabaseHas('members', $memberData[4]);

});

it(' can show one member', function(){

    $user = User::factory()->create(['role' => 'admin']);

    // Authenticate the user using Sanctum
    Sanctum::actingAs($user);


    $memberData = Member::factory()->create()->toArray();

    $response = getJson("api/v1/members/show/{$memberData['id']}");

    $response->assertStatus(200)
        ->assertJsonCount(7);


    $this->assertDatabaseHas('members',$memberData);

});


it('can make update to members', function(){

        // Create a user with necessary roles or permissions
        $user = User::factory()->create(['role' => 'admin']);

        // Authenticate the user using Sanctum
        Sanctum::actingAs($user);

         // Create member data
        $memberData = Member::factory()->create()->toArray();

        $memberData['name'] = 'Junior';

        $response = putJson("api/v1/members/update",$memberData);

        $response->assertStatus(201)
            ->assertJsonCount(1);


        $this->assertDatabaseHas('members',$memberData);

});

it('can delete a members', function(){

         // Create a user with necessary roles or permissions
         $user = User::factory()->create(['role' => 'admin']);

         // Authenticate the user using Sanctum
         Sanctum::actingAs($user);

         $memberData = Member::factory()->create()->toArray();


         $response = deleteJson("api/v1/members/destroy/{$memberData['id']}");

         $response->assertStatus(201)
             ->assertJsonCount(1);


             $this->assertDatabaseMissing('members', $memberData);
});






