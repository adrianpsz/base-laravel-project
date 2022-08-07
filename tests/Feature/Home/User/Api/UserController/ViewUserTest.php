<?php

namespace Home\User\Api\UserController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function create;

class ViewUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itCanShowUserData()
    {
        $this
            ->signInSanctum()
            ->postApi('/api/home/users/show')
            ->assertJsonFragment([
                'email' => $this->user->email
            ]);
    }
}
