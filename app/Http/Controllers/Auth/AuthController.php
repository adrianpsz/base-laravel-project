<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\NewUserHasSignedUpJob;
use App\Mail\ApiForgotYourPasswordMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use function response;
use function trans;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8,mixedCase',
            'device_name' => 'required',
            'terms' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'terms' => 1
        ]);

        $this->dispatch(new NewUserHasSignedUpJob($user));

        return $user->createToken($request->device_name)->plainTextToken;
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function forgotYourPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'url' => 'required|url'
        ]);

        $broker = Password::broker();
        $response = Password::RESET_LINK_SENT;
        $user = $broker->getUser($request->only('email'));
        if (is_null($user)) {
            throw ValidationException::withMessages([
                'email' => [trans(Password::INVALID_USER)],
            ]);
        }
        if ($broker->getRepository()->recentlyCreatedToken($user)) {
            throw ValidationException::withMessages([
                'email' => [trans(Password::RESET_THROTTLED)],
            ]);
        }

        $token = $broker->getRepository()->create($user);

        Mail::to($user->email)
            ->send(new ApiForgotYourPasswordMail($user,
                $request->get('url') . '/' . $token . '?email=' . $user->email));

        if ($response == Password::RESET_LINK_SENT) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        throw ValidationException::withMessages([
            'email' => [trans($response)],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], []);

        $response = Password::broker()->reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ), function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
        );

        if ($response == Password::PASSWORD_RESET) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        throw ValidationException::withMessages([
            'email' => [trans($response)],
        ]);
    }
}
