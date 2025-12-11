<?php

namespace App\Http\Controllers;

use App\Models\Mountain; 
use App\Models\TrailRoute; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMountainRequest;
use App\Http\Requests\UpdateMountainRequest;

class MountainController extends Controller
{
    // Method baru untuk Autocomplete Search
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        
        if (!$query) {
            return response()->json([]);
        }

        $data = Mountain::select("name", "location", "height", "status")
                    ->where("name", "LIKE", "%{$query}%")
                    ->orWhere("location", "LIKE", "%{$query}%")
                    ->limit(8) // Batasi 8 hasil saja agar rapi
                    ->get();
        
        return response()->json($data);
    }

    public function index(Request $request)
    {
        $query = Mountain::query();
        
        // Handle search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }
        
        // Handle status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $mountains = $query->latest()->get();
        return view('admin.mountains.index', compact('mountains'));
    }

    public function create()
    {
        return view('admin.mountains.create');
    }

    public function store(StoreMountainRequest $request)
    {
        // Validasi
        $validated = $request->validated();
        
        try {
            DB::beginTransaction();

            // Ambil data termasuk 'height'
            $mountainData = $request->only([
                'name', 'description', 'location', 'ticket_price', 'height', 'daily_quota', 'status'
            ]);
            
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('mountains', 'public');
                $mountainData['image_url'] = $path; 
            }

            $mountain = Mountain::create($mountainData);

            if (!empty($validated['trail_routes'])) {
                $routesToCreate = [];
                foreach ($validated['trail_routes'] as $routeData) {
                    if (isset($routeData['name'])) {
                        $routesToCreate[] = [
                            'mountain_id' => $mountain->id, 
                            'name' => $routeData['name'],
                            'description' => $routeData['description'] ?? null,
                            'status' => $routeData['status'] ?? 'open', 
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (!empty($routesToCreate)) {
                    TrailRoute::insert($routesToCreate);
                }
            }

            DB::commit();
            return redirect()->route('admin.mountains.index')->with('success', 'Mountain created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Mountain creation failed: ' . $e->getMessage()); 
            return redirect()->back()->with('error', 'Gagal membuat gunung.')->withInput();
        }
    }

    public function edit(Mountain $mountain)
    {
        return view('admin.mountains.edit', compact('mountain'));
    }

    public function update(UpdateMountainRequest $request, Mountain $mountain)
    {
        // Validasi Update
        $validated = $request->validated();

        // Ambil data termasuk 'height'
        $mountainData = $request->only([
            'name', 'description', 'location', 'ticket_price', 'height', 'daily_quota', 'status'
        ]);

        if ($request->hasFile('image')) {
            if ($mountain->image_url && Storage::disk('public')->exists($mountain->image_url)) {
                Storage::disk('public')->delete($mountain->image_url);
            }
            $path = $request->file('image')->store('mountains', 'public');
            $mountainData['image_url'] = $path;
        }
        
        $mountain->update($mountainData);
        
        return redirect()->route('admin.mountains.index')->with('success', 'Mountain updated successfully.');
    }

    public function destroy(Mountain $mountain)
    {
        if ($mountain->image_url && Storage::disk('public')->exists($mountain->image_url)) {
            Storage::disk('public')->delete($mountain->image_url);
        }
        
        $mountain->delete();
        return redirect()->route('admin.mountains.index')->with('success', 'Mountain deleted successfully.');
    }
}