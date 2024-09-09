<?php

namespace App\Front\Inputs;

use BackedEnum;
use Illuminate\Support\HtmlString;
use Illuminate\View\DynamicComponent;
use WeblaborMx\Front\Inputs\Select;
use WireUi\Facades\WireUi;

class Enum extends Select
{
    public function load()
    {
        parent::load();

        /** @var class-string<BackedEnum> */
        $enum = $this->extra;

        $this->options(
            collect($enum::cases())
                ->mapWithKeys(
                    fn($case) => [$case->value => str($case->name)->headline()]
                )
        );
    }
}
