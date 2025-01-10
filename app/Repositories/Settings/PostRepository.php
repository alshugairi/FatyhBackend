<?php

namespace App\Repositories\Settings;

use App\{Models\Post, Repositories\BaseRepository};

class PostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
}
