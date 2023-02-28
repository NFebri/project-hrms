<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'employee_code' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                    'password' => 'required',
                    'gender' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'role' => 'required',
                    'address' => 'required',
                    'join_date' => 'required',
                    'salary' => 'required|numeric',
                ];
                break;
            default:
                return [
                    'employee_code' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                    'gender' => 'required',
                    'department_id' => 'required',
                    'designation_id' => 'required',
                    'role' => 'required',
                    'address' => 'required',
                    'join_date' => 'required',
                    'salary' => 'required|numeric',
                ];
                break;
        }
    }
}
