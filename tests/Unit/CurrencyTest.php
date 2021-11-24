<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $currencyData = [
        'name' => 'dollar',
        'rate' => '54',
        'symbol' => '$',
    ];

    protected array $currencyDataNew = [
        'name' => 'euro',
        'rate' => '70',
        'symbol' => 'e',
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
        Currency::query()->create($this->currencyData);
        Currency::query()->create($this->currencyDataNew);

        $this->json('GET', route('currency-all'))
            ->assertOk()
            ->assertJson([$this->currencyData, $this->currencyDataNew]);

        Currency::query()->truncate();

        $this->json('GET', route('currency-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var Currency $currency */
        $currency = Currency::query()->create($this->currencyData);

        $this->json('GET', route('currency-create', $currency->id))
            ->assertOk()
            ->assertJson([$this->currencyData]);

        Currency::query()->truncate();

        $this->json('GET', route('currency-one', $currency->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('currency-one', 1))
            ->assertNotFound();

        $this->json('POST', route('currency-create'), $this->currencyData)
            ->assertCreated();

        $this->json('GET', route('currency-one', 1))
            ->assertOk()
            ->assertJson($this->currencyData);
    }

    /**
     * @test
     */
    public function deleteCurrency(): void
    {
        $this->json('DELETE', route('currency-delete', 1))
            ->assertOk();

        /** @var Currency $currency */
        $currency = Currency::query()->create($this->currencyData);

        $this->json('GET', route('currency-one', $currency->id))
            ->assertOk();

        $this->json('DELETE', route('currency-delete', $currency->id))
            ->assertOk();

        $this->json('DELETE', route('currency-delete', $currency->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('currency-update', 13), $this->currencyDataNew)
            ->assertNotFound();

        /** @var Currency $currency */
        $currency = Currency::query()->create($this->currencyData);

        $this->patch(route('currency-update', $currency->id), $this->currencyDataNew)
            ->assertOk()
            ->assertJson($this->currencyDataNew);
    }
}
