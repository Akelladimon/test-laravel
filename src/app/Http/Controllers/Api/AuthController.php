<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Response\Helpers\BaseResponse;
use App\Services\User\AuthUserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group User management
 *
 * APIs for Auth users
 */
class AuthController extends Controller
{
    use BaseResponse;

    const API_LOGIN_NAME = 'login';
    const API_REGISTRATION_NAME = 'register';
    const API_CHANGE_PASSWORD_NAME = 'change_password';
    const API_LOGOUT_NAME = 'logout';

    public function __construct(protected AuthUserServices $authUserServices)
    {

    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            return $this->authUserServices->createUsers($request->all());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Login the user and return the API token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            return $this->authUserServices->loginUser($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function logout():JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        Auth::logout();

        return $this->sendResponse([], 'User Log out successfully.');
    }
}
