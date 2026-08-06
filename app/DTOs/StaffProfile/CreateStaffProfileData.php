<?php

namespace App\DTOs\StaffProfile;

use Illuminate\Http\Request;

readonly class CreateStaffProfileData
{
    public function __construct(
        public int $user_id,
        public string $phone,
        public string $image,
        public string $status,
        public int $national_id,
        public string $address,
        public string $gender,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            user_id: (int) $request->validated('user_id'),
            phone: $request->validated('phone'),
            image: $request->validated('image'),
            status: $request->validated('status', 'active'),
            national_id: (int) $request->validated('national_id'),
            address: $request->validated('address'),
            gender: $request->validated('gender'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: (int) $data['user_id'],
            phone: $data['phone'],
            image: $data['image'],
            status: $data['status'] ?? 'active',
            national_id: (int) $data['national_id'],
            address: $data['address'],
            gender: $data['gender'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'image' => $this->image,
            'status' => $this->status,
            'national_id' => $this->national_id,
            'address' => $this->address,
            'gender' => $this->gender,
        ];
    }
}
