<?php

namespace Tests\Feature\Home\News\NewsController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateNewsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanUpdateNews()
    {
        $newValues = [
            'title' => 'News title 2.0',
            'message' => 'Message 2.0',
        ];
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);

        $response = $this
            ->signIn()
            ->put(route('home.news.update', ['news' => $news->id]),
                array_merge($news->toArray(), $newValues));

        $response
            ->assertSessionHas('success')
            ->assertRedirect(route('home.news.edit', ['news' => $news->id]));

        $response = $this->followRedirects($response);

        $response
            ->assertSee($newValues['title'])
            ->assertSee($newValues['message']);
    }

    /**
     * @test
     */
    public function itCannotUpdateNewsOfOtherUsers()
    {
        $newValues = [
            'title' => 'News title 2.0',
            'message' => 'Message 2.0',
        ];
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $user->id,
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->put(route('home.news.update', ['news' => $news->id]),
                array_merge($news->toArray(), $newValues))
            ->assertForbidden();

    }

    /**
     * @test
     */
    public function itCanUpdateNewsOfOtherUsersAsAdmin()
    {
        $newValues = [
            'title' => 'News title 2.0',
            'message' => 'Message 2.0',
        ];
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $user->id,
        ]);

        $this
            ->withExceptionHandling()
            ->signInAsAdmin()
            ->put(route('home.news.update', ['news' => $news->id]),
                array_merge($news->toArray(), $newValues))
            ->assertSessionHas('success');

    }

    /**
     * @test
     */
    public function itCannotUpdateNewsWithEmptyTitle()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);

        $this->wrongFieldValueUpdateTest('title', '', $news, route('home.news.update', ['news' => $news->id]));
    }

    /**
     * @test
     */
    public function itCannotUpdateNewsWithShortTitle()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);

        $this->wrongFieldValueUpdateTest('title', 'aa', $news, route('home.news.update', ['news' => $news->id]));
    }

    /**
     * @test
     */
    public function itCannotUpdateNewsWithEmptyMessage()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);

        $this->wrongFieldValueUpdateTest('message', '', $news, route('home.news.update', ['news' => $news->id]));
    }

    /**
     * @test
     */
    public function itCannotUpdateNewsWithShortMessage()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);

        $this->wrongFieldValueUpdateTest('message', 'aa', $news, route('home.news.update', ['news' => $news->id]));
    }

    /**
     * @test
     */
    public function itCannotUpdateNewsWithMoreThanFiveFiles()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);
        create('App\Models\Image', [
            'imageable_type' => 'App\Models\News',
            'imageable_id' => $news->id,
        ]);

        $this->wrongFieldValueUpdateTest('images', [
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
        ], $news, route('home.news.update', ['news' => $news->id]));
    }

    /**
     * @test
     */
    public function itCannotUpdateNewsWithTooBigFile()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);

        $this->wrongFieldValueUpdateTest('images', [
            UploadedFile::fake()->create('01.jpg', 1024 * 2, 'image/jpg'),
        ], $news, route('home.news.update', ['news' => $news->id]), 'images.0');
    }

    /**
     * @test
     */
    public function itCanResetIsActiveAfterUpdate()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
            'is_active' => 1,
        ]);

        $response = $this
            ->signIn()
            ->put(route('home.news.update', ['news' => $news->id]),
                array_merge($news->toArray(), [
                    'title' => 'New title'
                ]));

        $news->refresh();

        $this->assertEquals(0, $news->is_active);
    }
}
