<?php

namespace Pages\Api\ApiController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function create;
use function route;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanSendContactMessage()
    {
        $message = create('App\Models\ContactMessage');

        $this
            ->withExceptionHandling()
            ->postAjax(route('ajax.contact'),
                array_merge($message->toArray(), ['href' => route('contact')]),
            )
            ->assertExactJson([
                'status' => 'OK'
            ]);
    }
}
