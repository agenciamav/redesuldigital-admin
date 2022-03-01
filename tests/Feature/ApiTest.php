<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_api_response()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }

}
