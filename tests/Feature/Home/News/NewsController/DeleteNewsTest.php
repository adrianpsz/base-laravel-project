<?php

namespace Tests\Feature\Home\News\NewsController;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteNewsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanDeleteNews()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id
        ]);

        $this
            ->signIn()
            ->delete(route('home.news.destroy', ['news' => $news->id]))
            ->assertSessionHas('success');

        $this->assertModelMissing($news);
    }

    /**
     * @test
     */
    public function itCanDeleteNewsOfOtherUsersAsAdmin()
    {
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $user->id
        ]);

        $this
            ->signInAsAdmin()
            ->delete(route('home.news.destroy', ['news' => $news->id]))
            ->assertSessionHas('success');

        $this->assertModelMissing($news);
    }

    /**
     * @test
     */
    public function itCannotDeleteNewsOfOtherUsers()
    {
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $user->id
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->delete(route('home.news.destroy', ['news' => $news->id]))
            ->assertForbidden();

        $this->assertModelExists($news);
    }
}
