<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class Profile extends Component
{
    use WireUiActions, WithFileUploads;

    public $password = [], $avatar;

    protected function validationAttributes()
    {
        return [
            'password.new' => __('New password'),
            'password.new_confirmation' => __('Confirm password'),
        ];
    }

    public function changePassword()
    {
        $this->validate([
            'password.new' => 'required|min:8|confirmed',
            'password.new_confirmation' => 'required',
        ]);

        auth()->user()->update([
            'password' => $this->password['new'],
        ]);

        $this->reset('password');
        $this->dialog()->success(__('Sucesss'), __('Password changed correctly'));
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'required|image|max:1024',
        ]);

        $file_name = 'avatars/' . auth()->id() . '.' . $this->avatar->guessExtension();
        $new_file = Intervention::make($this->avatar->temporaryUrl());
        $new_file->fit(400, 400);

        Storage::put($file_name, (string) $new_file->encode());

        auth()->user()->update([
            'photo' => $file_name,
        ]);

        $this->reset('avatar');
        $this->dialog()->success(__('Sucesss'), __('Avatar updated correctly'));
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
