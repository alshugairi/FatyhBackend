<?php

namespace App\Enums;

enum UserType:int
{
    case ADMIN = 1;
    case VENDOR = 2;
    case CLIENT = 3;
}
