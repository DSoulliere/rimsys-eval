<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\StoreToken;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class AuthController extends Controller
{


    /**
     * Store a token
     *
     * @param StoreToken $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function store(StoreToken $request)
    {
        $fields = $request->validated();
        $user = User::where('email', $fields)->firstOrFail();

        if ($user->is_disabled) {
            throw ValidationException::withMessages(['email' => trans('auth.disabled')]);
        }

        if (!Hash::check($fields['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => trans('auth.password')]);
        }

        $token = $user->createToken(config('app.name'))->plainTextToken;
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->save();
        return response()->json(['token' => $token]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */

    public function destroy(User $user, Request $request)
    {
        $token = $request->user()?->currentAccessToken();
        $token->delete();
        return response()->json(null, 204);
    }


}
