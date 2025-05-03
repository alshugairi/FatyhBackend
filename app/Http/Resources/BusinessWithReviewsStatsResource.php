<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessWithReviewsStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reviewCounts = $this->getReviewCountsByStar();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'rating' => $this->rating,
            'logo' => asset('public/assets/admin/images/amazon.png'),
            'cover' => asset('public/assets/admin/images/cover.jpg'),
            'followers_count' => $this->followers_count,
            'reviews_count' => $this->reviews_count,
            'success_orders_count' => $this->success_orders_count,
            'cancelled_orders_count' => $this->cancelled_orders_count,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'tiktok_url' => $this->tiktok_url,
            'review_counts' => [
                'star_1' => $reviewCounts[1] ?? 0,
                'star_2' => $reviewCounts[2] ?? 0,
                'star_3' => $reviewCounts[3] ?? 0,
                'star_4' => $reviewCounts[4] ?? 0,
                'star_5' => $reviewCounts[5] ?? 0,
            ],
        ];
    }

    protected function getReviewCountsByStar(): array
    {
        return $this->reviews
            ->groupBy('rating')
            ->mapWithKeys(function ($reviews, $rating) {
                return [$rating => count($reviews)];
            })->toArray();
    }
}
