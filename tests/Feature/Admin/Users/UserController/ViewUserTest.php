<?php

namespace Tests\Feature\Admin\Users\UserController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itIsOnlyForAdmin()
    {
        $route = route('admin.users');
        $this
            ->withExceptionHandling()
            ->signIn()
            ->get($route)
            ->assertNotFound();

        $this->signInAsAdmin()
            ->get($route)
            ->assertSee(__('Users'));
    }
}
