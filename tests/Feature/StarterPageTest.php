<?php

namespace Tests\Feature;

use Tests\TestCase;

class StarterPageTest extends TestCase
{
    public function test_root_redirects_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_starter_pages_load_successfully(): void
    {
        $this->withoutVite();

        $this->get('/login')->assertOk();
        $this->get('/student/dashboard')->assertOk();
        $this->get('/teacher/dashboard')->assertOk();
        $this->get('/admin/dashboard')->assertOk();
    }
}
