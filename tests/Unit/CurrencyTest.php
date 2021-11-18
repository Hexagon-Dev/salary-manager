<?php

namespace Tests\Unit;

use App\Models\Currency;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CurrencyTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/currency');

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

        $currencyData = [
            'name' => 'dollar',
            'rate' => '54',
            'symbol' => '$',
        ];

        $currency = Currency::query()->create($currencyData);

        $response = $this->json('GET', '/api/currency/' . $currency->id);

        $response->assertStatus(200);

        Currency::query()->findOrFail($currency->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $currencyData = [
            'name' => 'dollar',
            'rate' => '54',
            'symbol' => '$',
        ];

        $response = $this->json('POST', '/api/currency', $currencyData);

        $response
            ->assertStatus(201)
            ->assertJson($currencyData);

        Currency::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteCurrency(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $currencyData = [
            'name' => 'dollar',
            'rate' => '54',
            'symbol' => '$',
        ];

        $currency = Currency::query()->create($currencyData);
        $response = $this->json('DELETE', 'api/currency/' . $currency->id);

        $response->assertStatus(200);
    }
}
