<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\PageController;
use App\Http\Controllers\v1\ChatController;
use App\Http\Controllers\v1\NotificationController;
use App\Http\Controllers\v1\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PageController::class, 'home']);

Route::get('/AboutUs', [PageController::class, 'AboutUs']);

Route::get('/Services', [PageController::class, 'Service']);

Route::get('/Client', [PageController::class, 'Client']);

Route::prefix('Blog')->group(function () {    
    Route::get('/', [PageController::class, 'Blog']);
    Route::get('/{id}', [PageController::class, 'content']);
    Route::post('comment/{id}', [PageController::class, 'createCommentWeb'])->middleware('auth')->name('comment');
});

Route::get('/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/resetEmail', function(){return view('Dashboard.ResetEmail');});
Route::post('/sendReset', [AuthController::class, 'sendResetToken'])->name('send.reset');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPage'])->name('password.reset');
Route::post('/reset-password/{token}', [AuthController::class, 'reset'])->name('password.reset');
Route::get('/linkSent', [AuthController::class, 'LinkSent']);

Route::get('/Contact', [PageController::class, 'Contact']);

Route::get('/login', [PageController::class, 'LoginView'])->name('show.login');
Route::post('/login', [AuthController::class, 'LoginWeb'])->name('login');

Route::get('/register', [PageController::class, 'RegisterView']);
Route::post('/register', [AuthController::class, 'registerWeb'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('Forum')->group(function () {
    Route::get('/', [ChatController::class, 'getChats']);
    Route::middleware('auth')->group(function () {
        Route::post('/AddMessage', [ChatController::class, 'sendMessage'])->name('add.message');
        Route::post('/Poll/Vote', [ChatController::class, 'vote']);
        Route::delete('/DeleteMessage/{id}', [ChatController::class, 'deleteMessage']);
        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);        
        });
    });
    Route::get('/get/{id}', [ChatController::class, 'getMessages'])->middleware('auth:sanctum');
});

Route::prefix('Dashboard')->middleware(['auth', 'role:Admin,Moderator,Konten'])->group(function () {
    Route::get('/', [DashboardController::class, 'Dashboard']);

    Route::prefix('User')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboarduser']);
        Route::get('/add', [DashboardController::class, 'dashboardUserAdd']);
        Route::post('/add', [DashboardController::class, 'CreateUser'])->name('add.User');
        Route::get('/info/{id}', [DashboardController::class, 'dashboardUserInfo']);
        Route::get('/edit/{id}', [DashboardController::class, 'dashboardUserEdit']);
        Route::post('/edit/{id}', [DashboardController::class, 'UpdateUser'])->name('edit.User');
        Route::delete('/delete/{id}', [DashboardController::class, 'DeleteUser'])->name('delete.User');
    });

    Route::prefix('Blog')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboardblog']);
        Route::get('/add', [DashboardController::class, 'dashboardBlogAdd']);
        Route::post('/add', [DashboardController::class, 'CreateContent'])->name('add.Blog');
        Route::get('/edit/{id}', [DashboardController::class, 'dashboardBlogEdit']);
        Route::post('/edit/{id}', [DashboardController::class, 'UpdateContent'])->name('edit.Blog');
        Route::delete('/delete/{id}', [DashboardController::class, 'DeleteContent'])->name('delete.Blog');
    });

    Route::prefix('Comment')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboardcomment']);
        Route::delete('/delete/{id}', [DashboardController::class, 'DeleteComment'])->name('delete.Comment');
    });

    Route::prefix('/Client')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboardclient'])->name('index.Client');
        Route::get('/add', [DashboardController::class, 'dashboardClientAdd']);
        Route::post('/add', [DashboardController::class, 'CreateClientWeb'])->name('add.Client');
        Route::get('/edit/{id}', [DashboardController::class, 'dashboardClientEdit']);
        Route::post('/edit/{id}', [DashboardController::class, 'UpdateClientWeb'])->name('edit.Client');
        Route::delete('delete/{id}', [DashboardController::class, 'DeleteClientWeb'])->name('delete.Client');
    });

    Route::prefix('Forum')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboardforum']);
        Route::get('/add', [DashboardController::class, 'dashboardforumAdd']);
        Route::post('/add', [DashboardController::class, 'CreateForum'])->name('add.Forum');
        Route::get('/info/{id}', [DashboardController::class, 'dashboardForumInfo']);
        Route::get('/edit/{id}', [DashboardController::class, 'dashboardforumEdit']);
        Route::post('/edit/{id}', [DashboardController::class, 'UpdateForum'])->name('edit.Forum');
        Route::delete('delete/{id}', [DashboardController::class, 'DeleteForum'])->name('delete.Forum');
        Route::delete('deleteChat/{id}', [DashboardController::class, 'DeleteChat'])->name('delete.Chat');
    });

    Route::prefix('Settings')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboardsettings']);
        Route::post('/', [DashboardController::class, 'UpdateTitle'])->name('edit.settings');
        Route::get('/{id}', [DashboardController::class, 'dashboardUserSetting']);
        Route::post('/{id}', [DashboardController::class, 'UpdateSetting'])->name('edit.Setting');
    });
});
