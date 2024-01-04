<?php

namespace App\Http\Requests;

use App\Models\Email;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_create');
    }

    public function rules()
    {
        return [
            'body' => [
                'required',
            ],
            'date_to_send' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_to_send' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'send_to_roles.*' => [
                'integer',
            ],
            'send_to_roles' => [
                'array',
            ],
        ];
    }
}
