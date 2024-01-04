<?php

namespace App\Http\Requests;

use App\Models\RelatedTo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRelatedToRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('related_to_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:related_tos,id',
        ];
    }
}
