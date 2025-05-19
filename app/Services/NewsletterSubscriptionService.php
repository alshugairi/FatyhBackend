<?php

namespace App\Services;

use App\Repositories\NewsletterSubscriptionRepository;

class NewsletterSubscriptionService extends BaseService
{
    public function __construct(NewsletterSubscriptionRepository $repository)
    {
        parent::__construct($repository);
    }
}
