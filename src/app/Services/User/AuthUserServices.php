<?php

namespace App\Services\User;

use App\Http\Requests\User\LoginRequest;
use App\Http\Response\Helpers\BaseResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthUserServices
{
     use BaseResponse;

     private string $appName;

     public function __construct()
     {
         $this->appName = config('app.name', 'test');
     }

    public function loginUser(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt([User::EMAIL_ATTRIBUTE => $request->email,
            User::PASSWORD_ATTRIBUTE => $request->password])) {
            return $this->sendError('wrong email or password',[],422);
        }

        $user = Auth::user();
        if (!$user) {
            return $this->sendError('wrong email or password',[],422);
        }

        $token = $user->createToken($this->appName)->plainTextToken;
        $success[User::TOKEN_ATTRIBUTE] = $token;
        $success[User::ID_ATTRIBUTE] = $user->{User::ID_ATTRIBUTE};

        return $this->sendResponse($success, 'User login successfully.');
    }

    /**
     * @param array $input
     * @return JsonResponse
     */
    final public function createUsers(array $input): JsonResponse
    {
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken($this->appName)->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }
}
