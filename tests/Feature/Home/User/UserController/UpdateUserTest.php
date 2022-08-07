<?php

namespace HomeController;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function itAllowsChangePassword()
    {
        $password = 'test1234';
        $newPassword = 'test4321';

        $user = create('App\Models\User', [
            'password' => bcrypt($password),
        ]);

        $this->signIn($user)
            ->post(route('home.users.updatePassword'), [
                'current-password' => $password,
                'new-password' => $newPassword,
                'new-password_confirmation' => $newPassword,
            ])
            ->assertSessionHas('success');
    }

    /**
     * @test
     */
    public function itAllowsChangePasswordWithApi()
    {
        $password = 'test1234';
        $newPassword = 'test4321';

        $user = create('App\Models\User', [
            'password' => bcrypt($password)
        ]);

        $this
            ->signInSanctum($user)
            ->postApi(route('api.home.users.changePassword'), [
                "current-password" => $password,
                "new-password" => $newPassword,
                "new-password_confirmation" => $newPassword,
            ])->assertExactJson([
                'message' => 'Your password has been changed.'
            ]);
    }

    /**
     * @test
     */
    public function itCannotChangePasswordWithWrongCurrentPassword()
    {
        $password = 'test1234';
        $wrongPassword = 'test11111';
        $newPassword = 'test4321';

        $user = create('App\Models\User', [
            'password' => bcrypt($password),
        ]);

        $this->signIn($user)
            ->withExceptionHandling()
            ->post(route('home.users.updatePassword'), [
                'current-password' => $wrongPassword,
                'new-password' => $newPassword,
                'new-password_confirmation' => $newPassword,
            ])
            ->assertSessionHasErrors('current-password');
    }
}
