<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiUtils;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use function view;

class UserController extends Controller
{
    use ApiUtils;

    /**
     * @return Application|Factory|View|AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::paginate(self::ITEMS_PER_PAGE);

        return $this->collectionWithView(
            UserResource::collection($users),
            view('admin.users.index', [
                'users' => $users,
            ])
        );
    }
}
