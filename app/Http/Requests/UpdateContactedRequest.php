<?php

namespace App\Http\Requests;

use App\Models\Contacted;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContactedRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contacted_edit');
    }

    public function rules()
    {
        return [];
    }
}
