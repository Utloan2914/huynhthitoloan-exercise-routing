<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

//Mission 1
Route::get('/users', function () {
    global $users;
    $userNames = [];
    foreach ($users as $user) {
        $userNames[] = $user['name'];
    }
    $result = 'The users are: ' . implode(', ', $userNames) . ',';
    return $result;
});



Route::prefix('/user')->group(function () {
    // Mission 2: Get all users
    Route::get('/users', function () {
        global $users;
        $userNames = [];
        foreach ($users as $user) {
            $userNames[] = $user['name'];
        }
        $result = 'The users are: ' . implode(', ', $userNames) . ',';
        return $result;
    });

    // // Mission 3: Get user by index
    // Route::get('/api/user/{userIndex}', function ($userIndex) {
    //     global $users;
    //     if (isset($users[$userIndex])) {
    //         $user = $users[$userIndex];
    //         return [
    //             'name' => $user['name'],
    //             'posts' => $user['posts'],
    //         ];
    //     } else {
    //         return "Cannot find this user with index " . $userIndex;
    //     }
    // });

    // Mission 4: Get user by name
    Route::get('/api/user/{userName}', function ($userName) {
        global $users;
        $foundUser = null;
        foreach ($users as $user) {
            if ($user['name'] === $userName) {
                $foundUser = $user;
                break;
            }
        }
        if ($foundUser !== null) {
            return [
                'name' => $foundUser['name'],
                'posts' => $foundUser['posts'],
            ];
        } else {
            return "Cannot find this user with name " . $userName;
        }
    });

    // Mission 5
    Route::fallback(function () {
        return "You cannot get a user like this!";
    });
  
});


// Mission 6: Get posts
Route::get('/api/user/{userIndex}/post/{postIndex}', function ($userIndex, $postIndex) {
    global $users;
    if (isset($users[$userIndex])) {
        $user = $users[$userIndex];
        if (isset($user['posts'][$postIndex])) {
            $post = $user['posts'][$postIndex];
            return $post;
        } else {
            return "Cannot find the post with id {$postIndex} for user {$userIndex}";
        }
    } else {
        return "Cannot find the user with id {$userIndex}";
    }
});