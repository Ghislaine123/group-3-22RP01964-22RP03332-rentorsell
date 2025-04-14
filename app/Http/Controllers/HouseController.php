<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        $query = House::with('seller')->where('status', 'available');

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by type
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Filter by price range
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort results
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $houses = $query->paginate(10)->withQueryString();

        return view('houses.index', compact('houses'));
    }

    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'type' => 'required|in:rent,sale',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('houses', $imageName, 'public');
            $data['image_url'] = 'storage/' . $path;
        }

        $house = auth()->user()->houses()->create($data);

        return redirect()->route('houses.show', $house)
            ->with('success', 'House listed successfully.');
    }

    public function show(House $house)
    {
        return view('houses.show', compact('house'));
    }

    public function edit(House $house)
    {
        Gate::authorize('update', $house);
        return view('houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        Gate::authorize('update', $house);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'type' => 'required|in:rent,sale',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($house->image_url) {
                $oldPath = str_replace('storage/', '', $house->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('houses', $imageName, 'public');
            $data['image_url'] = 'storage/' . $path;
        }

        $house->update($data);

        return redirect()->route('houses.show', $house)
            ->with('success', 'House updated successfully.');
    }

    public function destroy(House $house)
    {
        Gate::authorize('delete', $house);
        $house->delete();

        return redirect()->route('houses.index')
            ->with('success', 'House deleted successfully.');
    }
}