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
    public function create(): void
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('POST', '/api/user', [
            'login' => 'test_name',
            'password' => 'testtest',
            'email' => 'test@test.com',
            'name' => 'test',
            'age' => '20',
            'name_on_project' => 4,
            'english_lvl' => 5,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'login' => 'test_name',
                'password' => 'testtest',
                'email' => 'test@test.com',
                'name' => 'test',
                'age' => '20',
                'name_on_project' => 4,
                'english_lvl' => 5,
            ]);
    }

    /**
     * @test
     */
    public function delete()
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $userData = [
            'login' => 'test_name',
            'password' => 'testtest',
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
