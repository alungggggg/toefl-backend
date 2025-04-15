<?php

namespace App\Http\Controllers;

use App\Models\BundlerModel;
use App\Models\ExamModel;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->id) {
                $exam = ExamModel::find($request->id);
                $exam->quest = BundlerModel::where('id_exam', $exam->uuid)->with(["quest", "quest.options"])->get("id_quest")->pluck("quest");
                if(!$exam) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Exam not found'
                    ], 404);
                }
                return response()->json([
                    'status' => true,
                    'data' => $exam,
                ]);
            }
            $data = ExamModel::with('quest.quest.options')->get()->map(function ($exam) {
                return [
                    'uuid' => $exam->uuid,
                    'name' => $exam->name,
                    'code' => $exam->code,
                    'access' => $exam->access,
                    'expired' => $exam->expired,
                    'bundler' => $exam->quest->map(function ($bundler) use ($exam) {
                        return [
                            $bundler->quest, 
                        ];
                    }),
                ];
            });

            return response()->json([
                'status' => true,
                'data' => $data
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
            $exam = new ExamModel();
            $exam->name = $request->name;
            $exam->quest_id = $request->quest_id;
            $exam->code = $request->code;
            $exam->access = $request->access;
            $exam->expired = $request->expired;
            $exam->save();

            return response()->json([
                'status' => true,
                'data' => $exam
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        try {
            $exam = ExamModel::find($request->id);
            $exam->name = $request->name;
            $exam->quest_id = $request->quest_id;
            $exam->code = $request->code;
            $exam->access = $request->access;
            $exam->expired = $request->expired;
            $exam->save();

            return response()->json([
                'status' => true,
                'data' => $exam
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
            $exam = ExamModel::find($request->id);
            $exam->delete();

            BundlerModel::where('id_exam', $exam->uuid)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Exam deleted successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
