<?php

use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\FeatchController;
use App\Http\Controllers\WaterpumpController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('waterpumps', WaterpumpController::class);

    Route::get('station/index', [FeatchController::class, 'index'])->name('featch-index');

    Route::get('station/show/{logger_sn}', [FeatchController::class, 'featchOne'])->name('featch-one');
});

Route::get('/proxy/devices', function () {
    $client = new Client();

    try {
        // Gửi yêu cầu đến API bên ngoài
        $response = $client->request('GET', 'http://pat-server.ddns.net:8000/devices');
        // Giải mã dữ liệu JSON
        $data = json_decode($response->getBody(), true);

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($data);
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        // Xử lý lỗi và trả về thông báo lỗi
        return response()->json([
            'error' => $e->getMessage(),
            'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
        ], 500);
    }
});


