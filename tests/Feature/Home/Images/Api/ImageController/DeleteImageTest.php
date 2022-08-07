<?php

namespace Tests\Feature\Home\Images\Api\ImageController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteImageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanDeleteImage()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);
        $image = create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $this
            ->signIn()
            ->deleteApi(route('api.home.images.destroy', ['image' => $image->id]));

        $this->assertModelMissing($image);
    }

    /**
     * @test
     */
    public function itCanDeleteImageOfOtherUserAsAdmin()
    {
        $news = create('App\Models\News');
        $image = create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $this
            ->signInAsAdmin()
            ->deleteApi(route('api.home.images.destroy', ['image' => $image->id]));

        $this->assertModelMissing($image);
    }

    /**
     * @test
     */
    public function itCannotDeleteImageOfOtherUsers()
    {
        $news = create('App\Models\News');
        $image = create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->deleteApi(route('api.home.images.destroy', ['image' => $image->id]))
            ->assertUnauthorized();

        $this->assertModelExists($image);
    }
}
