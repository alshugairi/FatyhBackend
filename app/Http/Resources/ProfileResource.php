<?php

namespace App\Http\Resources;

use App\Http\Resources\Catalog\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): ?array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'email' => $this->email,
            'phone' => $this->phone,
            'verified' => $this->verified,
            'avatar' => !is_null($this->avatar) ? get_full_image_url($this->avatar) : null,
        ];
    }
}
