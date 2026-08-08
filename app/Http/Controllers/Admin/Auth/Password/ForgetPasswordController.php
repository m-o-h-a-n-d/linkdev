<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Data\User\Auth\ForgotPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;

class ForgetPasswordController extends Controller
{


    public function showForgetPasswordForm()
    {
        return view('backend.auth.forgot-password');

    }

    public function sendOtp(ForgotPasswordRequest $request)
    {
        $request->validated();

        $dto = ForgotPasswordData::from($request);

        









    }
}
