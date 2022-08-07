<?php

namespace Tests\Feature\Home\Images\Api\ImageController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateImageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanResetIsActiveOfNewsAfterCreateImage()
    {
        $this->signIn();

        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
            'is_active' => 1,
        ]);

        create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $news->refresh();

        $this->assertEquals(0, $news->is_active);
    }

    /**
     * @test
     */
    public function itDoesNotChangeIsActiveOfNewsAfterCreateImageWhenUserIsAdmin()
    {
        $this->signInAsAdmin();

        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
            'is_active' => 1,
        ]);
        create('App\Models\Image', [
            'imageable_id' => $news->id,
        ]);

        $news->refresh();

        $this->assertEquals(1, $news->is_active);
    }
}
