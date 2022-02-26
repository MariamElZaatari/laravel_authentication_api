<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function update(Request $request)
    {

        if (auth()->user()->id == $request->id) {
            $validator = Validator::make($request->all(), [
                'id' => 'required|integer',
                'first_name' => 'required|string|between:2,100',
                'last_name' => 'required|string|between:2,100',
                'phone' => 'required|string|size:8',
                'gender' => 'required|string|between:0,1',
                'age' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            }

            User::where('id', $request->id)
                ->update($validator->validated());

            $user = User::find($request->id);

            return response()->json([
                'message' => 'User Successfully Updated',
                'user' => $user,
            ], 202);
        }

        return response()->json([
            'message' => 'Not Authorized',
        ], 401);

    }

    public function delete($id)
    {
        if (auth()->user()->id == $id) {
            $user = User::find((int) $id);

            $user->delete();

            return response()->json([
                'message' => 'User Successfully Deleted',
                'user' => $user,
            ], 202);
        }

        return response()->json([
            'message' => 'Not Authorized',
        ], 401);
    }
}
