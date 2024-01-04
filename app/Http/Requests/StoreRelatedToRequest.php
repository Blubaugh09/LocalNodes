<?php

namespace App\Http\Requests;

use App\Models\RelatedTo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRelatedToRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('related_to_create');
    }

    public function rules()
    {
        return [
            'related_tos.*' => [
                'integer',
            ],
            'related_tos' => [
                'array',
            ],
        ];
    }
}
