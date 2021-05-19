<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'test';
        $user->mobile = '13'. rand(100000000,999999999);
        $user->password = Hash::make('123456');
        $user->save();

        $userInfo = new UserInfo();
        $userInfo->name = 'test';
        $userInfo->user_id = $user->getKey();
        $userInfo->save();
    }
}
