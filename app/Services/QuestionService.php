<?php

namespace App\Services;

use App\Repositories\QuestionRepository;
use Illuminate\Support\Facades\DB;

class QuestionService extends BaseService
{
    public function __construct(QuestionRepository $repository)
    {
        parent::__construct($repository);
    }
}
