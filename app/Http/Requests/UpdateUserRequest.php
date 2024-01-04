<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'mobile' => [
                'string',
                'min:10',
                'max:10',
                'nullable',
            ],
            'phone' => [
                'string',
                'min:10',
                'max:10',
                'nullable',
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'gender' => [
                'string',
                'nullable',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'birthday' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
