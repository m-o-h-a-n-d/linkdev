<?php

return [

    'modules' => [

        'dashboard' => [
            'label' => 'Dashboard',
            'permissions' => [
                'dashboard.access',
            ],
        ],

        'competitions' => [
            'label' => 'Competitions Management',
            'permissions' => [
                'competitions.view',
                'competitions.create',
                'competitions.edit',
                'competitions.delete',
            ],
        ],

        'competition_settings' => [
            'label' => 'Competition Settings',
            'permissions' => [
                'competition-settings.view',
                'competition-settings.manage',
            ],
        ],

        'groups' => [
            'label' => 'Competition Groups',
            'permissions' => [
                'groups.view',
                'groups.create',
                'groups.edit',
                'groups.delete',
            ],
        ],

        'teams' => [
            'label' => 'Teams Management',
            'permissions' => [
                'teams.view',
                'teams.create',
                'teams.edit',
                'teams.delete',
            ],
        ],

        'matches' => [
            'label' => 'Matches & Live Scoreboard',
            'permissions' => [
                'matches.view',
                'matches.create',
                'matches.edit',
                'matches.delete',
                'matches.live-center',
            ],
        ],

        'standings' => [
            'label' => 'Standings',
            'permissions' => [
                'standings.view',
                'standings.manage',
            ],
        ],

        'statistics' => [
            'label' => 'Team Statistics',
            'permissions' => [
                'statistics.view',
                'statistics.manage',
            ],
        ],

        'users' => [
            'label' => 'Users Directory',
            'permissions' => [
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
            ],
        ],

        'admins' => [
            'label' => 'Admins Directory',
            'permissions' => [
                'admins.view',
                'admins.create',
                'admins.edit',
                'admins.delete',
            ],
        ],

        'roles' => [
            'label' => 'Roles & Permissions',
            'permissions' => [
                'roles.view',
                'roles.create',
                'roles.edit',
                'roles.delete',
            ],
        ],

        'activity_logs' => [
            'label' => 'Activity Logs',
            'permissions' => [
                'activity-logs.view',
            ],
        ],

        'settings' => [
            'label' => 'System Settings',
            'permissions' => [
                'settings.view',
                'settings.edit',
            ],
        ],

    ],

];
