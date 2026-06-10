<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Contracts\AIChatServiceInterface;

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
        $sessions = Message::select('session_id')
            ->groupBy('session_id')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($sessions as $session) {
            $session->last_message = Message::where('session_id', $session->session_id)
                ->orderBy('created_at', 'desc')
                ->first();
            $session->unread_count = Message::where('session_id', $session->session_id)
                ->where('sender_type', 'customer')
                ->where('is_read', false)
                ->count();
        }

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
        $request->validate(['message' => 'required|string|max:1000']);
        $sessionId = $request->session()->getId();

        // 1. Save Customer Message
        $message = Message::create([
            'session_id' => $sessionId,
            'sender_type' => 'customer',
            'message' => $request->message
        ]);

        // 2. Broadcast Customer Message
        broadcast(new MessageSent($message))->toOthers();

        // 3. Prepare Context & History for AI
        $history = Message::where('session_id', $sessionId)
            ->where('id', '<', $message->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->reverse()
            ->map(fn($m) => [
                'role' => $m->sender_type,
                'content' => $m->message
            ])->toArray();

        $products = Product::limit(15)->get(['name', 'price']);
        $settings = \App\Models\Setting::first();
        
        $context = [
            'products' => $products,
            'store_info' => $settings ? [
                'nama_toko' => $settings->site_name,
                'alamat' => $settings->address,
                'whatsapp' => $settings->whatsapp_number,
                'email' => $settings->email,
            ] : []
        ];

        // 4. Process AI Bot Response
        $botReply = $this->aiService->getResponse($message->message, $context, $history);

        if ($botReply) {
            $botMsg = Message::create([
                'session_id' => $sessionId,
                'sender_type' => 'bot',
                'message' => $botReply
            ]);
            
            broadcast(new MessageSent($botMsg));
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
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'session_id' => $request->session_id,
            'sender_type' => 'admin',
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message));

        return response()->json(['status' => 'success']);
    }
}
