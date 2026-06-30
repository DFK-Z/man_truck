<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ✅ ПРАВИЛЬНЫЙ СПОСОБ ДЛЯ LARAVEL 12
    public function store(Request $request)
    {
        // Проверяем, авторизован ли пользователь
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Чтобы оставить отзыв, войдите в систему.');
        }

        $validated = $request->validate([
            'message' => 'required|string|min:3|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'rating' => $validated['rating'] ?? 5,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Спасибо за ваш отзыв!');
    }
}
