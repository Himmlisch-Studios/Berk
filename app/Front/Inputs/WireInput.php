<?php

namespace App\Front\Inputs;

use Illuminate\Support\HtmlString;
use Illuminate\View\DynamicComponent;
use WeblaborMx\Front\Inputs\Input;
use WireUi\Facades\WireUi;

class WireInput extends Input
{
    protected ?array $slots = [];

    public function __construct(
        public readonly string $wireUiComponent,
    ) {
        parent::__construct();
    }

    public static function make($wireUiComponent = null, $attributes = [], $slot = null)
    {
        $self = new static($wireUiComponent, $slot);

        $self->attributes  = $attributes ?? [];

        return $self;
    }

    public function form()
    {
        $component = new DynamicComponent(WireUi::component($this->wireUiComponent));
        $component->withAttributes([
            ...$this->attributes,
            'class' => $this->class
        ]);

        $slots = $this->slots;

        if (count($slots)) {
            $slots = collect($this->slots)->map(function ($components) {
                $html = collect($components)->map->toHtml()->join('');
                return new HtmlString($html);
            });
        }

        $data = ['__laravel_slots' => [], ...$component->data(), ...$slots];

        $view = $component->resolveView($data);

        if (is_callable($view)) {
            $view = $view($data);
        }

        return view($view, $data);
    }

    public function slot($components = [], $name = 'slot')
    {
        $this->slots[$name] = $components;

        return $this;
    }

    public function children($components = [])
    {
        return $this->slot($components, 'slot');
    }
}
