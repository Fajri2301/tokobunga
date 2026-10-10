<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Support\StorefrontCache;

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
        StorefrontCache::forget();

        return back()->with('success_review', 'Terima kasih! Ulasan Anda telah terkirim dan akan tampil setelah disetujui admin.');
    }
}
