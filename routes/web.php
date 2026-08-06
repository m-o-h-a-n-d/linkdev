<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('frontend.index');
})->name('home');

// Account Page - Direct Route Closures without Controller
Route::get('/account', function () {
    $user = auth()->user() ?? User::first();
    if (! $user) {
        $user = User::create([
            'name' => 'System Admin',
            'email' => 'admin@linkdev.com',
            'password' => bcrypt('password'),
        ]);
    }
    return view('frontend.account.account', compact('user'));
})->name('account.index');

Route::put('/account', function (Request $request) {
    $user = auth()->user() ?? User::first();
    if (! $user) {
        $user = User::create([
            'name' => 'System Admin',
            'email' => 'admin@linkdev.com',
            'password' => bcrypt('password'),
        ]);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
    ]);

    $user->update($validated);

    return redirect()->route('account.index')->with('success', 'Account details updated successfully!');
})->name('account.update');

// Auth Pages
Route::get('/login', function () {
    return view('frontend.auth.login');
})->name('login');

Route::get('/register', function () {
    return view('frontend.auth.register');
})->name('register');

Route::post('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');

// Public Pages
Route::get('/competitions', function () {
    return view('frontend.pages.competitions');
})->name('competitions.index');

Route::get('/matches', function () {
    return view('frontend.pages.matches');
})->name('matches.index');

Route::get('/teams', function () {
    return view('frontend.pages.teams');
})->name('teams.index');
