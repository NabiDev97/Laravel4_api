<?php
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
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


//lien qui permettra au client(Bootstrap React...) de se brancher
//recuperer la liste des posts
Route::get('posts',[PostController::class,'index']);

//Ajouter un post/POST/PUT/PATCH



Route::middleware('auth:sanctum')-> group(function(){

    Route::delete('posts/{post}',[PostController::class]);

    Route::put('posts/edit/{post}',[PostController::class,'update']);

    Route::post('posts/create',[PostController::class,'store']);

    //retourner l'itilisateur actuellement connecter
    Route::get('/user',function(Request $request){
        return $request->user();
    });
});

Route::post('/register',[UserController::class,'register']);