<?php

namespace App\Enums;

enum UserType:int
{
    case ADMIN = 1;
    case BUSINESS_OWNER = 2;
    case CLIENT = 3;
}
