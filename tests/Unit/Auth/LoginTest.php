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
        $response = $this->post('/api/auth/login', [
            'email' => 'superadmin@example.com',
            'password' => 'superadmin'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /**
     * @test
     */
    public function loginAsAdmin(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'admin@example.com',
            'password' => 'admin'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /**
     * @test
     */
    public function loginAsUser(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'user@example.com',
            'password' => 'user'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }

    /**
     * @test
     */
    public function loginAsGuest(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'guest@example.com',
            'password' => 'guest'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_in'
            ]);
    }
}
