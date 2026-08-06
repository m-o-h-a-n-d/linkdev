<?php

namespace App\DTOs\User;

use Illuminate\Http\Request;

readonly class CreateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $email_verified_at = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            email_verified_at: $request->validated('email_verified_at'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            email_verified_at: $data['email_verified_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'email_verified_at' => $this->email_verified_at,
        ], fn ($value) => $value !== null);
    }
}
