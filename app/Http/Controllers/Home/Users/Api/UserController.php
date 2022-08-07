<?php

namespace App\Http\Controllers\Home\Users\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @param $id
     *
     * @return UserResource
     *
     * @throws AuthorizationException
     */
    function show($id = null)
    {
        if (is_null($id))
            return new UserResource(Auth::user());

        $user = User::findOrFail($id);
        $this->authorize('view', $user);

        return new UserResource($user);
    }
}
