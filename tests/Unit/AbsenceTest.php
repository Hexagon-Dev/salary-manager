<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\User;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AbsenceTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected $absenceData = [
        'type' => 1,
        'user_id' => 2,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::query()->find(1);
    }

    /**
     * @test
     */
    public function showAll(): void
    {
        $this->actingAs($this->admin);

        $absenceDataSecond = [
            'type' => 1,
            'user_id' => 2,
        ];

        Absence::query()->create($this->absenceData);
        Absence::query()->create($absenceDataSecond);

        $this->json('GET', route('absence-all'))
            ->assertOk()
            ->assertJson([$this->absenceData, $absenceDataSecond]);

        Absence::query()->truncate();

        $this->json('GET', route('absence-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function showOne(): void
    {
        $this->actingAs($this->admin);

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
        $this->actingAs($this->admin);

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
        $this->actingAs($this->admin);

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
        $this->actingAs($this->admin);

        $absenceDataNew = [
            'type' => 2,
            'user_id' => 3,
        ];

        $this->patch(route('absence-update', 13), $absenceDataNew)
            ->assertStatus(Response::HTTP_NOT_FOUND);

        /** @var Absence $absence */
        $absence = Absence::query()->create($this->absenceData);



        $this->patch(route('absence-update', $absence->id), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->patch(route('absence-update', $absence->id), $absenceDataNew)
            ->assertOk()
            ->assertJson($absenceDataNew);
    }
}
