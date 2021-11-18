<?php

namespace Tests\Unit;

use App\Models\Company;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/company');

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

        $companyData = [
            'name' => 'Hex-Craft',
            'contacts' => 'Hexagon',
            'create_time' => '2021-11-18 14:11:36',
        ];

        $company = Company::query()->create($companyData);

        $response = $this->json('GET', '/api/company/' . $company->id);

        $response->assertStatus(200);

        Company::query()->findOrFail($company->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $companyData = [
            'name' => 'Hex-Craft',
            'contacts' => 'Hexagon',
            'create_time' => '2021-11-18 14:11:36',
        ];

        $response = $this->json('POST', '/api/company', $companyData);

        $response
            ->assertStatus(201)
            ->assertJson($companyData);

        Company::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteCompany(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $companyData = [
            'name' => 'Hex-Craft',
            'contacts' => 'Hexagon',
            'create_time' => '2021-11-18 14:11:36',
        ];

        $company = Company::query()->create($companyData);
        $response = $this->json('DELETE', 'api/company/' . $company->id);

        $response->assertStatus(200);
    }
}
