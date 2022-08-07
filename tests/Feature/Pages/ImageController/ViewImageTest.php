<?php

namespace Tests\Feature\Pages\ImageController;

use App\Models\Image;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ViewImageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanShowImage()
    {
        $news = create('App\Models\News');
        $image = create('App\Models\Image', [
            'imageable_type' => 'App\Models\News',
            'imageable_id' => $news->id,
        ]);

        //$this->output($image->toArray());

        $file = UploadedFile::fake()->create($image->filename, 100, $image->mime);
        Storage::fake('local')->put(Image::IMAGE_PATH . $image->filename, $file);

        $this
            ->get('/image/' . $image->filename)
            ->assertStatus(200);
    }
}
