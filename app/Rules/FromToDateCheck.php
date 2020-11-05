<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class FromToDateCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected  $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {

        $request = $this->request->all();
        if($attribute == 'end_working_day'){
            if(!empty($value) && !empty($request['end_working_time'])){
               $begin = Carbon::parse($request['start_working_day'].' '. $request['start_working_time']);
               $end = Carbon::parse($request['end_working_day'].' '. $request['end_working_time']);
               if($begin->lte($end) == false){
                    return false;
                }
               return true;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The end date must not be greater than the start date';
    }
}
