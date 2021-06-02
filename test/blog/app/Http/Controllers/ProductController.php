<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $builder = Product::query()->where('status',true);
        $category = ProductCategory::query()->whereIn('id',explode(',',$request->input("category_id")))->get();
        // 则筛选出该父类目下所有子类目的商品
        $builder->whereHas('category', function ($query) use ($category) {
            foreach ($category as $value => $item){
                if ($value == 0){
                    $query->where('path', 'like', $item->path.$item->id.'-%');
                }else{
                    $query->orwhere('path', 'like', $item->path.$item->id.'-%');
                }
            }
        });

        if ($order = $request->input('order','')){
            if (preg_match('/^(.+)_(asc|desc)$/',$order,$m)){
                // 如果字符串的开头是这 3 个字符串之一，说明是一个合法的排序值
                if (in_array($m[1], ['price', 'sold_count', 'review_count'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $products = $builder->paginate(10);

        return response()->json([
            "data" => $products,
            "restful" => true
        ]);
    }
}
