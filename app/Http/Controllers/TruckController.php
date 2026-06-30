<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\Review;

class TruckController extends Controller
{
public function index()
{
    $trucks = Truck::all(); // ← УБИРАЕМ where('is_available', true)
    $reviews = Review::with('user')->latest()->take(6)->get();
    $reviews = Review::where('is_approved', true)->with('user')->latest()->take(6)->get();
    return view('welcome', compact('trucks', 'reviews'));
}

    public function create()
    {
        return view('trucks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'engine' => 'nullable|string',
            'transmission' => 'nullable|string',
            'mileage' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
        ]);

        Truck::create($validated);
        return redirect()->route('trucks.index')->with('success', 'Грузовик добавлен!');
    }

    public function show(Int $id)
    {
        $truck = Truck::findOrFail($id);
        $truck->increment('views');
        return view('truck-detail', compact('truck'));
    }

    public function edit(Truck $truck)
    {
        return view('trucks.edit', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'engine' => 'nullable|string',
            'transmission' => 'nullable|string',
            'mileage' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
        ]);

        $truck->update($validated);
        return redirect()->route('trucks.index')->with('success', 'Грузовик обновлен!');
    }

    public function destroy(Truck $truck)
    {
        $truck->delete();
        return redirect()->route('trucks.index')->with('success', 'Грузовик удален!');
    }
}
