<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $companyData = [
        'name' => 'Hex-Craft',
        'contacts' => 'Hexagon',
        'create_time' => '2021-11-18 14:11:36',
    ];

    protected array $companyDataNew = [
        'name' => 'Heroku',
        'contacts' => 'Valeriy',
        'create_time' => '2008-01-10 14:11:36',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::query()->find(1);

        $this->actingAs($this->admin);
    }

    /**
     * @test
     */
    public function showAll(): void
    {
        $response = $this->json('GET', '/api/company');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function readAll(): void
    {
        Company::query()->create($this->companyData);
        Company::query()->create($this->companyDataNew);

        $this->json('GET', route('company-all'))
            ->assertOk()
            ->assertJson([$this->companyData, $this->companyDataNew]);

        Company::query()->truncate();

        $this->json('GET', route('company-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var Company $company */
        $company = Company::query()->create($this->companyData);

        $this->json('GET', route('company-create', $company->id))
            ->assertOk()
            ->assertJson([$this->companyData]);

        Company::query()->truncate();

        $this->json('GET', route('company-one', $company->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('company-one', 1))
            ->assertNotFound();

        $this->json('POST', route('company-create'), $this->companyData)
            ->assertCreated();

        $this->json('GET', route('company-one', 1))
            ->assertOk()
            ->assertJson($this->companyData);
    }

    /**
     * @test
     */
    public function deleteCompany(): void
    {
        $this->json('DELETE', route('company-delete', 1))
            ->assertOk();

        /** @var Company $company */
        $company = Company::query()->create($this->companyData);

        $this->json('GET', route('company-one', $company->id))
            ->assertOk();

        $this->json('DELETE', route('company-delete', $company->id))
            ->assertOk();

        $this->json('DELETE', route('company-delete', $company->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('company-update', 13), $this->companyDataNew)
            ->assertNotFound();

        /** @var Company $company */
        $company = Company::query()->create($this->companyData);

        $this->patch(route('company-update', $company->id), $this->companyDataNew)
            ->assertOk()
            ->assertJson($this->companyDataNew);
    }
}
