<?php

namespace Tests\Unit;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SkillTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $skillData = [
        'name' => 'TestSkill',
    ];

    protected array $skillDataNew = [
        'name' => 'TestSkill2',
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
        Skill::query()->create($this->skillData);
        Skill::query()->create($this->skillDataNew);

        $this->json('GET', route('skill-all'))
            ->assertOk()
            ->assertJson([$this->skillData, $this->skillDataNew]);

        Skill::query()->truncate();

        $this->json('GET', route('skill-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var Skill $skill */
        $skill = Skill::query()->create($this->skillData);

        $this->json('GET', route('skill-create', $skill->id))
            ->assertOk()
            ->assertJson([$this->skillData]);

        Skill::query()->truncate();

        $this->json('GET', route('skill-one', $skill->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('skill-one', 1))
            ->assertNotFound();

        $this->json('POST', route('skill-create'), $this->skillData)
            ->assertCreated();

        $this->json('GET', route('skill-one', 1))
            ->assertOk()
            ->assertJson($this->skillData);
    }

    /**
     * @test
     */
    public function deleteSkill(): void
    {
        $this->json('DELETE', route('skill-delete', 1))
            ->assertOk();

        /** @var Skill $skill */
        $skill = Skill::query()->create($this->skillData);

        $this->json('GET', route('skill-one', $skill->id))
            ->assertOk();

        $this->json('DELETE', route('skill-delete', $skill->id))
            ->assertOk();

        $this->json('DELETE', route('skill-delete', $skill->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('skill-update', 13), $this->skillDataNew)
            ->assertNotFound();

        /** @var Skill $skill */
        $skill = Skill::query()->create($this->skillData);

        $this->patch(route('skill-update', $skill->id), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->patch(route('skill-update', $skill->id), $this->skillDataNew)
            ->assertOk()
            ->assertJson($this->skillDataNew);
    }
}
