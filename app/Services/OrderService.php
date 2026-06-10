<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Process the checkout and return the WhatsApp redirect URL.
     */
    public function processCheckout(array $customerData, array $cart)
    {
        $total = $this->calculateTotal($cart);

        return DB::transaction(function () use ($customerData, $cart, $total) {
            // 1. Create Order
            $order = Order::create([
                'order_number' => 'INV-' . strtoupper(Str::random(8)),
                'customer_name' => $customerData['customer_name'],
                'customer_phone' => $customerData['customer_phone'],
                'customer_address' => $customerData['customer_address'],
                'total_price' => $total,
            ]);

            // 2. Create Items & Build Text
            $itemsText = "";
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $details['name'],
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                ]);
                $itemsText .= "- " . $details['name'] . " (" . $details['quantity'] . "x) \n";
            }

            // 3. Broadcast real-time event
            broadcast(new \App\Events\NewOrderEvent($order))->toOthers();

            // 4. Generate WhatsApp Link
            return $this->generateWhatsAppLink($order, $itemsText, $total);
        });
    }

    /**
     * Calculate total from cart session.
     */
    private function calculateTotal(array $cart): float
    {
        return array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
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
        $message .= $itemsText . "\n";
        $message .= "💰 *Total Tagihan:* Rp " . number_format($total, 0, ',', '.') . "\n";
        $message .= "------------------------------------------\n\n";
        $message .= "📍 *Data Pengiriman:*\n";
        $message .= "👤 *Nama:* {$order->customer_name}\n";
        $message .= "📞 *HP:* {$order->customer_phone}\n";
        $message .= "🏠 *Alamat:* {$order->customer_address}\n\n";
        $message .= "Mohon segera diproses ya, terima kasih! 🙏";

        return "https://api.whatsapp.com/send?phone={$waNumber}&text=" . urlencode($message);
    }

    /**
     * Sanitize phone number to E.164-ish format for WhatsApp.
     */
    private function sanitizePhoneNumber(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        return $number;
    }
}
