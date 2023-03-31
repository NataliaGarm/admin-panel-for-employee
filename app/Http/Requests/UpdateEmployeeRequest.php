<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateEmployeeRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:256',
            'img' => 'nullable|image|mimes:jpg,png,jpeg|max:5120|dimensions:min_width=300,min_height=300',
            'position' => 'required',
            'employment_date' => 'required|date',
            'email' => 'required|email|unique:users,email,'.$this->employee->id,
            'phone' => 'required|phone:INTERNATIONAL,UA,mobile',
            'salary' => 'required|numeric|between:0,500',
        ];
    }
}
