<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;
// use Illuminate\Foundation\Testing\DatabaseMigrations;

class APITest extends TestCase
{
    // use DatabaseMigrations;      //use this for testing database
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserRegister()
    {
        $response = $this->json('POST', '/api/register', [
            "name" => "testUser",
            "email" => Str::random(10)."@test.com",
            "password" => "password",
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            "success" => ["token", "name"]
        ]);
    }

    public function testUserLogin()
    {
        $response = $this->json('POST', '/api/login', [
            "email" => "ebuka@mail.com",
            "password" => "secret"
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            "success" => ["token"]
        ]);
    }

    public function testCategoryFetch()
    {
        $user = \App\Models\User::find(1);

        $response = $this->actingAs($user, 'api')
                    ->json('GET', '/api/categories')
                    ->assertStatus(200)
                    ->assertJsonStructure([
                        "*" => [
                            "id",
                            "name",
                            "created_at",
                            "updated_at",
                            "deleted_at"
                        ]
                    ]);
    }

    public function testCategoryCreation()
    {
        $this->withoutMiddleware();

        $response = $this->json('POST', '/api/categories', [
            "name" => Str::random(10),
        ]);

        $response->assertStatus(200)->assertJson([
            "status" => true,
            "message" => "Category Created"
        ]);
    }

    public function testCategoryDeletion()
    {
        $user = \App\Models\User::find(1);

        $category = \App\Models\Category::create(["name" => "Cat to delete"]);

        $response = $this->actingAs($user, 'api')
        ->json("DELETE", "/api/categories/{$category->id}");

        $response->assertStatus(200)->assertJson([
            "status" => true,
            "message" => "Category Deleted"
        ]);
    }
}
