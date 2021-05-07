<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
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
        $id = $this->request->all()['id'];
        $password = $this->request->all()['password'];
        $password_confirmation = $this->request->all()['password_confirmation'];
        $validate =  [
            'name' => 'required|max:191',
            'email' => ['required', 'email', 'max:191', Rule::unique('users')->ignore($id)],
            //'employee_code' => 'required|unique:users,employee_code,'.$id.'|max:191',
            'birthdate' => 'nullable|date_format:d/m/Y|max:10'
        ];
        if (empty($id) || (!empty($password) || !empty($password_confirmation))){
            $validate['password']='required|min:8|max:191';
            $validate['password_confirmation']='required|min:8|max:191|same:password';
        }

        return $validate;
    }
}
