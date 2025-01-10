<?php

namespace App\Services\Settings;

use App\Repositories\Settings\MenuItemRepository;
use App\Services\BaseService;

class MenuItemService extends BaseService
{
    public function __construct(MenuItemRepository $repository)
    {
        parent::__construct($repository);
    }
}
