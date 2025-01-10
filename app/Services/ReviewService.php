<?php

namespace App\Services;

use App\Repositories\ReviewRepository;
use Illuminate\Support\Facades\DB;

class ReviewService extends BaseService
{
    public function __construct(ReviewRepository $repository)
    {
        parent::__construct($repository);
    }

    public function ratingBreakdown(int $productId): array
    {
        $productReviews = DB::table('reviews')
            ->select('rating', DB::raw('count(*) as total'))
            ->where('product_id', $productId)
            ->groupBy('rating')
            ->get();

        $ratingBreakdown = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($productReviews as $review) {
            $ratingBreakdown[$review->rating] = $review->total;
        }
        return $ratingBreakdown;
    }
}
