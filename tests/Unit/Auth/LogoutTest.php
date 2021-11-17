<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTest extends TestCase
{
    /**
     * @test
     */
    public function logout()
    {
        $user = new User([
            'mail' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $this->actingAs($user);

        $response = $this->json('POST', '/api/auth/logout', []);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }
}
