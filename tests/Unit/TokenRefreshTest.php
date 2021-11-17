<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class TokenRefreshTest extends TestCase
{
    /**
     * @test
     */
    public function tokenRefresh()
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $this->actingAs($user);

        $response = $this->json('POST', '/api/auth/refresh', []);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }
}
