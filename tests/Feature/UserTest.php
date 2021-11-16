<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function login()
    {
        $response = $this->get('/api/login', [
            'login' => 'admin',
            'password' => 'admin'
        ]);

        $response->assertStatus(200);
    }
}
