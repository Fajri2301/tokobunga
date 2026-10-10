<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Support\StorefrontCache;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        StorefrontCache::forget();

        return back()->with('success', 'Ulasan berhasil disetujui.');
    }

    public function unapprove(Review $review)
    {
        $review->update(['is_approved' => false]);
        StorefrontCache::forget();

        return back()->with('success', 'Ulasan berhasil disembunyikan.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        StorefrontCache::forget();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
