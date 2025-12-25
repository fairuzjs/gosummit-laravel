<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\TrailRoute;
use Illuminate\Http\Request;

class TrailRouteController extends Controller
{
    public function store(Request $request, Mountain $mountain)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $mountain->trailRoutes()->create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'open',
        ]);

        return redirect()->back()->with('success', 'Trail route added successfully.');
    }

    public function toggleStatus(Mountain $mountain, TrailRoute $trail_route)
    {
        $trail_route->update([
            'status' => $trail_route->status === 'open' ? 'closed' : 'open'
        ]);

        return redirect()->back()->with('success', 'Trail route status updated.');
    }

    public function destroy(Mountain $mountain, TrailRoute $trail_route)
    {
        $trail_route->delete();
        return redirect()->back()->with('success', 'Trail route deleted successfully.');
    }
}