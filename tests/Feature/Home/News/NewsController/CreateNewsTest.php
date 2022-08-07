<?php

namespace Home\News\NewsController;

use App\Models\Image;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateNewsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanCreateNewsWithoutImages()
    {
        $news = make('App\Models\News');

        $this
            ->signIn()
            ->post(route('home.news.store'), $news->toArray())
            ->assertSessionHas('success')
            ->assertRedirect(route('home.news.index'));
    }

    /**
     * @test
     */
    public function itCanCreateNewsWithImages()
    {
        Storage::fake('local');

        $news = make('App\Models\News');

        $response = $this
            ->signIn()
            ->post(route('home.news.store'), array_merge($news->toArray(), [
                'images' => [
                    UploadedFile::fake()->image('01.jpg'),
                    UploadedFile::fake()->image('02.jpg'),
                ]
            ]));

        $response
            ->assertSessionHas('success')
            ->assertRedirect(route('home.news.index'));

        $files = Storage::disk('local')->files(Image::IMAGE_PATH);
        $this->assertTrue(count($files) == 2);
    }

    /**
     * @test
     */
    public function itCannotCreateNewsWithoutTitle()
    {
        $this->wrongFieldValueCreateTest('title', '', 'App\Models\News', route('home.news.store'));
    }

    /**
     * @test
     */
    public function itCannotCreateNewsWithShortTitle()
    {
        $this->wrongFieldValueCreateTest('title', 'aa', 'App\Models\News', route('home.news.store'));
    }

    /**
     * @test
     */
    public function itCannotCreateNewsWithoutMessage()
    {
        $this->wrongFieldValueCreateTest('message', '', 'App\Models\News', route('home.news.store'));
    }

    /**
     * @test
     */
    public function itCannotCreateNewsWithMoreThanFiveFiles()
    {
        $this->wrongFieldValueCreateTest('images', [
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
            UploadedFile::fake()->image('01.jpg'),
        ], 'App\Models\News', route('home.news.store'));
    }

    /**
     * @test
     */
    public function itCannotCreateNewsWithTooBigFile()
    {
        $this->wrongFieldValueCreateTest('images', [
            UploadedFile::fake()->create('01.jpg', 1024 * 2, 'image/jpg'),
        ], 'App\Models\News', route('home.news.store'), 'images.0');
    }
}
