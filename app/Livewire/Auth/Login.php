<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

#[Layout('layouts.auth')]
class Login extends Component
{
    use Traits\NeedsVerification, WireUiActions;

    public $email;
    public $password;
    public $remember = false;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'boolean'
        ];
    }

    public function login()
    {
        $this->validate();

        $attempt = Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember);

        if (!$attempt) {
            return $this->notification()->error(__('Wrong credentials'), __('Please, try again'));
        }

        $this->reset('password');

        session()->put('auth.password_confirmed_at', time());
        session()->regenerate();

        return redirect('/admin');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
