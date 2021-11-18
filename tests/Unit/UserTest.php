<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);
        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/user');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function showOne(): void
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/user', ['login' => 'user']);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function UserCreate(): void
    {
        $userData = [
            'login' => 'test_name',
            'password' => 'test_password',
            'email' => 'test@test.com',
            'name' => 'test',
            'age' => '20',
            'name_on_project' => '4',
            'english_lvl' => '5',
        ];

        $response = $this->json('POST', '/api/user', $userData);

        $userData = collect($userData)->except('password')->toArray();

        $response
            ->assertStatus(200)
            ->assertJson($userData);
    }

    /**
     * @test
     */
    public function userCreatedInDatabase(): void
    {
        $userData = [
            'login' => 'test_name',
            'password' => 'test_password',
            'email' => 'test@test.com',
            'name' => 'test',
            'age' => '20',
            'name_on_project' => '4',
            'english_lvl' => '5',
        ];

        $this->json('POST', '/api/user', $userData);

        $userData = collect($userData)->except('password')->toArray();

        $this->assertDatabaseHas('users', $userData);
    }

    /**
     * @test
     */
    public function deleteUser(): void
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $userData = [
            'login' => 'test_name',
            'password' => 'test_test',
            'email' => 'test@test.com',
            'name' => 'test',
            'age' => '20',
            'name_on_project' => 4,
            'english_lvl' => 5,
        ];

        $this->json('POST', '/api/user', $userData);

        $response = $this->json('DELETE', 'api/user' . $userData['login']);

        $response->assertStatus(200);
    }
}
