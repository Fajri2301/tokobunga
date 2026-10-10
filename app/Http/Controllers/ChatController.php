<?php

namespace App\Http\Controllers;

use App\Contracts\AIChatServiceInterface;
use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    protected AIChatServiceInterface $aiService;

    public function __construct(AIChatServiceInterface $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Display the admin chat interface.
     */
    public function index()
    {
        $sessions = Message::query()
            ->select('session_id')
            ->selectRaw('MAX(id) as last_message_id')
            ->selectRaw("SUM(CASE WHEN sender_type = 'customer' AND is_read = 0 THEN 1 ELSE 0 END) as unread_count")
            ->groupBy('session_id')
            ->orderByDesc('last_message_id')
            ->get();

        $lastMessages = Message::whereIn('id', $sessions->pluck('last_message_id'))
            ->get()
            ->keyBy('id');

        $sessions->each(function (Message $session) use ($lastMessages): void {
            $session->last_message = $lastMessages->get($session->last_message_id);
        });

        return view('admin.chat.index', compact('sessions'));
    }

    /**
     * Get messages for a specific session (for admin).
     */
    public function getSessionMessages($sessionId)
    {
        Message::where('session_id', $sessionId)
            ->where('sender_type', '!=', 'admin')
            ->update(['is_read' => true]);

        return Message::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Get messages for the current session (for customer).
     */
    public function getMessages(Request $request)
    {
        $sessionId = $request->session()->getId();

        return Message::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Send a message from the customer.
     */
    public function sendMessage(Request $request)
    {
        $request->validate(['message' => ['required', 'string', 'max:1000']]);
        $sessionId = $request->session()->getId();

        // 1. Save Customer Message
        $message = Message::create([
            'session_id' => $sessionId,
            'sender_type' => 'customer',
            'message' => $request->string('message')->trim()->value(),
        ]);
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            Log::error('Broadcast failed: '.$e->getMessage());
        }

        // 2. Prepare Context & History for AI
        $history = Message::where('session_id', $sessionId)
            ->where('id', '<', $message->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->reverse()
            ->map(fn ($m) => ['role' => $m->sender_type, 'content' => $m->message])
            ->toArray();

        $products = Product::limit(15)->get(['name', 'price']);
        $settings = Setting::first();
        $context = [
            'products' => $products,
            'store_info' => $settings ? [
                'nama_toko' => $settings->site_name, 'alamat' => $settings->address,
                'whatsapp' => $settings->whatsapp_number, 'email' => $settings->email,
            ] : [],
        ];

        // 3. Get AI Response (can be string or array)
        $aiResponse = $this->aiService->getResponse($message->message, $context, $history);

        // 4. Process AI Response
        if ($aiResponse) {
            $botMessage = 'Maaf, saya tidak mengerti.'; // Default text
            $metadata = null;

            if (is_array($aiResponse) && isset($aiResponse['action'])) {
                // Handle JSON command
                if ($aiResponse['action'] === 'show_image' && isset($aiResponse['product_name'])) {
                    $productName = $aiResponse['product_name'];
                    $product = Product::where('name', 'like', '%'.$productName.'%')->first();

                    if ($product) {
                        $botMessage = 'Tentu, ini dia gambar untuk '.$product->name.':';

                        // Check if image is an absolute URL or a local path
                        $imageUrl = str_starts_with((string) $product->image, 'http')
                            ? $product->image
                            : Storage::url($product->image);

                        $metadata = ['image_url' => $imageUrl];
                    } else {
                        $botMessage = "Maaf, saya tidak dapat menemukan produk dengan nama '".$productName."'.";
                    }
                }
            } elseif (is_string($aiResponse)) {
                // Handle simple text response
                $botMessage = $aiResponse;
            }

            $botMsg = Message::create([
                'session_id' => $sessionId,
                'sender_type' => 'bot',
                'message' => $botMessage,
                'metadata' => $metadata,
            ]);

            try {
                broadcast(new MessageSent($botMsg));
            } catch (\Throwable $e) {
                Log::error('Broadcast failed: '.$e->getMessage());
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Admin sends a message to a specific session.
     */
    public function adminSendMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = Message::create([
            'session_id' => $request->session_id,
            'sender_type' => 'admin',
            'message' => $request->string('message')->trim()->value(),
        ]);

        try {
            broadcast(new MessageSent($message));
        } catch (\Throwable $e) {
            Log::error('Broadcast failed: '.$e->getMessage());
        }

        return response()->json(['status' => 'success']);
    }
}
