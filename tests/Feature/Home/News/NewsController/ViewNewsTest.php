<?php

namespace Tests\Feature\Home\News\NewsController;

use App\Models\Role;
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
    public function itCanShowUserNews()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id
        ]);

        $this
            ->signIn()
            ->get(route('home.news.index'))
            ->assertSee($news->title);
    }

    /**
     * @test
     */
    public function itCanShowOwnNews()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id
        ]);

        $this
            ->signIn()
            ->get(route('home.news.show', ['news' => $news->id]))
            ->assertSee($news->title);
    }

    /**
     * @test
     */
    public function itDoesNotShowNewsOfOtherUsers()
    {
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $this->user->id
        ]);

        $this
            ->signIn($user)
            ->get(route('home.news.index'))
            ->assertDontSee($news->title);
    }

    /**
     * @test
     */
    public function itDoesNotShowOneNewsOfOtherUsers()
    {
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $this->user->id
        ]);

        $this
            ->withExceptionHandling()
            ->signIn($user)
            ->get(route('home.news.show', ['news' => $news->id]))
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function itCanShowNewsOfOtherUsersAsAdmin()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id
        ]);

        $this
            ->withExceptionHandling()
            ->signInAsAdmin()
            ->get(route('home.news.show', ['news' => $news->id]))
            ->assertSee($news->title);
    }
}
