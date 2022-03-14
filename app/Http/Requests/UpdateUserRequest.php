<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name'=> [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'password' => Password::min(8)->rules('confirmed'),
            'avatar' => [
                'nullable',
                Rule::exists('files', 'uuid')
            ],
            'address' => [
                'required',
                'string',
                'max:255'
            ],
            'phone_number' => 'phone:AUTO,US',
            'is_marketing' => [
                'required',
                'boolean'
            ],
        ];
    }
}
