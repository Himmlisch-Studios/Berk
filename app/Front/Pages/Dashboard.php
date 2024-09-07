<?php

namespace App\Front\Pages;

use App\Front\Inputs as Custom;
use Spatie\Html\Elements as Html;
use WeblaborMx\Front\Components;
use WeblaborMx\Front\Inputs;

class Dashboard extends Page
{
    public function fields()
    {


        return [
            // Place here the Laravel Front field inputs and components 
            Components\Welcome::make(),

            Inputs\Text::make()
                ->setValue('Your email is ' . auth()->user()->email)
                ->addAttribute('readonly', true),

            // You can also place any object that implements `Htmlable`
            Html\Div::create()->class('border-b-2 my-7'),

            // You can create your own custom Inputs
            // This one can render WireUI components
            Custom\WireInput::make('modal')
                ->addAttribute('name', 'my-modal')
                ->addAttribute('blurness', true)
                ->children([
                    Custom\WireInput::make('card')
                        ->addAttribute('title', 'Meow!')
                        ->class('w-full')
                        ->children([
                            Html\Img::create()
                                ->src('//placekitten.com/1000/1000'),
                            Html\P::create()
                                ->text('Have a nice day...')
                                ->class('text-center text-gray-700 mt-5 italic')
                        ])
                ]),

            Custom\WireInput::make('button', [
                'label' => 'Click me :D',
                'x-on:click' => "\$openModal('my-modal')",
                'full' => true
            ]),
        ];
    }
}
