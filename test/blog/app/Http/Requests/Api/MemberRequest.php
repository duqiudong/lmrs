<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize () {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules () {
        return [
            'name'              => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/',
            'password'          => 'required|alpha_dash|min:6',
            'verification_key'  => 'required|string',
            'verification_code' => 'required|string',
        ];
    }

    public function attributes () {
        return [
            'verification_key'  => '短信验证码 key',
            'verification_code' => '短信验证码',
        ];
    }
}
