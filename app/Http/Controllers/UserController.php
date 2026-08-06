<?php

namespace App\Http\Controllers;

use App\DTOs\User\CreateUserData;
use App\DTOs\User\UpdateUserData;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Utilities\ImageManager;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected ImageManager $imageManager
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->userService->paginate(),
        ]);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['image'] = $this->imageManager->upload($request->file('image') , 'users', 'public');
        $user = $this->userService->store(CreateUserData::fromArray($validated));

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user,
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'data' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        $validated['image'] = $this->imageManager->upload($request->file('image'), 'users', 'public', $user->image);

        $updatedUser = $this->userService->update($user->id, UpdateUserData::fromArray($validated));

        return response()->json([
            'message' => 'User updated successfully.',
            'data' => $updatedUser,
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->destroy($user->id);

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }
}