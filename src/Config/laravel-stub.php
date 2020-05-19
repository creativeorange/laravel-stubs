<?php

return [

    /**
     * Configuration for the create commands
     */
    'create' => [
        /**
         * Create:user
         *
         * The field key has to correspond with the model field.
         * If the field is defined as an array the following fields are supported:
         *      - name: will be displayed while prompting for the field
         *      - type: ask|secret
         *              While the type is ask it's a normal question.
         *              When type is secret the value won't be shown while entering in the command line and will be
         *                  encrypted using bcrypt.
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
    ]
];