<?php

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UserAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            // 每个用户随机生成 1-3 个收货地址
            factory(UserAddress::class, random_int(1, 3))->create(['user_id' => $user->id]);
        });
    }
}
