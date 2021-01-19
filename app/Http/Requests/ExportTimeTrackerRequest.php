<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
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
        $current_year          = Carbon::now()->year;
        $hundred_years_ago     = (new Carbon("100 years ago"))->year;
        return [
            'user_id' => 'required|numeric',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|between:'.$hundred_years_ago.','.$current_year,
        ];
    }

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return new JsonResponse($errors, 200);
        }
    }
}
