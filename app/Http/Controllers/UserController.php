<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    // --------- Update Method -----------
    public function update(Request $request)
    {
        // Check if user is authorized to update info
        if (auth()->user()->id == $request->id) {
            // Validate Request
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'first_name' => 'required|string|alpha|between:2,100',
                'last_name' => 'required|string|alpha|between:2,100',
                'phone' => 'required|string|size:8|regex:/^[0-9]+$/',
                'gender' => 'required|string|between:0,1',
                'age' => 'required|numeric|integer|min:12|max:99',
            ]);

            // If validator fails, json encode error with status
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            // Update user info where id=request.id
            User::where('id', $request->id)
                ->update($validator->validated());

            // Select * from user where id=request.id
            $user = User::find($request->id);

            // Return user along with success message and status
            return response()->json([
                'message' => 'User Successfully Updated',
                'user' => $user,
            ], 202);
        }

        // if user not authorized to update
        return response()->json([
            'message' => 'Not Authorized',
        ], 401);

    }
    // -----------------------------------
    
    // --------- Delete Method -----------
    public function delete($id)
    {
        // Check if user is authorized to delete account
        if (auth()->user()->id == $id) {
            
            //Select * from user where id=$id
            $user = User::find((int) $id);
            
            $user->delete();
            
            // Return user along with success message and status
            return response()->json([
                'message' => 'User Successfully Deleted',
                'user' => $user,
            ], 202);
        }

        // if user not authorized to delete
        return response()->json([
            'message' => 'Not Authorized',
        ], 401);
    }
    // -----------------------------------
}
