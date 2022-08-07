<?php

namespace Home\HomeController;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function create;
use function route;

class ViewHomeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itAllowsOnlyAuthenticatedUsers()
    {
        $this
            ->withExceptionHandling()
            ->get(route('home'))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function itCanBeSeenByAuthenticatedUsers()
    {
        $this->signIn()
            ->get(route('home'))
            ->assertStatus(200);
    }

    /**
     * @test
     */
    public function itCanShowAdminPanel()
    {
        $admin = create('App\Models\User');
        $role = create('App\Models\RoleUser', [
            'user_id' => $admin->id,
            'role_id' => Role::ADMIN,
        ]);

        $this->signIn($admin)
            ->get(route('home'))
            ->assertSee('Admin panel');
    }

    /**
     * @test
     */
    public function itCanHideAdminPanelForNormalUser()
    {
        $user = create('App\Models\User');

        $this->signIn($user)
            ->get(route('home'))
            ->assertDontSee('Admin panel');
    }
}
