<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_redirects_to_tasks(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('tasks.index'));
    }
}
