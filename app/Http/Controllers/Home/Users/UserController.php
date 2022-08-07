<?php

namespace App\Http\Controllers\Home\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function changePassword()
    {
        return view('home.users.change_password');
    }

    /**
     * @param ChangePasswordRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $request->validated();

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('Your password has been changed.')
            ]);
        }

        return redirect()->route('home.users.changePassword')
            ->with("success", "Your password has been changed.");
    }
}
