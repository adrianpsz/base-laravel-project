<?php

namespace Tests\Feature\Pages\PagesController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewPagesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanShowActiveNews()
    {
        $news = create('App\Models\News', [
            'is_active' => 1
        ]);

        $this->get(route('index'))
            ->assertSee($news->title);
    }

    /**
     * @test
     */
    public function itDoesNotShowInactiveNews()
    {
        $news = create('App\Models\News');

        $this->get(route('index'))
            ->assertDontSee($news->title);
    }
}
