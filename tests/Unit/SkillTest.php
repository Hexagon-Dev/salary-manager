<?php

namespace Tests\Unit;

use App\Models\Skill;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SkillTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/skill');

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

        $skillData = [
            'name' => 'TestSkill',
        ];

        $skill = Skill::query()->create($skillData);

        $response = $this->json('GET', '/api/skill/' . $skill->id);

        $response->assertStatus(200);

        Skill::query()->findOrFail($skill->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $skillData = [
            'name' => 'TestSkill',
        ];

        $response = $this->json('POST', '/api/skill', $skillData);

        $response
            ->assertStatus(201)
            ->assertJson($skillData);

        Skill::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteSkill(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $skillData = [
            'name' => 'TestSkill',
        ];

        $skill = Skill::query()->create($skillData);
        $response = $this->json('DELETE', 'api/skill/' . $skill->id);

        $response->assertStatus(200);
    }
}
