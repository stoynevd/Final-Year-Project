<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use Validator;
use App\Models\User;
use App\Mail\ResetPasswordEmail;

class ActionController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'         =>  'bail|required|email|unique:users|max:191',
            'password'      =>  'bail|required|min:6|max:32|confirmed',
            'name'          =>  'bail|required|unique:users|max:191',
            'grecaptcha'    =>  'bail|required|captcha'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $user = User::create([
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
            'name'      => $request->input('name')
        ]);
        Auth::loginUsingId($user->id);
        return response()->json(['success' => true]);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'         => 'bail|required|email',
            'password'      => 'bail|required|min:6|max:32',
            'grecaptcha'    => 'bail|required|captcha'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $userDetails = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password')
        ];
        if(Auth::attempt($userDetails)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Wrong username or password.']);
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'         => 'bail|required|email',
            'grecaptcha'    => 'bail|required|captcha'
        ]);
        if($validator->fails()) {
            return $this->returnCustomJsonValidatorError($validator);
        }
        $user = User::where('email', $request->input('email'))->first();
        if(!is_null($user)) {
            $user->update([
                'password' => bcrypt($newPassword = str_random(8))
            ]);
            Mail::to($user->email)->send(new ResetPasswordEmail(['newPassword' => $newPassword]));
        }
        return response()->json(['success' => true, 'message' => 'Please check your email for the new password']);
    }
}
