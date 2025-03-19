<?php

namespace App\Http\Controllers;
use App\Models\ExamModel;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        try {
            if($request->id) {
                return response()->json([
                    'status' => true,
                    'data' => ExamModel::find($request->id),
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => ExamModel::all()
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
