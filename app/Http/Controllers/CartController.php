<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;

    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cart = $this->cartService->getCartWithDetails();
        $total = $this->cartService->getTotal();

        return view('pages.cart', compact('cart', 'total'));
    }

    public function add(int $id)
    {
        $cart = $this->cartService->addToCart((int) $id);

        return response()->json([
            'status' => 'success',
            'cart_count' => count($cart),
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $this->cartService->updateQuantity($validated['id'], $validated['quantity']);

        return response()->json(['status' => 'success']);
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
        ]);

        $this->cartService->removeFromCart($validated['id']);

        return response()->json(['status' => 'success']);
    }

    public function checkout(CheckoutRequest $request)
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return response()->json(['status' => 'error', 'message' => 'Keranjang kosong!'], 400);
        }

        try {
            $waUrl = $this->orderService->processCheckout($request->validated(), $cart);

            $this->cartService->clear();

            return response()->json([
                'status' => 'success',
                'redirect_url' => $waUrl,
            ]);
        } catch (\Exception $e) {
            Log::error('Checkout Error: '.$e->getMessage(), [
                'customer_phone' => $request->input('customer_phone'),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan pesanan. Silakan coba lagi.',
            ], 500);
        }
    }
}
