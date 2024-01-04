<?php

namespace App\Http\Requests;

use App\Models\MemberCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMemberCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('member_category_edit');
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
