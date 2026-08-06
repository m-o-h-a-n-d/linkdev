<?php

namespace App\DTOs\User;

final readonly class UpdateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $phone = null,
        public ?string $image = null,
        public ?string $status = null,
        public ?string $emailVerifiedAt = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            phone: $data['phone'] ?? null,
            image: $data['image'] ?? null,
            status: $data['status'] ?? null,
            emailVerifiedAt: $data['email_verified_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'image' => $this->image,
            'status' => $this->status,
            'email_verified_at' => $this->emailVerifiedAt,
        ], static fn ($value) => $value !== null);
    }
}