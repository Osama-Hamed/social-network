<?php

namespace App\Http\Requests;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'password' => 'required|string|min:8|max:32|confirmed',
            'birthday' => 'required|string|date_format:d/m/Y',
            'gender' => 'required|in:male,female'
        ];
    }

    public function save()
    {
        $data = $this->validated();

        $data['password'] = Hash::make($data['password']);
        $data['birthday'] = Carbon::createFromFormat('d/m/Y', $data['birthday']);

        return User::create($data);
    }
}
