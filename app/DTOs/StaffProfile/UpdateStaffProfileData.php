<?php

namespace App\DTOs\StaffProfile;

use Illuminate\Http\Request;

readonly class UpdateStaffProfileData
{
    public function __construct(
        public ?string $phone = null,
        public ?string $image = null,
        public ?string $status = null,
        public ?int $national_id = null,
        public ?string $address = null,
        public ?string $gender = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            phone: $request->validated('phone'),
            image: $request->validated('image'),
            status: $request->validated('status'),
            national_id: $request->validated('national_id') ? (int) $request->validated('national_id') : null,
            address: $request->validated('address'),
            gender: $request->validated('gender'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            phone: $data['phone'] ?? null,
            image: $data['image'] ?? null,
            status: $data['status'] ?? null,
            national_id: isset($data['national_id']) ? (int) $data['national_id'] : null,
            address: $data['address'] ?? null,
            gender: $data['gender'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'phone' => $this->phone,
            'image' => $this->image,
            'status' => $this->status,
            'national_id' => $this->national_id,
            'address' => $this->address,
            'gender' => $this->gender,
        ], fn ($value) => $value !== null);
    }
}
