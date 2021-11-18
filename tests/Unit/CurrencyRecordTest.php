<?php

namespace Tests\Unit;

use App\Models\CurrencyRecord;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CurrencyRecordTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/currency_record');

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

        $currency_recordData = [
            'company_id' => '5',
            'project_salary' => '50000',
            'currency_id' => '1',
            'bank_rate' => '5',
            'tax_rate' => '2',
            'net' => '2',
            'month' => '3',
            'operation_date' => '2021-11-17 14:44:00',
        ];

        $currency_record = CurrencyRecord::query()->create($currency_recordData);

        $response = $this->json('GET', '/api/currency_record/' . $currency_record->id);

        $response->assertStatus(200);

        CurrencyRecord::query()->findOrFail($currency_record->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $currency_recordData = [
            'company_id' => '5',
            'project_salary' => '50000',
            'currency_id' => '1',
            'bank_rate' => '5',
            'tax_rate' => '2',
            'net' => '2',
            'month' => '3',
            'operation_date' => '2021-11-17 14:44:00',
        ];

        $response = $this->json('POST', '/api/currency_record', $currency_recordData);

        $response
            ->assertStatus(201)
            ->assertJson($currency_recordData);

        CurrencyRecord::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteCurrencyRecord(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $currency_recordData = [
            'company_id' => '5',
            'project_salary' => '50000',
            'currency_id' => '1',
            'bank_rate' => '5',
            'tax_rate' => '2',
            'net' => '2',
            'month' => '3',
            'operation_date' => '2021-11-17 14:44:00',
        ];

        $currency_record = CurrencyRecord::query()->create($currency_recordData);
        $response = $this->json('DELETE', 'api/currency_record/' . $currency_record->id);

        $response->assertStatus(200);
    }
}
