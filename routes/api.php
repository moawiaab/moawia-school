<?php

use App\Http\Controllers\Api\LoginApiController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Api', 'middleware' => ['auth:sanctum']], function () {
    Route::get('abilities', 'AbilitiesController@index');
    //! permission controller
    Route::resource('permissions', 'PermissionsApiController');
    Route::post('/permissions/delete-all', 'PermissionsApiController@destroyAll');
    Route::post('/permissions/add-all', 'PermissionsApiController@addAll');
    Route::put('/permissions/{item}/restore', 'PermissionsApiController@restore');
    Route::put('/permissions/{item}/delete-restore', 'PermissionsApiController@deleteRestore');
    Route::get('/permissions-export', 'PermissionsApiController@export');

    Route::get('/dashboard', 'DashboardApiController@index')->name('dashboard');
    Route::get('dashboard/user', 'DashboardApiController@userData');
    // ! account controller
    Route::get('accounts', 'AccountApiController@index');
    Route::put('/accounts/{account}/toggle', 'AccountApiController@toggle')->name('account.toggle');

    // ! Roles controller
    Route::resource('roles', 'RolesApiController');
    Route::post('/roles/delete-all', 'RolesApiController@destroyAll');
    Route::put('/roles/{item}/restore', 'RolesApiController@restore');

    //! Users controller
    Route::resource('/users', 'UsersApiController');
    Route::put('/users/{user}/toggle', 'UsersApiController@toggle')->name('user.toggle');
    Route::post('/users/delete-all', 'UsersApiController@destroyAll');
    Route::post('/users/add-all', 'UsersApiController@addAll');
    Route::put('/users/{item}/restore', 'UsersApiController@restore');
    Route::post('/users/password', 'UsersApiController@password')->name('users.password');
    Route::post('/users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::put('/users/{user}/locker', 'UsersApiController@locker');

    Route::get('/shops/data', 'UsersApiController@showData');
    //! stages  controller
    Route::resource('stages', 'StageApiController');
    Route::put('/stages/{stage}/toggle', 'StageApiController@toggle');

    // ! expanses controller
    Route::resource('expanses', 'ExpanseApiController');
    Route::put('/expanses/{expanse}/toggle', 'ExpanseApiController@toggle');
    Route::put('/expanses/{expanse}/amount', 'ExpanseApiController@amount');

    //! public treasured controller
    Route::resource('public-treasuries', 'PublicTreasuryApiController');
    Route::get('public-treasuries/show-data/{id}', 'PublicTreasuryApiController@show');
    Route::put('public-treasuries/{item}/done', 'PublicTreasuryApiController@done');
    //! private locker controller
    Route::resource('private-lockers', 'PrivateLockerApiController');
    Route::put('/private-lockers/{privateLocker}/toggle', 'PrivateLockerApiController@toggle');
    Route::put('/private-lockers/{privateLocker}/amount', 'PrivateLockerApiController@amount');

    //! Budget Name controller
    Route::resource('budget-names', 'BudgetNameApiController');
    Route::put('/budget-names/{budgetName}/restore', 'BudgetNameApiController@restore');
    Route::put('/budget-names/{budgetName}/toggle', 'BudgetNameApiController@toggle');

    //! Budgets controller
    Route::resource('budgets', 'BudgetApiController');

    //! Students controller
    Route::resource('students', 'StudentApiController');
    Route::put('/students/{item}/restore', 'StudentApiController@restore');
    Route::get('/students/{student}/data', 'StudentApiController@showData');

    //! levels controller
    Route::resource('levels', 'LevelApiController');
    Route::put('/levels/{item}/restore', 'LevelApiController@restore');
    Route::get('/levels-data', 'LevelApiController@showTow');

    //! materials controller
    Route::resource('materials', 'MaterialApiController');
    Route::put('/materials/{item}/restore', 'MaterialApiController@restore');
    Route::post('/materials/data', 'MaterialApiController@addData');
    Route::delete('/materials/{item}/delete', 'MaterialApiController@deleteItem');

    //! teachers controller
    Route::resource('teachers', 'TeacherApiController');
    Route::put('/teachers/{item}/restore', 'TeacherApiController@restore');

    //! tutorials controller
    Route::resource('tutorials', 'TutorialApiController');
    Route::put('/tutorials/{item}/restore', 'TutorialApiController@restore');
    Route::post('/tutorials/media', 'TutorialApiController@storeMedia')->name('tutorials.storeMedia');
    Route::delete('/tutorials/{item}/delete', 'TutorialApiController@deleteItem');
    Route::get('/tutorials/{tutorial}/one', 'TutorialApiController@showOne');
    Route::post('/tutorials/add-asks', 'TutorialApiController@asks');
    Route::post('/tutorials/answer', 'TutorialApiController@answer');

});

Route::post('/login', [LoginApiController::class, 'login']);
Route::post('/register', [LoginApiController::class, 'store']);
