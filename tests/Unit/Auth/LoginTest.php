<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     */
    public function loginAsSuperAdmin(): void
    {
        $response = $this->post('/api/login', [
            'login' => 'superadmin',
            'password' => 'superadmin'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function loginAsAdmin(): void
    {
        $response = $this->post('/api/login', [
            'login' => 'admin',
            'password' => 'admin'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function loginAsUser(): void
    {
        $response = $this->post('/api/login', [
            'login' => 'user',
            'password' => 'user'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function loginAsGuest(): void
    {
        $response = $this->post('/api/login', [
            'login' => 'guest',
            'password' => 'guest'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }
}
