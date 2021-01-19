<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FromToDateCheck;
use Illuminate\Http\Request;

class ExportTimeTrackerRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'user_id' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'id_project' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'id_project.required' => 'Project is required',
        ];
    }
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 200);
        }
    }
}
