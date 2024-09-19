<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Models\Room;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/test", function () {
    return 'some!';
});

// # TODO router to lara MODEL 
Route::get('/get/{id?}', function () {
    // return [1,2,3,4];
    // return Room::all();
    // dd(Storage::disk('local'));
    $scheme = Storage::disk('local')->get('hello.json');
    // $scheme = json_decode['2222'];
    // dd($scheme);
    // return response()->json($scheme);
    return $scheme;
    // json_decode();
    // $file = file_get_contents(resource_path('assets/hello.json'));
    // $jsonData = json_decode($file, true);
    // return $jsonData;
});
Route::get('/search', [RoomController::class, 'search']);
