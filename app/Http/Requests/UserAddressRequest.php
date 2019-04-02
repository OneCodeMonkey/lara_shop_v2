<?php

namespace App\Http\Requests;

class UserAddressRequest extends Request
{
    public function rules()
    {
        return [
            'province' => 'requried',
            'city' => 'requried',
            'district' => 'requried',
            'address' => 'requried',
            'zip' => 'requried',
            'contact_name' => 'requried',
            'contact_phone' => 'requried',
        ];
    }

    public function attributes()
    {
        return [
            'province' => '省',
            'city' => '城市',
            'district' => '地区',
            'address' => '详细地址',
            'zip' => '邮编',
            'contact_name' => '姓名',
            'contact_phone' => '电话',
        ];
    }
}
