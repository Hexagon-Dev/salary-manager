<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTest extends TestCase
{
    /**
     * @test
     */
    public function logout(): void
    {
        $user = User::query()->where('login', 'superadmin')->firstOrFail();

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('POST', '/api/auth/logout', []);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }
}
