<?php

namespace App\Services;

use App\Events\NewOrderEvent;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class OrderService
{
    /**
     * Process the checkout and return the WhatsApp redirect URL.
     *
     * Harga & nama produk SELALU diambil ulang dari database,
     * bukan dari session cart, agar order tidak bisa memakai harga basi.
     */
    public function processCheckout(array $customerData, array $cart): string
    {
        $products = Product::query()
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        $lines = [];
        foreach ($cart as $id => $details) {
            $product = $products->get($id);
            $quantity = (int) ($details['quantity'] ?? 0);

            // Produk sudah dihapus / qty tidak valid → lewati item ini
            if (! $product || $quantity < 1) {
                continue;
            }

            $lines[] = ['product' => $product, 'quantity' => $quantity];
        }

        if (empty($lines)) {
            throw new InvalidArgumentException('Tidak ada item yang valid di keranjang.');
        }

        $total = array_reduce($lines, function ($carry, $line) {
            return $carry + ((float) $line['product']->price * $line['quantity']);
        }, 0.0);

        return DB::transaction(function () use ($customerData, $lines, $total) {
            // 1. Create Order
            $order = Order::create([
                'order_number' => 'INV-'.strtoupper(Str::random(8)),
                'customer_name' => $customerData['customer_name'],
                'customer_phone' => $customerData['customer_phone'],
                'customer_address' => $customerData['customer_address'],
                'total_price' => $total,
            ]);

            // 2. Create Items & Build Text
            $itemsText = '';
            foreach ($lines as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $line['product']->id,
                    'product_name' => $line['product']->name,
                    'price' => $line['product']->price,
                    'quantity' => $line['quantity'],
                ]);
                $itemsText .= '- '.$line['product']->name.' ('.$line['quantity']."x) \n";
            }

            // 3. Broadcast real-time event (ditunda sampai transaksi commit)
            broadcast(new NewOrderEvent($order))->toOthers();

            // 4. Generate WhatsApp Link
            return $this->generateWhatsAppLink($order, $itemsText, $total);
        });
    }

    /**
     * Generate formatted WhatsApp URL.
     */
    private function generateWhatsAppLink(Order $order, string $itemsText, float $total): string
    {
        $setting = app('settings');
        $waNumber = $this->sanitizePhoneNumber($setting->whatsapp_number ?? '628123456789');
        $siteName = $setting->site_name ?? 'Toko Bunga';

        $message = "🛍️ *PESANAN BARU - {$order->order_number}*\n";
        $message .= "------------------------------------------\n";
        $message .= "Halo *{$siteName}*, saya ingin memesan:\n\n";
        $message .= $itemsText."\n";
        $message .= '💰 *Total Tagihan:* Rp '.number_format($total, 0, ',', '.')."\n";
        $message .= "------------------------------------------\n\n";
        $message .= "📍 *Data Pengiriman:*\n";
        $message .= "👤 *Nama:* {$order->customer_name}\n";
        $message .= "📞 *HP:* {$order->customer_phone}\n";
        $message .= "🏠 *Alamat:* {$order->customer_address}\n\n";
        $message .= 'Mohon segera diproses ya, terima kasih! 🙏';

        return "https://api.whatsapp.com/send?phone={$waNumber}&text=".urlencode($message);
    }

    /**
     * Sanitize phone number to E.164-ish format for WhatsApp.
     */
    private function sanitizePhoneNumber(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        if (str_starts_with($number, '0')) {
            $number = '62'.substr($number, 1);
        }

        return $number;
    }
}
