<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\ScoreModel;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            if($request->id) {
                $data = ScoreModel::find($request->id);
                if(!$data) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Score not found'
                    ], 404);
                }
                return response()->json([
                    'status' => true,
                    'data' => $data,
                ]);
            }
            return response()->json([
                'status' => true,
                'data' => ScoreModel::all()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $score = new ScoreModel();
            $score->uuid = Uuid::uuid4();;
            $score->id_user = $request->id_user;
            $score->score = $request->score;
            $score->status = $request->status;
            $score->save();

            return response()->json([
                'status' => true,
                'data' => $score
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $score = ScoreModel::find($request->id);
            if(!$score) {
                return response()->json([
                    'status' => false,
                    'message' => 'Score not found'
                ], 404);
            }
            $score->delete();
            return response()->json([
                'status' => true,
                'message' => 'Score deleted'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request){
        try {
            $score = ScoreModel::find($request->id);
            if(!$score) {
                return response()->json([
                    'status' => false,
                    'message' => 'Score not found'
                ], 404);
            }
            $score->uuid = $request->uuid;
            $score->id_user = $request->id_user;
            $score->score = $request->score;
            $score->status = $request->status;
            $score->save();

            return response()->json([
                'status' => true,
                'data' => $score
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
