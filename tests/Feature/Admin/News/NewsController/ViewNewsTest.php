<?php

namespace Tests\Feature\Admin\News\NewsController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewNewsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itIsOnlyForAdmin()
    {
        $route = route('admin.news');
        $this
            ->withExceptionHandling()
            ->signIn()
            ->get($route)
            ->assertNotFound();

        $this->signInAsAdmin()
            ->get($route)
            ->assertSee(__('List of news'));
    }
}
