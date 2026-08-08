<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Permissions Grouped by Module
    |--------------------------------------------------------------------------
    |
    | Here you may define all system permissions grouped by modules.
    |
    */
    'modules' => [

        'dashboard' => [
            'label' => 'Dashboard Access',
            'permissions' => [
                'access' => 'dashboard.access',
            ],
        ],

        'competitions' => [
            'label' => 'Competitions Management',
            'permissions' => [
                'view' => 'competitions.view',
                'create' => 'competitions.create',
                'edit' => 'competitions.edit',
                'delete' => 'competitions.delete',
            ],
        ],

        'competition_settings' => [
            'label' => 'Competition Settings',
            'permissions' => [
                'view' => 'competition-settings.view',
                'manage' => 'competition-settings.manage',
            ],
        ],

        'groups' => [
            'label' => 'Competition Groups',
            'permissions' => [
                'view' => 'groups.view',
                'create' => 'groups.create',
                'edit' => 'groups.edit',
                'delete' => 'groups.delete',
            ],
        ],

        'teams' => [
            'label' => 'Teams Management',
            'permissions' => [
                'view' => 'teams.view',
                'create' => 'teams.create',
                'edit' => 'teams.edit',
                'delete' => 'teams.delete',
            ],
        ],

        'matches' => [
            'label' => 'Matches & Live Center',
            'permissions' => [
                'view' => 'matches.view',
                'create' => 'matches.create',
                'edit' => 'matches.edit',
                'delete' => 'matches.delete',
                'live_center' => 'matches.live-center',
            ],
        ],

        'standings' => [
            'label' => 'Standings',
            'permissions' => [
                'view' => 'standings.view',
                'manage' => 'standings.manage',
            ],
        ],

        'statistics' => [
            'label' => 'Team Statistics',
            'permissions' => [
                'view' => 'statistics.view',
                'manage' => 'statistics.manage',
            ],
        ],

        'users' => [
            'label' => 'Users Directory',
            'permissions' => [
                'view' => 'users.view',
                'create' => 'users.create',
                'edit' => 'users.edit',
                'delete' => 'users.delete',
            ],
        ],

        'admins' => [
            'label' => 'Admins Directory',
            'permissions' => [
                'view' => 'admins.view',
                'create' => 'admins.create',
                'edit' => 'admins.edit',
                'delete' => 'admins.delete',
            ],
        ],

        'roles' => [
            'label' => 'Roles & Permissions',
            'permissions' => [
                'view' => 'roles.view',
                'create' => 'roles.create',
                'edit' => 'roles.edit',
                'delete' => 'roles.delete',
            ],
        ],

        'activity_logs' => [
            'label' => 'Activity Logs',
            'permissions' => [
                'view' => 'activity-logs.view',
            ],
        ],

    ],

];
