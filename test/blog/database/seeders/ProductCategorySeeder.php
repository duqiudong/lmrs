<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
        $data = [
            [
                'name'         => '女装',
                'is_directory' => 1,
                'level'        => 1,
            ],
            [
                'name'         => '男装',
                'is_directory' => 1,
                'level'        => 1,
            ],
            [
                'name'      => '短袖裙子',
                'parent_id' => 1,
                'level'     => 2,
                'path'      => 1,
            ],
            [
                'name'      => '长袖裙子',
                'parent_id' => 1,
                'level'     => 2,
                'path'      => 1,
            ],
            [
                'name'      => '连帽短袖',
                'parent_id' => 2,
                'level'     => 2,
                'path'      => 2,
            ],
            [
                'name'      => 'V领短袖',
                'parent_id' => 2,
                'level'     => 2,
                'path'      => 2,
            ],
            [
                'name'      => 'T恤衫',
                'parent_id' => 2,
                'level'     => 2,
                'path'      => 2,
            ],
            [
                'name'         => '电脑',
                'is_directory' => 1,
                'level'        => 1,
            ],
            [
                'name'         => '华为电脑',
                'parent_id'    => 8,
                'is_directory' => 1,
                'level'        => 2,
                'path'         => 8,
            ],
            [
                'name'         => '苹果电脑',
                'parent_id'    => 8,
                'is_directory' => 1,
                'level'        => 2,
                'path'         => 8,
            ],
        ];


        foreach ($data as $v) {
            $productCategory = new ProductCategory();
            $productCategory->fill($v);
            $productCategory->save();
        }
    }
}
