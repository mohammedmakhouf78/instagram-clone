<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostImagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
Route::post('user/profile/upload',[UserController::class,'profileUpload']);
Route::post('user/getDetails',[UserController::class,'getDetails']);
Route::post('user/follow',[UserController::class,'follow']);
Route::post('user/getFollowings',[UserController::class,'getFollowings']);
Route::get('user/getSugUsers',[UserController::class,'getSugUsers']);



Route::post('getPosts',[PostController::class,'getPosts']);
Route::post('getUserPosts',[PostController::class,'getUserPosts']);
Route::post('post/create',[PostController::class,'create']);
Route::post('post/like',[PostController::class,'like']);
Route::post('post/comment',[PostController::class,'comment']);
Route::post('post/checkIfLiked',[PostController::class,'checkIfLiked']);

Route::post('post/upload',[PostImagesController::class,'upload']);
Route::post('post/delete_image',[PostImagesController::class,'delete_image']);