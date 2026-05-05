<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NotificationController;

Route::get('/error-log', function () {
    $logPath = storage_path('logs/error.log');
    if (file_exists($logPath)) {
        return response()->file($logPath);
    }
    return 'No error log yet';
});

Route::get('/', function (Illuminate\Http\Request $request) {
    $feed = $request->query('feed', 'all');
    $user = Auth::user();

    $query = \App\Models\Message::whereNull('parent_id')->with(['user', 'likes', 'replies']);

    if ($feed === 'following') {
        $followingIds = $user->followings()->pluck('followed_id');
        $query->whereIn('user_id', $followingIds);
    }

    return view('dashboard', [
        'messages' => $query->latest()->get(),
        'feed' => $feed
    ]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/@{user}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/@{user}/followings', [ProfileController::class, 'followings'])->name('profile.followings');
	Route::get('/@{user}', [ProfileController::class, 'wall'])->name('profile.wall');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])
    ->middleware(['auth'])
    ->name('messages.store');

Route::get('/messages/{message}', [App\Http\Controllers\MessageController::class, 'show'])
    ->middleware(['auth'])
    ->name('messages.show');

Route::post('/messages/{message}/like', [App\Http\Controllers\LikeController::class, 'toggle'])
    ->middleware(['auth'])
    ->name('messages.like');

Route::post('/users/{user}/follow', [App\Http\Controllers\FollowController::class, 'toggle'])
    ->middleware(['auth'])
    ->name('users.follow');
