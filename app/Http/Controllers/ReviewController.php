<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'message' => 'required|string|min:10|max:1000',
        'rating' => 'nullable|integer|min:1|max:5',
    ]);

    Review::create([
        'name' => $validated['name'],
        'email' => $validated['email'] ?? null,
        'message' => $validated['message'],
        'rating' => $validated['rating'] ?? 5,
        'is_approved' => true,
    ]);

    return back()->with('success', 'Спасибо за ваш отзыв!');
}
}
