<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToModel,WithHeadingRow,  WithValidation
{
    use HasFactory, SkipsErrors;

    public function model(array $row)
    {
        $birthdate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['birthdate'])->format('Y/m/d');
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'employee_code' => $row['employee_code'],
            'address' => $row['address'],
            'password' => Hash::make($row['password']),
            'birthdate' => $birthdate,
            'region' => $row['region'],
            'part_time' => $row['part_time'],
            'level' => $row['level'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:191',
            'email' => ['required', 'email', 'max:191', Rule::unique('users')],
            'employee_code' => ['required', 'max:191', 'unique:users'],
            'birthdate' => ['nullable'],
            'password'=>'required|min:8|max:191',
            'region'=>'required|integer|min:1|max:3',
            'part_time'=>'required|integer|min:0|max:1',
            'level'=>'required|integer|min:0|max:1'
        ];
    }
}
