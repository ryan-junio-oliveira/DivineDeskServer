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
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);


it('can make create alert User', function(){

    $user = User::factory()->create(['role' => 'member']);

    Sanctum::actingAs($user);

    $alert = Alert::factory()->count(5)->create();

    $response = getJson('api/v1/alert-user/show');

    $response->assertStatus(200);
});
