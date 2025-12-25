<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the news
     */
    public function index(Request $request)
    {
        $query = News::with('author')->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->category($request->category);
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'published') {
                $query->where('is_published', true);
            } elseif ($request->status == 'draft') {
                $query->where('is_published', false);
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        $news = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => News::count(),
            'published' => News::where('is_published', true)->count(),
            'draft' => News::where('is_published', false)->count(),
            'total_views' => News::sum('views'),
        ];

        return view('admin.news.index', compact('news', 'stats'));
    }

    /**
     * Show the form for creating a new news
     */
    public function create()
    {
        $categories = ['info', 'tips', 'regulation', 'event'];
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created news in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:info,tips,regulation,event',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set author
        $validated['author_id'] = auth()->id();

        // Set published_at if published
        if ($request->has('is_published') && $request->is_published) {
            $validated['is_published'] = true;
            $validated['published_at'] = $validated['published_at'] ?? now();
        } else {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
        }

        News::create($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News created successfully!');
    }

    /**
     * Show the form for editing the specified news
     */
    public function edit(News $news)
    {
        $categories = ['info', 'tips', 'regulation', 'event'];
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified news in storage
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news,slug,' . $news->id,
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:info,tips,regulation,event',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at if published
        if ($request->has('is_published') && $request->is_published) {
            $validated['is_published'] = true;
            $validated['published_at'] = $validated['published_at'] ?? now();
        } else {
            $validated['is_published'] = false;
            $validated['published_at'] = null;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News updated successfully!');
    }

    /**
     * Remove the specified news from storage
     */
    public function destroy(News $news)
    {
        // Delete image
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
                        ->with('success', 'News deleted successfully!');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(News $news)
    {
        $news->is_published = !$news->is_published;
        
        if ($news->is_published && !$news->published_at) {
            $news->published_at = now();
        }
        
        $news->save();

        $status = $news->is_published ? 'published' : 'unpublished';
        return redirect()->back()
                        ->with('success', "News {$status} successfully!");
    }
}
