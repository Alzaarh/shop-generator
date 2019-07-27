<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\SignupRequest;
use App\Util\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Jobs\RemoveUserFromMemory;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class AuthController extends Controller
{
    use Response;

    public function signup(Request $request)
    {
        $input = $this->validateSignup($request);

        switch($request->authType)
        {
            case 'email_based':

                if(Redis::exists('tempUser:' . $input['email']) &&
                    Redis::hget('tempUser:' . $input['email'], 'verificationSentCount') > 10)
                {
                    return $this->tooManyRequestsResponse();
                }

                event(new SignupRequest($input));

                return $this->okResponse();

                break;

            case 'username_based':
                
                $userData = $this->transformToDatabaseInput($input);

                $user = $this->createUser($userData);

                $jwtToken = $this->createJwt($user);

                return (new UserResource($user, $jwtToken))->response(201);
        }
        
    }

    /** verify user account */
    public function verify(Request $request)
    {
        $this->validateVerify($request);

        $userData = $this->transformToDatabaseInput(Redis::hgetall('tempUser:' . $request->input('email')));

        $this->dispatch(new RemoveUserFromMemory($userData['email']));

        $user = $this->createUser($userData);

        $jwtToken = $this->createJwt($user);

        return (new UserResource($user, $jwtToken))->response(201);
    }

    /** login */
    public function signin(Request $request)
    {
        $input = $this->validateSignin($request);

        $user = $this->findUser($input['email']);

        if(!$user)
        {
            return $this->modelNotFoundResponse();
        }

        if(!Hash::check($input['password'], $user->password))
        {
            return $this->badRequestResponse();
        }

        $jwtToken = $this->createJwt($user);

        return (new UserResource($user, $jwtToken))->response(200);
    }

    private function validateSignup(Request $request)
    {
        switch($request->authType)
        {
            case 'email_based':

                $rules = [
                    'firstName' => 'bail|string|nullable|max:255',

                    'lastName' => 'bail|string|nullable|max:255',

                    'name' => 'bail|string|nullable|max:255',
                    
                    'username' => 'bail|string|nullable|max:255|unique:users,username',

                    'email' => 'bail|required|email|unique:users,email',

                    'password' => 'bail|required|string|min:5|max:20|confirmed',

                    'phone' => 'bail|string|nullable|numeric|max:15',
                ];
                
                return $this->validate($request, $rules);

                break;
            
            case 'username_based':
                
                $rules = [
                    'firstName' => 'bail|string|nullable|max:255',

                    'lastName' => 'bail|string|nullable|max:255',

                    'name' => 'bail|string|nullable|max:255',

                    'username' => 'bail|required|string|max:255, unique:users,username',

                    'email' => 'bail|email|unique:users,email',

                    'password' => 'bail|required|string|min:5|max:20|confirmed',

                    'phone' => 'bail|string|nullable|numeric|max:15',
                ];

                return $this->validate($request, $rules);

                break;
        }

    }

    private function validateVerify(Request $request)
    {
        $rules = [
            'email' => 'bail|required|email',
            'verificationCode' => ['bail', 'required',
            function ($attr, $value, $fail)
            {
                if(!Redis::exists('tempUser:' . Input::get('email')))
                {
                    $fail($attr . ' is invalid');
                }
                if(!Hash::check($value, Redis::hget(
                    'tempUser:' . Input::get('email'), 'verificationCode')))
                {
                    $fail($attr . ' is invalid');
                }
            }
            ],
        ];

        $this->validate($request, $rules);
    }

    private function transformToDatabaseInput($data)
    {
        return [
            'first_name' => isset($data['firstName']) ? $data['firstName'] : null,

            'last_name' => isset($data['lastName']) ? $data['lastName'] : null,

            'name' => isset($data['name']) ? $data['name'] : null,

            'username' => isset($data['username']) ? $data['username'] : null,

            'email' => isset($data['email']) ? $data['email'] : null,

            'password' => isset($data['password']) ? $data['password'] : null ,

            'phone' => isset($data['phone']) ? $data['phone'] : null,
        ];
    }

    private function createUser($userData)
    {
        return User::create($userData);
    }

    private function findUser($email)
    {
        return User::where('email', $email)->first();
    }

    private function createJwt($user)
    {
        $key = env('JWT_KEY');

        $token = [
            'id' => $user->id,
            'email' => $user->email,
            'createdAt' => Carbon::now(),
            'expireAt' => Carbon::now()->addDay(),
        ];

        return JWT::encode($token, $key);
    }

    private function validateSignin(Request $request)
    {
        $rules = [
            'email' => 'bail|required|email',
            
            'password' => 'bail|string|min:5|max:20',
        ];

        return $this->validate($request, $rules);
    }
}
