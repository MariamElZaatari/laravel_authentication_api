<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Validator;

class MessageController extends Controller
{

    // -------- Create Message Method --------
    public function create(Request $request)
    {
        // Validate Request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:50',
            'subject' => 'required|string|max:20',
            'text' => 'required|string|between:3,500',
        ]);

        // If validator fails, json encode error with status
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // if validated, create message
        $message = Message::create($validator->validated());

        // Return message along with success message and status
        return response()->json([
            'message' => 'Message successfully added',
            'message_info' => $message,
        ], 201);
    }
    // ---------------------------------------
    
}
