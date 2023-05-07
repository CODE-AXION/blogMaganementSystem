<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\UserService;
use Illuminate\Validation\Rules;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(),
            [
                'email' => ['required','email'],
                'password' => ['required']
            ]);

            if($validateUser->fails()){

                return response()->error($validateUser->errors());
            }

            if(!Auth::attempt($request->only(['email', 'password']))){

                return response()->error('Email & Password does not match with our record.');
            }

            $user = User::where('email', $request->email)->first();


            return response()->success([
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken($user->id)->plainTextToken
            ]);

        } catch (\Throwable $th) {

          
            return response()->ExceptionError(['Some Error Occured'],500);
        }
    
    }

}
