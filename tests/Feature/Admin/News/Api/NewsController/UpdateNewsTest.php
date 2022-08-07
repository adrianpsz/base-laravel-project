<?php

namespace Tests\Feature\Admin\News\Api\NewsController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateNewsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanToggleActivationOfNewsOnlyByAdmin()
    {
        $news = create('App\Models\News');

        $route = route('api.admin.news.toggleActivation', ['news' => $news->id]);
        $this
            ->withExceptionHandling()
            ->signIn()
            ->get($route)
            ->assertNotFound();

        $this
            ->signInAsAdmin()
            ->putApi($route);

        $news->refresh();
        $this->assertTrue($news->is_active == 1);
    }
}
