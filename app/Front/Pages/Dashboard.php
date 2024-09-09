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
            Components\Welcome::make(),
            Components\Line::make(),
        ];
    }
}
