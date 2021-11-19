<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class NoteTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $noteData = [
        'name' => 'TestNote',
        'date' => '2021-11-17 14:57:12',
        'manager_id' => '5',
        'user_id' => '3',
    ];

    protected array $noteDataNew = [
        'name' => 'TestNote2',
        'date' => '2020-05-25 18:34:53',
        'manager_id' => '3',
        'user_id' => '2',
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
        Note::query()->create($this->noteData);
        Note::query()->create($this->noteDataNew);

        $this->json('GET', route('note-all'))
            ->assertOk()
            ->assertJson([$this->noteData, $this->noteDataNew]);

        Note::query()->truncate();

        $this->json('GET', route('note-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var Note $note */
        $note = Note::query()->create($this->noteData);

        $this->json('GET', route('note-create', $note->id))
            ->assertOk()
            ->assertJson([$this->noteData]);

        Note::query()->truncate();

        $this->json('GET', route('note-one', $note->id))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('note-one', 1))
            ->assertNotFound();

        $this->json('POST', route('note-create'), $this->noteData)
            ->assertCreated();

        $this->json('GET', route('note-one', 1))
            ->assertOk()
            ->assertJson($this->noteData);
    }

    /**
     * @test
     */
    public function deleteNote(): void
    {
        $this->json('DELETE', route('note-delete', 1))
            ->assertOk();

        /** @var Note $note */
        $note = Note::query()->create($this->noteData);

        $this->json('GET', route('note-one', $note->id))
            ->assertOk();

        $this->json('DELETE', route('note-delete', $note->id))
            ->assertOk();

        $this->json('DELETE', route('note-delete', $note->id))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('note-update', 13), $this->noteDataNew)
            ->assertNotFound();

        /** @var Note $note */
        $note = Note::query()->create($this->noteData);

        $this->patch(route('note-update', $note->id), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->patch(route('note-update', $note->id), $this->noteDataNew)
            ->assertOk()
            ->assertJson($this->noteDataNew);
    }
}
