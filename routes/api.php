<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Services\WeatherService;

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

// Weather API Routes
Route::prefix('weather')->group(function () {
    // Search locations
    Route::get('/search', function(Request $request) {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }
        
        $weatherService = new WeatherService();
        $locations = $weatherService->searchLocations($query);
        
        return response()->json($locations);
    });

    // Get weather by coordinates
    Route::get('/current', function(Request $request) {
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        
        if (!$lat || !$lon) {
            return response()->json(['error' => 'Coordinates required'], 400);
        }
        
        $weatherService = new WeatherService();
        $current = $weatherService->getWeatherByCoordinates($lat, $lon);
        $forecast = $weatherService->getForecastByCoordinates($lat, $lon);
        
        return response()->json([
            'current' => $current,
            'forecast' => $forecast,
        ]);
    });
});
