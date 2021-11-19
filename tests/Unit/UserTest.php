<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @var Authenticatable|User */
    protected $admin;

    protected array $userData = [
        'login' => 'test_name',
        'password' => 'test_password',
        'email' => 'test@test.com',
        'name' => 'test',
        'age' => '20',
        'name_on_project' => '4',
        'english_lvl' => '5',
    ];

    protected array $userDataNew = [
        'login' => 'test_name2',
        'password' => 'test_password2',
        'email' => 'test2@test.com',
        'name' => 'test2',
        'age' => '35',
        'name_on_project' => '2',
        'english_lvl' => '7',
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
        User::query()->create($this->userData);
        User::query()->create($this->userDataNew);

        $this->json('GET', route('user-all'))
            ->assertOk()
            ->assertJson([4 => $this->userData, 5 => $this->userDataNew]);

        User::query()->truncate();

        $this->json('GET', route('user-all'))
            ->assertOk()
            ->assertJson([]);
    }

    /**
     * @test
     */
    public function readOne(): void
    {
        /** @var User $user */
        $user = User::query()->create($this->userData);

        $this->json('GET', route('user-create', $user->login))
            ->assertOk()
            ->assertJson([4 => $this->userData]);

        User::query()->truncate();

        $this->json('GET', route('user-one', $user->login))
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function create(): void
    {
        $this->json('GET', route('user-one', 'test_name'))
            ->assertNotFound();

        $this->json('POST', route('user-create'), $this->userData)
            ->assertCreated();

        $this->json('GET', route('user-one', 'test_name'))
            ->assertOk()
            ->assertJson(collect($this->userData)->except('password')->toArray());
    }

    /**
     * @test
     */
    public function deleteUser(): void
    {
        $this->json('DELETE', route('user-delete', 'test_name'))
            ->assertOk();

        /** @var User $user */
        $user = User::query()->create($this->userData);

        $this->json('GET', route('user-one', $user->login))
            ->assertOk();

        $this->json('DELETE', route('user-delete', $user->login))
            ->assertOk();

        $this->json('DELETE', route('user-delete', $user->login))
            ->assertOk();
    }

    /**
     * @test
     */
    public function update(): void
    {
        $this->patch(route('user-update', 13), $this->userDataNew)
            ->assertNotFound();

        /** @var User $user */
        $user = User::query()->create($this->userData);

        $this->patch(route('user-update', $user->login), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->patch(route('user-update', $user->login), $this->userDataNew)
            ->assertOk()
            ->assertJson($this->userDataNew);
    }
}
