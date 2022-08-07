<?php

namespace Tests\Feature\Home\Images\Api\ImageController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateImageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanReorderImages()
    {
        $news = create('App\Models\News', [
            'user_id' => $this->user->id,
        ]);
        $from = create('App\Models\Image', [
            'imageable_id' => $news->id,
            'order' => 1,
        ]);
        $to = create('App\Models\Image', [
            'imageable_id' => $news->id,
            'order' => 2,
        ]);

        $this
            ->signIn()
            ->putApi(route('api.home.images.reorder', [
                'from' => $from->id,
                'to' => $to,
            ]));

        $from->refresh();
        $to->refresh();

        $this->assertTrue($from->order > $to->order);
    }
}
