<?php

namespace App\Http\Requests;

use App\Models\MemberCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMemberCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('member_category_create');
    }

    public function rules()
    {
        return [
            'members.*' => [
                'integer',
            ],
            'members' => [
                'array',
            ],
        ];
    }
}
