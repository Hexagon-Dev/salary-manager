<?php

namespace Tests\Unit;

use App\Models\Salary;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SalaryTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/salary');

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

        $salaryData = [
            'amount' => '500',
            'currency_id' => '1',
            'user_id' => '2',
        ];

        $salary = Salary::query()->create($salaryData);

        $response = $this->json('GET', '/api/salary/' . $salary->id);

        $response->assertStatus(200);

        Salary::query()->findOrFail($salary->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $salaryData = [
            'amount' => '500',
            'currency_id' => '1',
            'user_id' => '2',
        ];

        $response = $this->json('POST', '/api/salary', $salaryData);

        $response
            ->assertStatus(201)
            ->assertJson($salaryData);

        Salary::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteSalary(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $salaryData = [
            'amount' => '500',
            'currency_id' => '1',
            'user_id' => '2',
        ];

        $salary = Salary::query()->create($salaryData);
        $response = $this->json('DELETE', 'api/salary/' . $salary->id);

        $response->assertStatus(200);
    }
}
