<?php

namespace App\Services;

use App\Repositories\AddressRepository;

class AddressService extends BaseService
{
    public function __construct(AddressRepository $repository)
    {
        parent::__construct($repository);
    }
}
