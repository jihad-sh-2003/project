<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // عرض كل الرسائل للمستخدم
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $messages = Message::with(['sender','receiver','property'])
            ->where('sender_id', $userId)
            ->orWhere('reciver_id', $userId)
            ->get();

        return response()->json($messages);
    }

    // إنشاء رسالة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'reciver_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id'
        ]);

        $message = Message::create([
            'content' => $request->content_message,
            'sender_id' => $request->user()->id,
            'reciver_id' => $request->reciver_id,
            'property_id' => $request->property_id,
        ]);

        return response()->json($message, 201);
    }

    // عرض رسالة واحدة
    public function show($id)
    {
        $message = Message::with(['sender','receiver','property'])->findOrFail($id);

        return response()->json($message);
    }

    // تحديث رسالة (مثلاً تعديل المحتوى)
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        // فقط المرسل يمكنه تعديل رسالته
        if ($message->sender_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string'
        ]);

        $message->update([
            'content' => $request->content_message
        ]);

        return response()->json($message);
    }

    // حذف رسالة
    public function destroy(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        // فقط المرسل أو المستقبل يمكنه الحذف
        if (!in_array($request->user()->id, [$message->sender_id, $message->reciver_id])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }
}
