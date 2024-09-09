<?php

namespace App\Front\Inputs;

use WeblaborMx\Front\Inputs\Input;
use WireUi\Support\WireUiSupport;

class Flask extends Input
{

    public $show_on_index = false;

    public function getValue($object)
    {
        return $this->buildHtml();
    }

    public function form()
    {
        return $this->buildHtml();
    }

    protected function buildHtml()
    {
        $jsParams = app(WireUiSupport::class)->toJs([
            $this->column,
            $this->resource?->object->{$this->column} ?? $this->default_value,
            'bash',
            $this->source !== 'edit',
        ]);

        return html()
            ->div()
            ->attribute('x-data', "flask(...$jsParams)")
            ->class('w-full h-56 relative overflow-hidden border-gray-300 shadow my-4 border rounded')
            ->child(
                html()
                    ->div()
                    ->class('absolute inset-0')
                    ->attribute('x-ref', 'editor')
            );
    }
}
