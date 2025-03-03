<?php

namespace App\Services;

use App\Repositories\BusinessRepository;

class BusinessService extends BaseService
{
    public function __construct(BusinessRepository $repository)
    {
        parent::__construct($repository);
    }
}
