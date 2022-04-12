<?php

namespace App\Http\Requests;

use App\Models\CrmNote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCrmNoteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crm_note_edit');
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'integer',
                'exists:crm_customers,id',
                'required',
            ],
            'note' => [
                'string',
                'required',
            ],
        ];
    }
}
