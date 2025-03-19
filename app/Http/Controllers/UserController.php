<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function store(Request $request){

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,',
                'password' => 'required|string|min:6',
                'exam' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->exam = $request->exam;
            $user->save();

            return response()->json([
                'status' => true,
                'data' => $user
            ]);

        }catch(\Throwable $e){
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destory(Request $request){
        try{
            $user = User::find($request->id);
            $user->delete();
        }catch(\Throwable $e){
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request){
        try{
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->exam = $request->exam;
            $user->save();

            return response()->json([
                'status' => true,
                'data' => $user
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request){
        try{
            if($request->id){
                $user = User::find($request->id);
                return response()->json([
                    'status' => true,
                    'data' => $user
                ]);
            }
            $user = User::all();
            return response()->json([
                'status' => true,
                'data' => $user
            ]);
            
        }catch(\Throwable $e){
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
