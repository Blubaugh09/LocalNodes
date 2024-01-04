<?php

namespace App\Http\Requests;

use App\Models\Contacted;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreContactedRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contacted_create');
    }

    public function rules()
    {
        return [];
    }
}
