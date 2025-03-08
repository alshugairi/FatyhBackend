<?php

namespace App\Http\Controllers\Api\Checkout;

use App\{Http\Controllers\Controller,
    Http\Resources\BusinessResource,
    Http\Resources\Catalog\ReviewResource,
    Pipelines\ReviewFilterPipeline,
    Services\BusinessService,
    Services\ReviewService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};

class CartController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return response()->json([
            "data" => [
                "items" => [
                    [
                        "sellerName" => "Fatyh",
                        "products" => [
                            [
                                "id" => "1",
                                "name" => "Fatyh Collection Polo Neck Brown",
                                "image" => "/images/t1.png",
                                "delivery" => "Delivery 30 Nov - 5 Dec",
                                "size" => "XL",
                                "discount" => "50%",
                                "price" => "25.99 IQD",
                                "originalPrice" => "30.99 IQD",
                                "quantity" => 1
                            ],
                            [
                                "id" => "2",
                                "name" => "Fatyh Collection T-Shirt Black",
                                "image" => "/images/t2.png",
                                "delivery" => "Delivery 1 Dec - 6 Dec",
                                "size" => "L",
                                "discount" => "30%",
                                "price" => "20.99 IQD",
                                "originalPrice" => "29.99 IQD",
                                "quantity" => 2
                            ]
                        ]
                    ],
                    [
                        "sellerName" => "TrendyWear",
                        "products" => [
                            [
                                "id" => "3",
                                "name" => "TrendyWear Hoodie Gray",
                                "image" => "/images/t3.png",
                                "delivery" => "Delivery 2 Dec - 7 Dec",
                                "size" => "M",
                                "discount" => "40%",
                                "price" => "35.99 IQD",
                                "originalPrice" => "59.99 IQD",
                                "quantity" => 1
                            ]
                        ]
                    ]
                ],
                "subtotal" => "103.96 IQD",
                "shipping" => "10.00 IQD",
                "discount" => "15.00 IQD",
                "promotionTotal" => "15.00 IQD",
                "promotions" => [
                    [
                        "description" => "30% Discount on Polo Neck",
                        "image" => "/images/t1.png",
                        "amount" => "9.00 IQD"
                    ],
                    [
                        "description" => "10% Off First Order",
                        "image" => "/images/t2.png",
                        "amount" => "6.00 IQD"
                    ]
                ],
                "total" => "98.96 IQD"
            ],
            "loading" => false,
            "error" => null
        ]);
    }
}
