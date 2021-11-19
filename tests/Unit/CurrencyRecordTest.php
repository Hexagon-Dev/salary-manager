<?php

namespace Tests\Unit;

use App\Models\CurrencyRecord;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CurrencyRecordTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $currency_recordData = [
        'company_id' => '5',
        'project_salary' => '50000',
        'currency_id' => '1',
        'bank_rate' => '5',
        'tax_rate' => '2',
        'net' => '2',
        'month' => '3',
        'operation_date' => '2021-11-17 14:44:00',
    ];

    protected array $currency_recordDataNew = [
        'company_id' => '2',
        'project_salary' => '70000',
        'currency_id' => '2',
        'bank_rate' => '4',
        'tax_rate' => '3',
        'net' => '5',
        'month' => '7',
        'operation_date' => '2021-12-18 18:22:12',
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
        CurrencyRecord::query()->create($this->currency_recordData);
        CurrencyRecord::query()->create($this->currency_recordDataNew);

        $this->json('GET', route('currency_record-all'))
            ->assertOk()
            ->assertJson([$this->currency_recordData, $this->currency_recordDataNew]);

        CurrencyRecord::query()->truncate();

        $this->json('GET', route('currency_record-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var CurrencyRecord $currency_record */
        $currency_record = CurrencyRecord::query()->create($this->currency_recordData);

        $this->json('GET', route('currency_record-create', $currency_record->id))
            ->assertOk()
            ->assertJson([$this->currency_recordData]);

        CurrencyRecord::query()->truncate();

        $this->json('GET', route('currency_record-one', $currency_record->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('currency_record-one', 1))
            ->assertNotFound();

        $this->json('POST', route('currency_record-create'), $this->currency_recordData)
            ->assertCreated();

        $this->json('GET', route('currency_record-one', 1))
            ->assertOk()
            ->assertJson($this->currency_recordData);
    }

    /**
     * @test
     */
    public function deleteCurrencyRecord(): void
    {
        $this->json('DELETE', route('currency_record-delete', 1))
            ->assertOk();

        /** @var CurrencyRecord $currency_record */
        $currency_record = CurrencyRecord::query()->create($this->currency_recordData);

        $this->json('GET', route('currency_record-one', $currency_record->id))
            ->assertOk();

        $this->json('DELETE', route('currency_record-delete', $currency_record->id))
            ->assertOk();

        $this->json('DELETE', route('currency_record-delete', $currency_record->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('currency_record-update', 13), $this->currency_recordDataNew)
            ->assertNotFound();

        /** @var CurrencyRecord $currency_record */
        $currency_record = CurrencyRecord::query()->create($this->currency_recordData);

        $this->patch(route('currency_record-update', $currency_record->id), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->patch(route('currency_record-update', $currency_record->id), $this->currency_recordDataNew)
            ->assertOk()
            ->assertJson($this->currency_recordDataNew);
    }
}
