<?php

return [

    /**
     * Configuration for the create commands.
     */
    'create' => [
        /**
         * create:user
         *
         * The field key has to correspond with the model field.
         * If the field is defined as an array the following fields are supported:
         *      - name: will be displayed while prompting for the field
         *      - type: ask|secret|password|uuid
         *              While the type is ask it's a normal question.
         *              When type is secret the value won't be shown while entering in the command line and will be
         *                  encrypted using bcrypt.
         *              When type is password it will generate a random 8 character string and display it at the end
         *                  this can be send to users and will be stored encrypted.
         *              When type is uuid it will generate a random uuid for the field.
         */
        'user' => [
            'model' => '\App\User',
            'unique' => 'email',
            'fields' => [
                'name',
                'email' => [
                    'name' => 'E-mail'
                ],
                'password' => [
                    'type' => 'secret'
                ]
            ]
        ]
    ],

    /**
     * Configuration for the make commands.
     */
    'make' => [
        /**
         * make:interface
         *
         * Allows you to change the namespace (and so the folder) where the interface will be stored
         */
        'interface' => [
            'namespace' => '\App\Interfaces'
        ],
        /**
         * make:scope
         *
         * Allows you to change the namespace (and so the folder) where the scope will be stored
         */
        'scope' => [
            'namespace' => '\App\Scopes'
        ],
        /**
         * make:trait
         *
         * Allows you to change the namespace (and so the folder) where the interface will be stored
         */
        'trait' => [
            'namespace' => '\App\Traits'
        ],
        /**
         * make:view:composer
         *
         * Allows you to change the namespace (and so the folder) where the view composer will be stored
         */
        'view:composer' => [
            'namespace' => '\App\Http\View\Composers'
        ],
        /**
         * make:view:composer
         */
        'facade' => [
            'namespace' => '\App\Facades'
        ]
    ]
];