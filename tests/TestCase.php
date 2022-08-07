<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->disableExceptionHandling();
        $this->user = create('App\Models\User');
    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = app()->make(ExceptionHandler::class);
        app()->instance(ExceptionHandler::class, new PassThroughHandler);
    }

    /**
     * @return $this
     */
    protected function withExceptionHandling(): TestCase
    {
        app()->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    protected function signIn(User $user = null): TestCase
    {
        if (is_null($user))
            $this->actingAs($this->user);
        else
            $this->actingAs($user);
        return $this;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    protected function signInAsAdmin(User $user = null): TestCase
    {
        $id = 0;
        if (is_null($user)) {
            $this->actingAs($this->user);
            $id = $this->user->id;
        } else {
            $this->actingAs($user);
            $id = $user->id;
        }

        create('App\Models\RoleUser', [
            'user_id' => $id,
            'role_id' => Role::ADMIN
        ]);

        return $this;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    protected function signInSanctum(User $user = null): TestCase
    {
        if (is_null($user))
            $this->actingAs($this->user, 'sanctum');
        else
            $this->actingAs($user, 'sanctum');
        return $this;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    protected function signInSanctumAsAdmin(User $user = null): TestCase
    {
        $id = 0;
        if (is_null($user)) {
            $this->actingAs($this->user, 'sanctum');
            $id = $this->user->id;
        } else {
            $this->actingAs($user, 'sanctum');
            $id = $user->id;
        }

        create('App\Models\RoleUser', [
            'user_id' => $id,
            'role_id' => Role::ADMIN
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    protected function signOut(): TestCase
    {
        $this->post('/logout');
        return $this;
    }

    /**
     * @return string[]
     */
    protected function getAjaxHeaders(): array
    {
        return [
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * @return string[]
     */
    protected function getJsonHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return TestResponse
     */
    protected function postApi(string $uri, array $data = []): TestResponse
    {
        return $this->postJson($uri, $data, $this->getJsonHeaders());
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return TestResponse
     */
    protected function putApi(string $uri, array $data = []): TestResponse
    {
        return $this->putJson($uri, $data, $this->getJsonHeaders());
    }

    /**
     * @param string $uri
     * @param array $data
     *
     * @return TestResponse
     */
    protected function deleteApi(string $uri, array $data = []): TestResponse
    {
        return $this->deleteJson($uri, $data, $this->getJsonHeaders());
    }

    /**
     * @param string $uri
     * @param array $data
     * @return TestResponse
     */
    protected function postAjax(string $uri, array $data = []): TestResponse
    {
        return $this->postJson($uri, $data, $this->getAjaxHeaders());
    }

    /**
     * @param string $uri
     * @param array $data
     * @return TestResponse
     */
    protected function putAjax(string $uri, array $data = []): TestResponse
    {
        return $this->putJson($uri, $data, $this->getAjaxHeaders());
    }

    /**
     * @param string $uri
     * @param array $data
     * @return TestResponse
     */
    protected function deleteAjax(string $uri, array $data = []): TestResponse
    {
        return $this->deleteJson($uri, $data, $this->getAjaxHeaders());
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string $model
     * @param string $url
     * @param string|null $testField
     *
     * @return void
     */
    protected function wrongFieldValueCreateTest(string $field, $value, string $model, string $url, string $testField = null)
    {
        $model = make($model, [
            $field => $value
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->post($url, $model->toArray())
            ->assertSessionHasErrors(is_null($testField) ? $field : $testField);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param Model $model
     * @param string $url
     * @param string|null $testField
     *
     * @return void
     */
    protected function wrongFieldValueUpdateTest(string $field, $value, Model $model, string $url, string $testField = null)
    {
        $this
            ->withExceptionHandling()
            ->signIn()
            ->put($url, array_merge($model->toArray(), [$field => $value]))
            ->assertSessionHasErrors(is_null($testField) ? $field : $testField);
    }

    protected function output($output)
    {
        if (is_array($output) || is_object($output)) {
            fwrite(STDERR, print_r($output));
        } else {
            fwrite(STDERR, $output);
        }
    }
}

class PassThroughHandler extends Handler
{
    public function __construct()
    {
    }

    public function report(Throwable $e)
    {
    }

    public function render($request, Throwable $e)
    {
        throw $e;
    }
}
