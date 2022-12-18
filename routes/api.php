<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [UserController::class, 'getUser'])->name('user');
    Route::prefix('/expense')->group(function(){
        Route::get('/outstanding', [ExpenseController::class, 'getOutstandings'])->name('expense.outstanding');
        Route::post('/', [ExpenseController::class, 'create'])->name('expense.create');
        Route::get('/all', [ExpenseController::class, 'getExpenses'])->name('expense.all');
        Route::get('/{expenseId}', [ExpenseController::class, 'getExpense'])->name('expense.individual');

    });
});


Route::post('/signup', [AuthController::class, 'register'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('login');
