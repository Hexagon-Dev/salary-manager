<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenRefreshTest extends TestCase
{
    /**
     * @test
     */
    public function tokenRefresh(): void
    {
        $user = User::query()->where('login', 'superadmin')->firstOrFail();

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('POST', '/api/auth/refresh');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }
}
