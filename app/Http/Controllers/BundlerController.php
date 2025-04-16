<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\BundlerModel;
use Illuminate\Http\Request;

class BundlerController extends Controller
{
    //
    
    public function store(Request $request){
        try {
            $bundler = new BundlerModel();
            $bundler->uuid = Uuid::uuid4();
            $bundler->id_exam = $request->id_exam;
            $bundler->id_quest = $request->id_quest;
            $bundler->save();

            return response()->json([
                'status' => true,
                'data' => $bundler
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request){
        try {
            $bundler = BundlerModel::find($request->uuid);
            if(!$bundler) {
                return response()->json([
                    'status' => false,
                    'message' => 'Bundler not found'
                ], 404);
            }
            $bundler->delete();
            return response()->json([
                'status' => true,
                'message' => 'Bundler deleted'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
}
