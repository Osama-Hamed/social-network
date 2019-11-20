<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('update', $this->user);
    }

    public function rules()
    {
        return [
            'bio' => 'sometimes|nullable|string|max:101',
            'avatar' => 'sometimes|required|base64image:jpg,jpeg,png'
        ];
    }

    public function save()
    {
        $data = $this->avatar ? ['avatar' => $this->uploadAvatar()] : ['bio' => $this->bio];

        return tap($this->user, function ($user) use ($data) {
            $user->removeAvatar();

            $user->update($data);
        });
    }

    public function uploadAvatar($value='')
    {
        $extension = explode('/', explode(':', substr($this->avatar, 0, strpos($this->avatar, ';')))[1])[1];
        $avatarName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $extension;

        Storage::disk('public')
            ->put("avatars/$avatarName", Image::make($this->avatar)
            ->encode($extension));

        return $avatarName;
    }
}
