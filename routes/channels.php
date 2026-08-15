<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Admin Notifications Channel
Broadcast::channel('admin.notifications', function ($user) {
    return $user && ($user->hasRole('admin') || $user->hasRole('super-admin') || $user->admin !== null || auth('admin')->check());
});

Broadcast::channel('admin-notifications', function () {
    return true;
});

// Public Live Matches & Single Match Channels
Broadcast::channel('live-matches', function () {
    return true;
});

Broadcast::channel('match.{id}', function () {
    return true;
});

