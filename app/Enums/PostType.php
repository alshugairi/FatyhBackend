<?php

namespace App\Enums;

enum PostType:string
{
    case POST = 'post';
    case PAGE = 'page';
    case SECTION = 'section';
    case FEATURE = 'feature';
    case FAQ = 'faq';
    case GALLERY = 'gallery';
    case SLIDER = 'slider';
    case TESTIMONIAL = 'testimonial';
}
