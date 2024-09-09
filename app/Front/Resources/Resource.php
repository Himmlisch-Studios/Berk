<?php

namespace App\Front\Resources;

use WeblaborMx\Front\Resource as Base;

abstract class Resource extends Base
{
    /**
     * Name of the icon to show on the sidebar
     *
     * @see https://v1.heros.coasdasadsad m/
     * @var string
     */
    public $icon = 'rectangle-stack';

    /**
     * Whether to filter this resource from the menu
     *
     * @var boolean
     */
    public $showOnMenu = true;
}
