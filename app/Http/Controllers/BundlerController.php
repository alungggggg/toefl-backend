<?php

namespace App\Http\Controllers;

use App\Models\BundlerModel;
use Illuminate\Http\Request;

class BundlerController extends Controller
{
    //
    
    public function store(Request $request){
        try {
            $bundler = new BundlerModel();
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

    public function destroy($idExam, $idQuest){
        try {
            $bundler = BundlerModel::where('id_exam', $idExam)->where('id_quest', $idQuest)->delete();
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
