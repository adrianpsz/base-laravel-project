<?php

namespace Tests\Feature\Home\Images\Api\ImageController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewImageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanShowImages()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);
        $image = create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $this
            ->signIn()
            ->postApi(route('api.home.images.news', ['news' => $image->imageable->id]))
            ->assertJsonFragment([
                'filename' => $image->filename,
            ]);
    }

    /**
     * @test
     */
    public function itCanShowImagesOfOtherUsersAsAdmin()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);
        $image = create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $this
            ->signIn()
            ->postApi(route('api.home.images.news', ['news' => $image->imageable->id]))
            ->assertJsonFragment([
                'filename' => $image->filename,
            ]);
    }

    /**
     * @test
     */
    public function itCannotShowImagesOfOtherUsers()
    {
        $user = create('App\Models\User');
        $news = create('App\Models\News', [
            'user_id' => $user->id,
        ]);
        $image = create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->postApi(route('api.home.images.news', ['news' => $image->imageable->id]))
            ->assertUnauthorized();
    }
}
