<?php

namespace App\Http\Requests;

use App\Models\Sms;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSmsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sms_edit');
    }

    public function rules()
    {
        return [
            'message' => [
                'string',
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
