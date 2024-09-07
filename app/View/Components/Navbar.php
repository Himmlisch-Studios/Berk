<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $navigation = [];

    public function __construct()
    {
        $this->addLink(
            title: __('Dashboard'),
            href: '/admin',
        )->addLink(
            title: __('My Profile'),
            href: route('admin.profile')
        )->addLink(
            title: __('Sign out'),
            href: route('logout')
        );
    }

    protected function addLink(string $title, string $href = '#',)
    {
        $this->navigation[] = compact('title', 'href');

        return $this;
    }

    protected function isAdminRoute(): bool
    {
        $path = str(config('front.default_base_url'))->trim('/');

        return request()->is(
            $path,
            $path->append('/*')
        );
    }

    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
