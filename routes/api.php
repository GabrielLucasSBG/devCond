<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,
    BilletController,
    DocController,
    FoundAndLostController,
    ReservationController,
    UnitController,
    UserController,
    WallController,
    WarningController,
};

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logou', [AuthController::class, 'logout']);

    //MURAL DE AVISOS
    Route::get('/walls', [WallController::class, 'getAll']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);

    //DOCUMENTOS
    Route::get('/docs', [DocController::class, 'getAll']);

    //LIVRO DE OCORRÊCIAS
    Route::get('/warnings', [WarningController::class, 'getMyWarnings']);
    Route::post('/warning', [WarningController::class, 'setWarning']);
    Route::post('/warning/file', [WarningController::class, 'addWarningFile']);

    //BOLETOS
    Route::get('/billets', [BilletController::class, 'getAll']);

    //ACHADOS E PERDIDOS
    Route::get('/foundandlost', [FoundAndLostController::class, 'getAll']);
    Route::post('/foundandlost', [FoundAndLostController::class, 'insert']);
    Route::put('/foundandlost{id}', [FoundAndLostController::class, 'update']);

    //UNIDADE
    Route::get('/unit/{id}', [UnitController::class, 'getInfo']);
    Route::post('/unit/{id}/addperson', [UnitController::class, 'addperson']);
    Route::post('/unit/{id}/addvehicle', [UnitController::class, 'addvehicle']);
    Route::post('/unit/{id}/addpet', [UnitController::class, 'addpet']);
    Route::post('/unit/{id}/removeperson', [UnitController::class, 'removeperson']);
    Route::post('/unit/{id}/removevehicle', [UnitController::class, 'removevehicle']);
    Route::post('/unit/{id}/removepet', [UnitController::class, 'removepet']);

    //RESERVAS
    Route::get('/reservations', [ReservationController::class, 'getReservations']);
    Route::get('/myreservations', [ReservationController::class, 'getMyReservations']);
    Route::delete('myreservation/{id}', [ReservationController::class, 'delMyReservation']);
    Route::post('reservation/{id}', [ReservationController::class, 'setReservation']);
    Route::get('/reservation/{id}/disableddates', [ReservationController::class, 'getDisabledDates']);
    Route::get('/reservation/{id}/times', [ReservationController::class, 'getTimes']);
});
