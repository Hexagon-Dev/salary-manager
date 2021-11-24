<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AbsenceTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $absenceData = [
        'type' => 1,
        'user_id' => 2,
    ];

    protected array $absenceDataNew = [
        'type' => 2,
        'user_id' => 3,
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
        Absence::query()->create($this->absenceData);
        Absence::query()->create($this->absenceDataNew);

        $this->json('GET', route('absence-all'))
            ->assertOk()
            ->assertJson([$this->absenceData, $this->absenceDataNew]);

        Absence::query()->truncate();

        $this->json('GET', route('absence-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var Absence $absence */
        $absence = Absence::query()->create($this->absenceData);

        $this->json('GET', route('absence-create', $absence->id))
            ->assertOk()
            ->assertJson([$this->absenceData]);

        Absence::query()->truncate();

        $this->json('GET', route('absence-one', $absence->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('absence-one', 1))
            ->assertNotFound();

        $this->json('POST', route('absence-create'), $this->absenceData)
            ->assertCreated();

        $this->json('GET', route('absence-one', 1))
            ->assertOk()
            ->assertJson($this->absenceData);
    }

    /**
     * @test
     */
    public function deleteAbsence(): void
    {
        $this->json('DELETE', route('absence-delete', 1))
            ->assertOk();

        /** @var Absence $absence */
        $absence = Absence::query()->create($this->absenceData);

        $this->json('GET', route('absence-one', $absence->id))
            ->assertOk();

        $this->json('DELETE', route('absence-delete', $absence->id))
            ->assertOk();

        $this->json('DELETE', route('absence-delete', $absence->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('absence-update', 13), $this->absenceDataNew)
            ->assertNotFound();

        /** @var Absence $absence */
        $absence = Absence::query()->create($this->absenceData);

        $this->patch(route('absence-update', $absence->id), $this->absenceDataNew)
            ->assertOk()
            ->assertJson($this->absenceDataNew);
    }
}
