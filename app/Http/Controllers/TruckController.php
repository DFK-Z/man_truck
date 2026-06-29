<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('trucks'));
    }

    public function show(int $id)
    {
        $truck = Truck::findOrFail($id);
        $truck->increment('views');

        return view('truck-detail', compact('truck'));
    }
}
