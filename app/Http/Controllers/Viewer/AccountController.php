<?php

namespace App\Http\Controllers\Viewer;

use App\Data\User\UpdateUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateAccountRequest;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function index(): View
    {
        $user = Auth::user();

        return view('frontend.account.account', compact('user'));
    }

    public function update(UpdateAccountRequest $request)
    {
        $dto = UpdateUserData::from($request);

        $this->userService->update(Auth::id(), $dto);

        return redirect()
            ->route('account.index')
            ->with('success', 'Updated Successfully');
    }
}
