<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of published news
     */
    public function index(Request $request)
    {
        $categories = ['info', 'tips', 'regulation', 'event'];
        
        // Get 6 latest published news for carousel
        $featuredNews = News::with('author')
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();
        
        // Get IDs of featured news to exclude from main grid
        $featuredIds = $featuredNews->pluck('id')->toArray();
        
        // Build query for main news grid (excluding featured)
        $query = News::with('author')
            ->published()
            ->when(count($featuredIds) > 0, function($q) use ($featuredIds) {
                return $q->whereNotIn('id', $featuredIds);
            })
            ->latest('published_at');
        
        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Apply category filter
        if ($request->filled('category')) {
            $query->category($request->category);
        }
        
        $news = $query->paginate(9);
        
        // Get weather data for mountain locations
        $weatherService = new WeatherService();
        $mountainWeather = $weatherService->getMountainWeather();
        $suggestedLocations = $weatherService->getSuggestedLocations();
        
        return view('news.index', compact('news', 'featuredNews', 'categories', 'mountainWeather', 'suggestedLocations'));
    }

    /**
     * Display the specified news
     */
    public function show($slug)
    {
        $news = News::with('author')
                   ->where('slug', $slug)
                   ->published()
                   ->firstOrFail();

        // Increment views
        $news->incrementViews();

        // Get related news (same category, exclude current)
        $relatedNews = News::published()
                          ->where('category', $news->category)
                          ->where('id', '!=', $news->id)
                          ->orderBy('published_at', 'desc')
                          ->limit(3)
                          ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}
