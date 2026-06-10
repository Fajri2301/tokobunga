<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\About;
use App\Models\Review;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function home()
    {
        $ttl = 3600; // 1 Hour

        // If in debug mode, ignore cache to see changes immediately
        if (config('app.debug')) {
            \Illuminate\Support\Facades\Cache::flush();
        }

        $categories = \Illuminate\Support\Facades\Cache::remember('categories_all', $ttl, function() {
            return Category::all();
        });

        $featuredProducts = \Illuminate\Support\Facades\Cache::remember('featured_products', $ttl, function() {
            return Product::with('category')->where('is_featured', true)->take(4)->get();
        });

        $banners = \Illuminate\Support\Facades\Cache::remember('banners_hero_active', $ttl, function() {
            return Banner::where('is_active', true)->where('type', 'hero')->latest()->get();
        });

        $adBanner = \Illuminate\Support\Facades\Cache::remember('ad_banner_iklan_active', $ttl, function() {
            return Banner::where('is_active', true)->where('type', 'iklan')->latest()->first();
        });

        $approvedReviews = \Illuminate\Support\Facades\Cache::remember('approved_reviews', $ttl, function() {
            return Review::where('is_approved', true)->latest()->get();
        });
        
        $about = \Illuminate\Support\Facades\Cache::remember('about_data', $ttl, function() {
            return About::first() ?? new About([
                'title' => 'Membawa Kesegaran',
                'subtitle' => 'Alam ke Ruangan Anda',
                'description_1' => 'TokoBunga lahir dari kecintaan kami terhadap seni merangkai bunga.',
                'description_2' => 'Setiap koleksi kami dirangkai dengan tangan-tangan ahli menggunakan bunga segar pilihan.',
                'experience_years' => '10+',
                'clients_count' => '5K+',
                'fresh_flowers_pct' => '100%'
            ]);
        });

        $homeCategories = \Illuminate\Support\Facades\Cache::remember('home_categories', $ttl, function() {
            return Category::where('is_active_on_home', true)
                ->with(['products' => function($query) {
                    $query->latest()->take(4);
                }])
                ->get();
        });

        return view('home', compact('categories', 'featuredProducts', 'banners', 'adBanner', 'about', 'homeCategories', 'approvedReviews'));
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('catalog.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
