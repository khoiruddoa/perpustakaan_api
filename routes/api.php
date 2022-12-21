<?php

use App\Http\Controllers\api\AuthorController;
use App\Http\Controllers\api\BookController;
use App\Http\Controllers\api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/author", [AuthorController::class, "index"]);
Route::get("/author/{id}", [AuthorController::class, "show"]);
Route::post("author/", [AuthorController::class, "store"]);
Route::post("/author/{id}", [AuthorController::class, "update"]);
Route::get("/author/delete/{id}", [AuthorController::class, "destroy"]);


Route::get("/category", [CategoryController::class, "index"]);
Route::get("/category/{id}", [CategoryController::class, "show"]);
Route::post("category/", [CategoryController::class, "store"]);
Route::post("/category/{id}", [CategoryController::class, "update"]);
Route::get("/category/delete/{id}", [CategoryController::class, "destroy"]);


Route::get("/book", [BookController::class, "index"]);
Route::get("/book/{id}", [BookController::class, "show"]);
Route::post("book/", [BookController::class, "store"]);
Route::post("/book/{id}", [BookController::class, "update"]);
Route::get("/book/delete/{id}", [BookController::class, "destroy"]);
