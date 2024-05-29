<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Blueprint\Models\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Rutas para usuarios

Route::get('users/{user}', [UserController::class, 'show'])->name('api.users.show');
Route::get('users', [UserController::class, 'index'])->name('api.users.index');

Route::post('users',[UserController::class, 'store'])->name('api.users.store');

Route::delete('users/{user}', [UserController::class, 'destroy'])->name('api.users.destroy');

Route::patch('users/{user}', [UserController::class, 'update'])->name('api.users.update');
Route::put('users/{user}', [UserController::class, 'update'])->name('api.users.update');

//Ruta para videos
Route::get('videos/{video}', [VideoController::class, 'show'])->name('api.videos.show');
Route::get('videos', [VideoController::class, 'index'])->name('api.videos.index');
Route::post('videos', [VideoController::class, 'store'])->name('api.videos.store');
Route::delete('videos/{video}', [VideoController::class, 'destroy'])->name('api.videos.destroy');
Route::put('videos/{video}', [VideoController::class, 'update'])->name('api.videos.update');
Route::patch('videos/{video}', [VideoController::class, 'update'])->name('api.videos.update');

Route::get('posts/{post}', [PostController::class, 'show'])->name('api.posts.show');
Route::get('post', [PostController::class, 'index'])->name('api.posts.index');

//Rutas para Auth
Route::post('register', [AuthController::class, 'store'])->name('api.users.store');
Route::post('login', [AuthController::class, 'login'])->name('api.users.login');

// Route::get('user/{id}', function (string $id){
//     return new UserResource(User::findOrFail($id));
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
