<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'csv' => 'required|file|mimes:csv,txt'
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'csv.mimes' => 'The :attribute file must be of type csv.'
        ];
    }
}
