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
            'username' => 'required|string|max:255|alpha_dash|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:32|confirmed',
            'birthday' => 'required|string|date_format:d/m/Y',
            'gender' => 'required|in:male,female'
        ];
    }

    public function save()
    {
        $data = $this->validated();

        $user = User::create([
            'first_name' => $data['first_name'],    
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $user->profile()->create([
            'birthday' => Carbon::createFromFormat('d/m/Y', $data['birthday']),
            'gender' => $data['gender'],
            'avatar' => 'default.png',
            'country' => geoip()->getLocation($this->ip())['country'],
            'city' => geoip()->getLocation($this->ip())['city']
        ]);

        return $user->load('profile');
    }
}
