<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Auth::id();
        $validate =  [
            'name' => 'required|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'birthdate' => 'nullable|date_format:d/m/Y|max:10'
        ];
        return $validate;
    }
}
