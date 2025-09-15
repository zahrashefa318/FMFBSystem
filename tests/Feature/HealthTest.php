<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * /** @test */
    
    public function health_endpoint_returns_ok()
    {
        $this->getJson('/api/health')
             ->assertOk()
             ->assertJson(['status' => 'ok']);
    }
}
