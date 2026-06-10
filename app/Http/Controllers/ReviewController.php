<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        Review::create([
            'name' => strip_tags($request->name),
            'rating' => $request->rating,
            'comment' => strip_tags($request->comment),
            'is_approved' => false,
        ]);

        return back()->with('success_review', 'Terima kasih! Ulasan Anda telah terkirim dan akan tampil setelah disetujui admin.');
    }
}
