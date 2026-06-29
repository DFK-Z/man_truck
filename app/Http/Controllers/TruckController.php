<?php

namespace App\Http\Controllers;

use App\Models\Truck;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::where('is_available', true)->latest()->get();
        return view('welcome', compact('trucks'));
    }
}
