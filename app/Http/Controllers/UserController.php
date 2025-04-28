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
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
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

    public function destroy(Request $request){
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
            $user->role = $request->role;
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
                if(!$user){
                    return response()->json([
                        'status' => false,
                        'message' => 'User not found'
                    ], 404);
                }
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
