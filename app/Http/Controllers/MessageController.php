<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Validator;

class MessageController extends Controller
{
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:50',
            'subject' => 'required|string|max:20',
            'text' => 'required|string|between:3,500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $message = Message::create($validator->validated());

        return response()->json([
            'message' => 'Message successfully added',
            'message_info' => $message,
        ], 201);

    }
}
