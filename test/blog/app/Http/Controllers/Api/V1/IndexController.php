<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class IndexController extends Controller {
    /**
     * 日销量排行榜
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function SoldCountQueue (Request $request) {
        try {
            $soldCountProductId = app('redis.connection')->zrevrange("lmrs::home::index::queue", 0, -1);
            $soldCountProduct = [];
            if (empty($soldCountProductId)) {
                $soldCountProduct = Product::query()->orderByDesc('sold_count')->limit(5)->get(['id', 'name', 'sold_count']);
                app("redis.connection")->pipeline(function ($redis) use ($soldCountProduct) {
                    $redis->del("lmrs::home::index::queue");
                    foreach ($soldCountProduct as $item) {
                        $redis->zadd("lmrs::home::index::queue", $item["sold_count"], $item["id"]);
                        $redis->set("lmrs::home::product::id::".$item["id"], serialize($item));
                    }
                });
            } else {
                foreach ($soldCountProductId as $item => $value) {
                    $soldCountProduct [$item] = unserialize(app("redis.connection")->get("lmrs::home::product::id::".$value));
                }
            }
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return response()->json([
            "data"    => $soldCountProduct,
            "restful" => true,
        ]);
    }

}
