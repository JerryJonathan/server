<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Api\LoginController;
// use App\Http\Controllers\Api\RegisterController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ZipCodeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MobilController;
use App\Http\Controllers\Api\RolesController;
// use App\Http\Controllers\Api\HistoryController;


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

// Route::apiResource('/users', LoginController::class);
// Route::apiResource('/users', RegisterController::class);

// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/register', [RegisterController::class, 'register']);
// Route::post('/logout', [LoginController::class, 'logout']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
Route::post('logout', [AuthController::class, 'logout']);

Route::get('/posts', [PostController::class, 'index' ]);
Route::post('/posts', [PostController::class, 'store' ]);
Route::get('/posts/{id}', [PostController::class, 'show' ]);
Route::post('/posts/{id}', [PostController::class, 'update' ]);
Route::delete('/posts/{id}', [PostController::class, 'destroy' ]);

Route::get('/getProvince', [PostController::class, 'form']);
Route::get('/getRegency/{id}', [PostController::class, 'regency']);
Route::get('/getDistrict/{id}', [PostController::class, 'district']);
Route::get('/getVillage/{id}', [PostController::class, 'village']);
Route::get("data", [PostController::class, 'postal']);

Route::post('form/data', [PostController::class, 'store']);
Route::post('form/data/{id}', [PostController::class, 'update']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store' ]);
Route::get('/users/{id}', [UserController::class, 'show' ]);
Route::post('/users/profile', [UserController::class, 'profile']);
Route::post('/changePassword', [UserController::class, 'changePassword']);
Route::post('/users/{id}', [UserController::class, 'update' ]);
Route::delete('/users/{id}', [UserController::class, 'destroy' ]);

Route::get('/kendaraan', [MobilController::class, 'index']);
Route::post('/kendaraan', [MobilController::class, 'store' ]);
Route::get('/kendaraan/{id}', [MobilController::class, 'show' ]);
Route::post('/kendaraan/{id}', [MobilController::class, 'update' ]);
Route::delete('/kendaraan/{id}', [MobilController::class, 'destroy' ]);

Route::get('/menu', [RolesController::class, 'access']);
Route::get('/roles', [RolesController::class, 'index']);
Route::get('/getPermission', [RolesController::class, 'permission']);
Route::post('/roles', [RolesController::class, 'store' ]);
Route::get('/roles/{id}', [RolesController::class, 'show' ]);
Route::get('/roles/edit/{id}', [RolesController::class, 'edit']);
Route::post('/roles/{id}', [RolesController::class, 'update' ]);
Route::delete('/roles/{id}', [RolesController::class, 'destroy' ]);

Route::resource('roles', RolesController::class);
Route::resource('users', UserController::class);

// Route::get('/history', [HistoryController::class, 'index']);
// Route::get('/roles/{id}', [HistoryController::class, 'show' ]);

// Route::get('/permissions', [PermissionsController::class, 'index']);
// Route::get('/permissions', [PermissionsController::class, 'create']);
// Route::post('/permissions', [PermissionsController::class, 'store' ]);
// Route::get('/permissions', [PermissionsController::class, 'show' ]);
// Route::get('/permissions', [PermissionsController::class, 'edit']);
// Route::post('/permissions/{id}', [PermissionsController::class, 'update' ]);
// Route::delete('/permissions/{id}', [PermissionsController::class, 'destroy' ]);

// Route::group(['middleware' => ['auth:sanctum']], function() {
   
// });
//     Route::resource('users', UserController::class);
//     Route::resource('roles', RolesController::class);
    });

