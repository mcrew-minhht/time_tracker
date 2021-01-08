<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordReuest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->users = new User();
    }
    public function index(Request $request){
        $id = Auth::id();
        $user = $this->users->find($id);
        return view('profile_user.index', compact('user', $user));
    }

    public function update(ProfileRequest $request) {
        try {
            $params = $this->getParams($request);
            $id = Auth::id();
            $result  = $this->users->updateUser($params, $id);
            $response = [
                'message' => __('Update successfully')
            ];
            return redirect('profile')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function confirmPassword(PasswordReuest $request) {
        try {
            $id = Auth::id();
            $user = $this->users->find($id);
            if (Hash::check($request->current_password, $user->password)) {
                $params = $this->getPasswordParam($request);
                $result  = $this->users->updateUser($params, $id);
                $response = [
                    'message' => __('Update successfully')
                ];
                return redirect('profile')->with(['message' => $response['message'], 'alert-class' => 'alert-success']);
            } else {
                $errors['current_password']='The current password does not match';
                return redirect()->back()->withErrors($errors)->withInput();
            }
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function getParams(Request $request){

        $params = [
            'name' => $request->name ?? null,
            'email' => $request->email ?? null,
            'address' => $request->address ?? null,
            'birthdate' => !empty(convert_dmy_to_ymd($request->birthdate)) ? convert_dmy_to_ymd($request->birthdate) :  null,
        ];
        return $params;
    }

    public function getPasswordParam(Request $request){
        $params = [
            'password' => Hash::make($request->password)
        ];
        return $params;
    }
}
