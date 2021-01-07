<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FromToDateCheck;
use Illuminate\Http\Request;

class TimeTrackersRequest extends FormRequest
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
            'user_id' => !empty($request->id) ? 'numeric' : 'required|numeric',
            'id_project' => !empty($request->id) ? 'numeric' : 'required|numeric',
            'start_working_day' => [
                empty($request->id) ? 'required' : ''
            ],
            'end_working_day' => [
                new FromToDateCheck($request)
            ],
            'working_time' => 'numeric|nullable',
        ];
    }
    public function messages()
    {
        return [
            'start_working_day.required' => 'Start working date is required!',
        ];
    }
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 200);
        }
    }
}
