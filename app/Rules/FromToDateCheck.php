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
            if(!empty($value) || $value != null){
                $start_working_day_arr = explode('/',$request['start_working_day']);
                $start_working_day_str = $start_working_day_arr[2].'/'.$start_working_day_arr[1].'/'.$start_working_day_arr[0];
                $end_working_day_arr = explode('/',$request['end_working_day']);
                $end_working_day_str = $end_working_day_arr[2].'/'.$end_working_day_arr[1].'/'.$end_working_day_arr[0];

                if(!empty($request['start_working_time'])){
                    $begin = Carbon::parse($start_working_day_str.' '. $request['start_working_time']);
                    $end = Carbon::parse($end_working_day_str.' '. $request['end_working_time']);
                }else{
                    $begin = Carbon::parse($start_working_day_str);
                    $end = Carbon::parse($end_working_day_str);
                }

                if($begin->lte($end) == false){
                    return false;
                }
                return true;
            }
            return true;
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
