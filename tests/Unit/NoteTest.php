<?php

namespace Tests\Unit;

use App\Models\Note;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class NoteTest extends TestCase
{
    /**
     * @test
     */
    public function showAll(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $response = $this->json('GET', '/api/note');

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

        $noteData = [
            'name' => 'TestNote',
            'date' => '2021-11-17 14:57:12',
            'manager_id' => '5',
            'user_id' => '3',
        ];

        $note = Note::query()->create($noteData);

        $response = $this->json('GET', '/api/note/' . $note->id);

        $response->assertStatus(200);

        Note::query()->findOrFail($note->id)->delete();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $noteData = [
            'name' => 'TestNote',
            'date' => '2021-11-17 14:57:12',
            'manager_id' => '5',
            'user_id' => '3',
        ];

        $response = $this->json('POST', '/api/note', $noteData);

        $response
            ->assertStatus(201)
            ->assertJson($noteData);

        Note::query()->findOrFail($response->json()['id'])->delete();
    }

    /**
     * @test
     */
    public function deleteNote(): void
    {
        $user = TestHelper::getUser('superadmin');

        $token = JWTAuth::fromUser($user);
        $this->withToken($token);

        $noteData = [
            'name' => 'TestNote',
            'date' => '2021-11-17 14:57:12',
            'manager_id' => '5',
            'user_id' => '3',
        ];

        $note = Note::query()->create($noteData);
        $response = $this->json('DELETE', 'api/note/' . $note->id);

        $response->assertStatus(200);
    }
}
