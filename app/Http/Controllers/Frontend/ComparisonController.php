<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Comparison;
use App\{Http\Controllers\Controller};


class ComparisonController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $sessionId = $request->session()->get('session_id');
        $userId = auth()->id();

        $exists = Comparison::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->where('product_id', $productId)->exists();

        if (!$exists) {
            Comparison::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $productId,
            ]);
        }

        flash(__('frontend.product_added_to_comparison'))->success();
        return back();
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $sessionId = $request->session()->get('session_id');
        $userId = auth()->id();

        Comparison::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->where('product_id', $productId)->delete();

        flash(__('frontend.product_removed_from_comparison'))->success();
        return back();
    }

    public function index(Request $request)
    {
        $sessionId = $request->session()->get('session_id');
        $userId = auth()->id();

        $products = Comparison::with('product')
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();

        return view('frontend.modules.comparison', compact('products'));
    }
}
