<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CaptchaController extends Controller
{
    public function getCaptcha(): Application|Response|ResponseFactory
    {
        $builder = new CaptchaBuilder;
        $builder->build();

        session(['captcha_phrase' => $builder->getPhrase()]);

        return response($builder->output())->header('Content-type', 'image/jpeg');
    }

    public function reloadCaptcha(): JsonResponse
    {
        $builder = new CaptchaBuilder;
        $builder->build();

        session(['captcha_phrase' => $builder->getPhrase()]);
        return response()->json(['captcha_url' => url('/captcha') . '?' . time()]);
    }
}
