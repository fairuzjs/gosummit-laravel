<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.api_key');
        $this->baseUrl = config('services.openweather.base_url', 'https://api.openweathermap.org/data/2.5');
    }

    /**
     * Get current weather for a location
     */
    public function getCurrentWeather($city)
    {
        $cacheKey = "weather_current_" . str_replace(' ', '_', strtolower($city));
        
        return Cache::remember($cacheKey, 1800, function () use ($city) {
            try {
                // Cache for 30 minutes (1800 seconds)
                $response = Http::timeout(5)->get("{$this->baseUrl}/weather", [
                    'q' => $city . ',ID',
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                    'lang' => 'id'
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Weather API failed for {$city}: " . $response->status());
                return null;
            } catch (\Exception $e) {
                Log::error("Weather API Error for {$city}: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get 5-day forecast for a location
     */
    public function getForecast($city)
    {
        $cacheKey = "weather_forecast_" . str_replace(' ', '_', strtolower($city));
        
        return Cache::remember($cacheKey, 3600, function () use ($city) {
            try {
                // Cache for 1 hour (3600 seconds)
                $response = Http::timeout(5)->get("{$this->baseUrl}/forecast", [
                    'q' => $city . ',ID',
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                    'lang' => 'id'
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Forecast API failed for {$city}: " . $response->status());
                return null;
            } catch (\Exception $e) {
                Log::error("Forecast API Error for {$city}: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get weather for multiple mountain locations
     */
    public function getMountainWeather()
    {
        $locations = [
            'Semeru' => 'Lumajang',
            'Rinjani' => 'Lombok',
            'Merapi' => 'Yogyakarta',
            'Bromo' => 'Probolinggo',
            'Gede Pangrango' => 'Bogor',
        ];

        $weatherData = [];
        foreach ($locations as $mountain => $city) {
            $weather = $this->getCurrentWeather($city);
            if ($weather) {
                $weatherData[$mountain] = $weather;
            }
        }

        return $weatherData;
    }

    /**
     * Get weather icon emoji
     */
    public function getWeatherIcon($code)
    {
        $icons = [
            '01d' => '☀️', '01n' => '🌙',
            '02d' => '⛅', '02n' => '☁️',
            '03d' => '☁️', '03n' => '☁️',
            '04d' => '☁️', '04n' => '☁️',
            '09d' => '🌧️', '09n' => '🌧️',
            '10d' => '🌦️', '10n' => '🌧️',
            '11d' => '⛈️', '11n' => '⛈️',
            '13d' => '❄️', '13n' => '❄️',
            '50d' => '🌫️', '50n' => '🌫️',
        ];
        
        return $icons[$code] ?? '🌤️';
    }

    /**
     * Format wind speed to km/h
     */
    public function formatWindSpeed($speedMs)
    {
        return round($speedMs * 3.6, 1);
    }

    /**
     * Search locations by query (autocomplete)
     */
    public function searchLocations($query)
    {
        $cacheKey = "weather_search_" . str_replace(' ', '_', strtolower($query));
        
        return Cache::remember($cacheKey, 3600, function () use ($query) {
            try {
                // Use Geocoding API to search locations
                $response = Http::timeout(5)->get("http://api.openweathermap.org/geo/1.0/direct", [
                    'q' => $query,
                    'limit' => 5,
                    'appid' => $this->apiKey
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Location search failed for {$query}: " . $response->status());
                return [];
            } catch (\Exception $e) {
                Log::error("Location search error for {$query}: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Get weather by coordinates
     */
    public function getWeatherByCoordinates($lat, $lon)
    {
        $cacheKey = "weather_coords_" . round($lat, 2) . "_" . round($lon, 2);
        
        return Cache::remember($cacheKey, 1800, function () use ($lat, $lon) {
            try {
                $response = Http::timeout(5)->get("{$this->baseUrl}/weather", [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                    'lang' => 'id'
                ]);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::warning("Weather by coords failed: " . $response->status());
                return null;
            } catch (\Exception $e) {
                Log::error("Weather by coords error: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Get forecast by coordinates
     */
    public function getForecastByCoordinates($lat, $lon)
    {
        $cacheKey = "forecast_coords_" . round($lat, 2) . "_" . round($lon, 2);
        
        return Cache::remember($cacheKey, 3600, function () use ($lat, $lon) {
            try {
                $response = Http::timeout(5)->get("{$this->baseUrl}/forecast", [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $this->apiKey,
                    'units' => 'metric',
                    'lang' => 'id'
                ]);

                if ($response->successful()) {
                    return $this->processDailyForecast($response->json());
                }

                Log::warning("Forecast by coords failed: " . $response->status());
                return null;
            } catch (\Exception $e) {
                Log::error("Forecast by coords error: " . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Process forecast data to daily format
     */
    private function processDailyForecast($forecast)
    {
        if (!isset($forecast['list'])) {
            return [];
        }

        $dailyForecasts = [];
        $processedDates = [];
        
        foreach ($forecast['list'] as $item) {
            $date = date('Y-m-d', $item['dt']);
            $hour = date('H', $item['dt']);
            
            // Get forecast around noon (12:00) for each day
            if (!in_array($date, $processedDates) && $hour >= 12 && $hour <= 15) {
                $dailyForecasts[] = [
                    'date' => $date,
                    'day_name' => $this->getDayName($item['dt']),
                    'temp' => round($item['main']['temp']),
                    'temp_min' => round($item['main']['temp_min']),
                    'temp_max' => round($item['main']['temp_max']),
                    'description' => $item['weather'][0]['description'],
                    'icon' => $item['weather'][0]['icon'],
                    'humidity' => $item['main']['humidity'],
                    'wind_speed' => $this->formatWindSpeed($item['wind']['speed']),
                ];
                $processedDates[] = $date;
            }
            
            if (count($dailyForecasts) >= 5) break;
        }
        
        return $dailyForecasts;
    }

    /**
     * Get day name in Indonesian
     */
    private function getDayName($timestamp)
    {
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        return $days[date('w', $timestamp)];
    }

    /**
     * Get suggested mountain locations from database
     */
    public function getSuggestedLocations()
    {
        $mountains = \App\Models\Mountain::where('status', 'open')
            ->orderBy('name')
            ->get()
            ->map(function($mountain) {
                // Parse location: "Lumajang, Jawa Timur" -> city, region
                $locationParts = explode(',', $mountain->location);
                $city = trim($locationParts[0] ?? $mountain->name);
                $region = trim($locationParts[1] ?? 'Indonesia');
                
                return [
                    'name' => $mountain->name,
                    'city' => $city,
                    'region' => $region,
                ];
            })
            ->toArray();
        
        return $mountains;
    }
}
