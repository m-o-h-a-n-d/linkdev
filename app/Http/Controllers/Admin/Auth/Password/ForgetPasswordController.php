<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('backend.auth.forgot-password');
    
    }

    public function sendOtp(ForgetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !$user->admin()->exists()){
            return redirect()->back()->with('error', 'User not found');
        }

        

        
        
    }
}
