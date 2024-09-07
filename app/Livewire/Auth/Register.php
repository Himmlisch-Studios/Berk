<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    use Traits\NeedsVerification;

    public $user, $password, $password_confirmation;
    public $acceptTerms = false;

    public function rules()
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
            'acceptTerms' => ['accepted'],
        ];
    }

    public function mount()
    {
        $this->user = new User;
    }

    public function register()
    {
        $this->validate();
        if (config('auth.approach') == 'CreationValidation' && is_null($this->user->email_verified_at) && $this->view == 'normal') {
            return $this->verifyEmail('register', false);
        }

        $this->user->password = $this->password;
        $this->user->save();

        $this->reset(['password', 'password_confirmation']);
        auth()->login($this->user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
