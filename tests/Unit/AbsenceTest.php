<?php

namespace Tests\Unit;

use App\Models\Absence;
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
        $user = TestHelper::getUser('superadmin');

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
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $absenceData = [
            'type' => 1,
            'user_id' => 2,
        ];

        $absence = Absence::query()->create($absenceData);

        $response = $this->json('GET', '/api/absence/' . $absence->id);

        $response->assertStatus(200);

        Absence::query()->findOrFail($absence->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $absenceData = [
            'type' => 1,
            'user_id' => 2,
        ];

        $response = $this->json('POST', '/api/absence', $absenceData);

        $response
            ->assertStatus(201)
            ->assertJson($absenceData);

        Absence::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteAbsence(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $absenceData = [
            'type' => 1,
            'user_id' => 2,
        ];

        $absence = Absence::query()->create($absenceData);
        $response = $this->json('DELETE', 'api/absence/' . $absence->id);

        $response->assertStatus(200);
    }
}
