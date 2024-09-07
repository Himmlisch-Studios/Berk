<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Front's resources Folder
    |--------------------------------------------------------------------------
    |
    | This is the folder location where the front resources are located
    |
    */

    'resources_folder' => 'App\Front\Resources',

    /*
    |--------------------------------------------------------------------------
    | Model's Folder
    |--------------------------------------------------------------------------
    |
    | This is the folder location where the models are located, used when
    | creating resources with the commands.
    |
    */

    'models_folder' => 'App\Models',

    /*
    |--------------------------------------------------------------------------
    | Default Base Url
    |--------------------------------------------------------------------------
    |
    | This value is used when creating a new resource, it will add it automatically
    | on the base_url attribute
    |
    */

    'default_base_url' => '/admin',

    /*
    |--------------------------------------------------------------------------
    | Default Search Filter
    |--------------------------------------------------------------------------
    |
    | The Apply() function on this filter will be used when making a search
    | for a Front Resource. Used for autocomplete inputs and when adding
    | searchable() to relationship functions.
    |
    */

    'default_search_filter' => App\Front\Filters\SearchFilter::class,

    /*
    |--------------------------------------------------------------------------
    | Default Layout Name
    |--------------------------------------------------------------------------
    |
    | The default layout name that uses Laravel Front
    |
    */

    'default_layout' => 'layouts.front',

    /*
    |--------------------------------------------------------------------------
    | Hidden default value
    |--------------------------------------------------------------------------
    |
    | If you want to get the exactly value added on Hidden::make('The Value') set "title" (In this case it will use the column 'The Value')
    | Otherwise put "value" to convert to lower case and Snake case, example: "the_value" instead
    |
    */

    'hidden_value' => 'column',

    /*
    |--------------------------------------------------------------------------
    | Default Buttons
    |--------------------------------------------------------------------------
    |
    | Buttons used on the system
    |
    */

    'buttons' => [
        'show' => [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>',
            'name' => 'See',
            'type' => 'btn-primary',
            'class' => ''
        ],
        'edit' => [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>',
            'name' => 'Edit',
            'type' => 'btn-primary',
            'class' => ''
        ],
        'create' => [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
',
            'name' => 'Create',
            'type' => 'btn-primary',
            'class' => ''
        ],
        'delete' => [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>',
            'name' => 'Delete',
            'type' => 'btn-outline-danger',
            'class' => ''
        ],
        'up' => [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l7.5-7.5 7.5 7.5m-15 6l7.5-7.5 7.5 7.5" />
                        </svg>',
            'name' => 'Up',
            'type' => 'btn-primary',
            'class' => ''
        ],
        'down' => [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
                        </svg>',
            'name' => 'Down',
            'type' => 'btn-primary',
            'class' => ''
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Input Attributes
    |--------------------------------------------------------------------------
    |
    | Change here in case you want to change the default attributes for the inputs
    |
    */

    'default_input_attributes' => [
        'class' => 'mt-1 block w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm'
    ]
];
