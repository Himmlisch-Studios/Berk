<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class TermsAndConditions extends Component
{
    public function render()
    {
        return view('livewire.auth.terms-and-conditions');
    }
}
