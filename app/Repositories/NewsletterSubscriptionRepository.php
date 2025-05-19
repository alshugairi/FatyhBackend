<?php

namespace App\Repositories;

use App\{Models\NewsletterSubscription};

class NewsletterSubscriptionRepository extends BaseRepository
{
    public function __construct(NewsletterSubscription $model)
    {
        parent::__construct($model);
    }
}
