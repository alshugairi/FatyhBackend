<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'verified' => (bool)$this->email_verified_at,
            'notify_email' => $this->notify_email,
            'notify_sms' => $this->notify_sms,
            'notify_whatsapp' => $this->notify_whatsapp,
            'created_at' => $this->created_at,
            'avatar' => !is_null($this->avatar) ? get_full_image_url($this->avatar) : null,
            //'fcm_token' => $this->fcm_token,
        ];
    }
}
