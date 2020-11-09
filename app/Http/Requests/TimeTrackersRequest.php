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
            'user_id' => 'required|numeric',
            'id_project' => 'required|numeric',
            'working_date' => 'required',
            'start_working_day' => [
                'required'
            ],
            'end_working_day' => [
                'required',
                new FromToDateCheck($request)
            ],
            'start_working_time' => 'required',
            'end_working_time' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'working_date.required' => 'working_date is required!',
        ];
    }
    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 200);
        }
    }
}
