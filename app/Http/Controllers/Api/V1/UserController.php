<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = User::all();
        return $this->sendResponse(['users' => UserResource::collection($users)], 'Successfully logged in.');
    }


    /**
     * API for login
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'device_name' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed.',  $validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid Credentials', [], 422);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;


        return $this->sendResponse(['token' => $token, 'user' => new UserResource($user)], 'Successfully logged in.');
    }


    /**
     * API for user signup
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed.',  $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return $this->sendResponse(['token' => $token, 'user' => new UserResource($user)], 'Successfully registered.');

    }


    /**
     * API for logout
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request){

        $loggedOut = $request->user()->currentAccessToken()->delete();

        if($loggedOut){
            return $this->sendSuccess('Successfully logged out.');
        }
        else{
            return $this->sendError('Something went wrong.');
        }
    }



    /**
     * Get logged in user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        return $this->sendResponse(new UserResource($request->user()), 'User Profile');
    }


}
