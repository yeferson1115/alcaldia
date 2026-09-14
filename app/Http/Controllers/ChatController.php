<?php
 namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\Message;
 use App\Models\Chat;
 use App\Events\MessageSent;
 use App\Events\ChatGuest;

 use Illuminate\Support\Str;
 
 class ChatController extends Controller
 {
    public function index(){
        return view('chat.chat'); 
    }
    public function startChat(Request $request)
    {
        $guest_id = $request->session()->get('guest_id', Str::uuid());
        $request->session()->put('guest_id', $guest_id);
    
        $chat = Chat::firstOrCreate(['guest_id' => $guest_id], ['status' => 'pendiente']); // Status pendiente al inicio
    
        return response()->json(['chat_id' => $chat->id]);
    }
    public function attendChat($chatId)
        {
            $chat = Chat::findOrFail($chatId);
            $chat->status = 'atendido'; // Cambiar el estado a atendido
            $chat->user_id = auth()->id(); // Asignar al agente que lo está atendiendo
            $chat->save();

            return response()->json(['success' => true]);
        }

public function getPendingChats()
{
    $chats = Chat::where('status', 'pendiente')->with('messages')->get();
    return response()->json($chats);
}

    // Obtener mensajes en un chat
    public function getMessages($chat_id)
    {
        $messages = Message::where('chat_id', $chat_id)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }

    // Enviar mensaje
    public function sendMessage(Request $request)
    {
        $chat = Chat::findOrFail($request->chat_id);
        
        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'guest_id' => $request->session()->get('guest_id'),
            'message' => $request->message,
        ]);

        return response()->json($message);
    }

    public function adminView()
{
    $chats = Chat::with('messages')->get();
    return view('chat.index', compact('chats'));
}

    public function getActiveChats()
    {
        // Si eres un agente, puedes filtrar los chats pendientes
        $userId = auth()->id();
    
        $chats = Chat::where('status', '<>', 'finalizado')
        ->where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->orWhereNull('user_id');
        })
        ->with('messages')  // Cargar los mensajes relacionados
        ->get();

        return response()->json($chats);
    }


 }


 