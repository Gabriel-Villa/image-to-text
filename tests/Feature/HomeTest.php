<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_page_home_loads_correctly(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }
}
