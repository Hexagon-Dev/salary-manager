<?php

namespace Tests\Unit;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SalaryTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $salaryData = [
        'amount' => '500',
        'currency_id' => '1',
        'user_id' => '2',
    ];

    protected array $salaryDataNew = [
        'amount' => '100',
        'currency_id' => '2',
        'user_id' => '3',
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
    public function readAll(): void
    {
        Salary::query()->create($this->salaryData);
        Salary::query()->create($this->salaryDataNew);

        $this->json('GET', route('salary-all'))
            ->assertOk()
            ->assertJson([$this->salaryData, $this->salaryDataNew]);

        Salary::query()->truncate();

        $this->json('GET', route('salary-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var Salary $salary */
        $salary = Salary::query()->create($this->salaryData);

        $this->json('GET', route('salary-create', $salary->id))
            ->assertOk()
            ->assertJson([$this->salaryData]);

        Salary::query()->truncate();

        $this->json('GET', route('salary-one', $salary->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('salary-one', 1))
            ->assertNotFound();

        $this->json('POST', route('salary-create'), $this->salaryData)
            ->assertCreated();

        $this->json('GET', route('salary-one', 1))
            ->assertOk()
            ->assertJson($this->salaryData);
    }

    /**
     * @test
     */
    public function deleteSalary(): void
    {
        $this->json('DELETE', route('salary-delete', 1))
            ->assertOk();

        /** @var Salary $salary */
        $salary = Salary::query()->create($this->salaryData);

        $this->json('GET', route('salary-one', $salary->id))
            ->assertOk();

        $this->json('DELETE', route('salary-delete', $salary->id))
            ->assertOk();

        $this->json('DELETE', route('salary-delete', $salary->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('salary-update', 13), $this->salaryDataNew)
            ->assertNotFound();

        /** @var Salary $salary */
        $salary = Salary::query()->create($this->salaryData);

        $this->patch(route('salary-update', $salary->id), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->patch(route('salary-update', $salary->id), $this->salaryDataNew)
            ->assertOk()
            ->assertJson($this->salaryDataNew);
    }
}
