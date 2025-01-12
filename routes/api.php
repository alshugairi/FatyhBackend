<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\{Routes\Api\AuthenticationRoutes,
    Routes\Api\GeneralRoutes};


AuthenticationRoutes::registerRoutes();
GeneralRoutes::registerRoutes();
