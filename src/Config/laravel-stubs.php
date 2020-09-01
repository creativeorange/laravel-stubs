<?php

use Illuminate\Support\Str;

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
         * make:facade
         *
         * Allows you to change the namespace (and so the folder) where the facade will be stored
         */
        'facade' => [
            'namespace' => '\App\Facades'
        ],
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
    ],

    /**
     * Configuration for the patch command.
     */
    'patch' => [
        /**
         * The folder that contains your language folders
         * This is the base folder, while patching language tags it will loop over all folders inside this folder to find the needed languages
         */
        'language_folder' => base_path('resources/lang'),
        /**
         * The tags that need to be replaced with other tags.
         * If not provided as key => value it will prompt for a value.
         */
        'language_tags' => [
            'passwords.user'
        ],
        'language_exclude' => [
            'vendor'
        ],
        'config_folder' => base_path('config'),
        'config_options' => [
            'session.secure' => "env('SESSION_SECURE_COOKIE', true)",
            'session.cookie' => "env('SESSION_COOKIE', ENV('SESSION_COOKIE_PREFIX', '__Secure-') . Str::slug(env('APP_NAME', 'laravel'), '_').'_session')"
        ],
        'middleware_folder' => base_path('app/Http/Middleware'),
        'cookies' => [
            'namespace' => '\App\Foundation\Cookie'
        ],
        'public_folder' => \base_path('public'),
        'htaccess' => [
            'mod_headers.c' => [
                'needsModule' => true,
                'values' => [
                    'Header always set X-Frame-Options SAMEORIGIN',
                    'Header always set X-XSS-Protection 1;mode=block',
                    'Header always set X-Content-Type-Options nosniff',
                    'Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload" env=HTTPS',
                    'Header always set Referrer-Policy "no-referrer-when-downgrade"',
                    'Header always set Content-Security-Policy: "default-src \'self\'; \
                        script-src \'self\'; \
                        object-src \'self\'; \
                        style-src \'self\'; \
                        img-src \'self\'; \
                        media-src \'self\'; \
                        frame-src \'self\'; \
                        font-src \'self\'; \
                        connect-src \'self\'; \
                        form-action \'self\'; \
                        sandbox \'self\'; \
                        script-nonce \'self\'; \
                        reflected-xss \'self\'; \
                        plugin-types \'self\'; \
                        report-uri \'self\'"',
                ]
            ],
            'mod_expires.c' => [
                'needsModule' => true,
                'values' => [
                    'ExpiresActive on',
                    'AddType application/font-sfnt            otf ttf',
                    'AddType application/font-woff            woff',
                    'AddType application/font-woff2           woff2',
                    'AddType application/vnd.ms-fontobject    eot',
                    'ExpiresDefault "access plus 2 days"',
                    'ExpiresByType image/jpg "access plus 2 months"',
                    'ExpiresByType image/svg+xml "access 2 months"',
                    'ExpiresByType image/gif "access plus 2 months"',
                    'ExpiresByType image/jpeg "access plus 2 months"',
                    'ExpiresByType image/png "access plus 2 months"',
                    'ExpiresByType text/css "access plus 2 months"',
                    'ExpiresByType text/javascript "access plus 2 months"',
                    'ExpiresByType application/javascript "access plus 2 months"',
                    'ExpiresByType application/x-shockwave-flash "access plus 2 months"',
                    'ExpiresByType image/ico "access plus 2 months"',
                    'ExpiresByType image/x-icon "access plus 2 months"',
                    'ExpiresByType text/html "access plus 600 seconds"',
                    'ExpiresByType application/font-woff "access plus 2 months"',
                    'ExpiresByType application/font-woff2 "access plus 2 months"',
                    'ExpiresByType application/font-sfnt "access plus 2 months"',
                    'ExpiresByType application/vnd.ms-fontobject "access plus 2 months"',
                ]
            ]
        ]
    ]
];