<?php

namespace Tests\Unit;

use App\Models\User;
use Carbon\Traits\Timestamp;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AbsenceTest extends TestCase
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

        $response = $this->json('GET', '/api/absence');

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

        $response = $this->json('GET', '/api/absence/1');

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

        $absenceData = [
            'type' => 1,
            'persone_id' => 2,
        ];

        $response = $this->json('POST', '/api/absence', $absenceData);

        $response
            ->assertStatus(200)
            ->assertJson($absenceData);
    }
}
